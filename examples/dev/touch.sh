#!/usr/bin/env sh

set -e

curl -X POST http://%host%:9501/touch/test1234/touch
