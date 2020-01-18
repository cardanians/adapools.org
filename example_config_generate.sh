#
# how with api generate new config with fresh peer list
# use this before every bootstrapping
# more info: https://adapools.org/api
#
# example :
# curl -d "api_key=KEY&storage=STORAGE&cpu=NUM_OF_CPUS" -X POST https://api.adapools.org/v0/config/ -o /where/is/located/config.yaml
#
# possible include this into "anti-stucking" script
3

curl -d "api_key=ABCABCABC&storage=/root/storage&cpu=4" -X POST https://api.adapools.org/v0/config/ -o /root/config.yaml

