#!/usr/bin/env sh

set -e

curl -X POST -H "Content-Type:application/json" -d '{"data":"\nTest Appended Data"}' http://%host%:9501/append/test1234/test_store
