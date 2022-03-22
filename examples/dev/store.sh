#!/usr/bin/env sh

set -e

curl -X POST -H "Content-Type:application/json" -d '{"data":"Test Data"}' http://%host%:9501/store/test1234/test_store
