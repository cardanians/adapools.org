# Create own dashboard for my pool

## Requirements:
* active ekg (prometheus) port in cardano-node config
* configure cron with one simple command (if you want monitor 2 relays and 1 bp, then you need these registration absolve 3 times)
*update extended file (not required, but recommended)

## 1. Get prometheus port

Connect to your server and open mainnet-config.json and check your hasPrometheus port.

## 2. Set up periodical cron task

Execute: 
> crontab -e and add there new line:

> */15 * * * * sleep 10s && wget -O /dev/null -o /dev/null --post-data="$(curl http://127.0.0.1:hasPrometheusPORT/metrics)" --no-check-certificate "https://w1.adapools.org?pub=___PUBLIC___&priv=___PRIV___" >/dev/null 2>&1
and save. 

## More info: https://adapools.org/connect
