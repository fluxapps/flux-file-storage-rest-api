#!/usr/bin/env sh

set -e

curl -X POST http://%host%:9501/copy/test1234/test_store?to_path=/test1234/copy_of_test_store
