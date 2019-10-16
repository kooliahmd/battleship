#!/usr/bin/env bash

set -o allexport && source .env && set +o allexport
#cat key-file.json | docker login -u _json_key --password-stdin gcr.io

gcloud auth activate-service-account --key-file key-file.json

docker build -f docker/nginx/Dockerfile ../ -t gcr.io/$GCLOUD_PROJECT_ID/$APP_NAME-nginx:$CI_COMMIT_SHA
docker push gcr.io/$GCLOUD_PROJECT_ID/$APP_NAME-nginx:$CI_COMMIT_SHA
