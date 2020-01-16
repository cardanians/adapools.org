#!/bin/bash
#
# You need created account there: https://adapools.org/
# Sign In and add your node to monitoring - you need insert node_id. After submit you will receive "YOUR_KEY"
#
# Call this script ONLY when you receive new block (typically add it to "stucked monitors" etc.
#

JSON=$($JCLI rest v0 node stats get --host "http://127.0.0.1:${JCLI_PORT}/api" --output-format json)
wget -O /dev/null -o /dev/null --post-data="${JSON}" --no-check-certificate  "https://api.adapools.org?key=YOUR_KEY" >/dev/null
