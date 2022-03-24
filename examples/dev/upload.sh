#!/usr/bin/env sh

set -e

curl -X POST -F "file=@example_file.zip" http://%host%:9501/upload/example_file.zip
