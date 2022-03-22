#!/usr/bin/env sh

set -e

curl -X DELETE http://%host%:9501/delete/test1234/test_store
