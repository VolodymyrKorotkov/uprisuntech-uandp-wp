#!/bin/bash

# shellcheck disable=SC2164
# shellcheck disable=SC2046
cd $(dirname "$0")/../

git pull && \
docker-compose restart && \
docker-compose up -d