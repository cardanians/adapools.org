#!/bin/bash
#
# Created by Uruncle @ https://adage.app Cardano Stake Pool
# Modified by https://adapools.org/
#
# Disclaimer:
#
#  The following use of shell script is for demonstration and understanding
#  only, it should *NOT* be used at scale or for any sort of serious
#  deployment, and is solely used for learning how the node and blockchain
#  works, and how to interact with everything.
#
# You need "screen" - first, execute command: screen -dmS ada sh
# Then open another screen window (execute command: screen) and run in this screen this script: ./where/is/stored/stucked.sh
# Script monitors your node, when is stucked, after restart; when new block, auto notify to adapools.org
#
# Get your "YOUR_KEY" = https://github.com/cardanians/adapools.org/blob/master/send_tip.sh
#
### CONFIGURATION
export PATH=$PATH:/root/.cargo/bin
JCLI="jcli"
JCLI_PORT=3100
LAST_BLOCK=""
START_TIME=$SECONDS
RESTART_GT=300

while true
do
    TIME=$(date '+%Y-%m-%d %H:%M:%S')
    LATEST_BLOCK=$($JCLI rest v0 node stats get --host "http://127.0.0.1:${JCLI_PORT}/api" | grep lastBlockHeight | awk '{print $2}')

    if [ "$LATEST_BLOCK" > 0 ]; then
        if [ "$LATEST_BLOCK" != "$LAST_BLOCK" ]; then
            START_TIME=$(($SECONDS))
            echo "${TIME} New block height: ${LATEST_BLOCK}"
            JSON=$($JCLI rest v0 node stats get --host "http://127.0.0.1:${JCLI_PORT}/api" --output-format json)
            wget -O /dev/null -o /dev/null --post-data="${JSON}" --no-check-certificate  "https://api.adapools.org?key=YOUR_KEY" >/dev/null        
            LAST_BLOCK="$LATEST_BLOCK"
        else
            ELAPSED_TIME=$(($SECONDS - $START_TIME))
            echo "${TIME} Current block height: ${LATEST_BLOCK} - No new block for ${ELAPSED_TIME} sec."
            if [ "$ELAPSED_TIME" -gt "$RESTART_GT" ]; then
                echo ""
                echo "${TIME} Restarting jormungandr"
                jcli rest v0 shutdown get --host "http://127.0.0.1:${JCLI_PORT}/api"
                sleep 5
                screen -S ada -X stuff "jormungandr --config /root/config.yaml --genesis-block-hash 8e4d2a343f3dcf9330ad9035b3e8d168e6728904262f2c434a4f8f934ec7b676 --secret /root/secret.yaml
"
                LAST_BLOCK="$LATEST_BLOCK"
                sleep 5
                renice -15 -p $(pgrep jormungandr) && renice -16 -p $(pgrep systemd)
            fi
        fi
    else
        echo "No block height"
        
        if pgrep -x "jormungandr" >/dev/null 
        then
					 echo " / is running"
				else
					screen -S ada -X stuff "jormungandr --config /root/config.yaml --genesis-block-hash 8e4d2a343f3dcf9330ad9035b3e8d168e6728904262f2c434a4f8f934ec7b676 --secret /root/secret.yaml
"
					renice -15 -p $(pgrep jormungandr) && renice -16 -p $(pgrep systemd)
			fi
        
        # Reset time
        START_TIME=$(($SECONDS))
    fi
    sleep 20
done

exit 0
