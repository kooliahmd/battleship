#!/usr/bin/env bash
 set -o allexport && source .env && set +o allexport
cat key-file.json | docker login -u _json_key --password-stdin gcr.io
docker build -f docker/php/Dockerfile ../ -t gcr.io/$GCLOUD_PROJECT_ID/gameserver-php:$CI_COMMIT_SHA
docker push gcr.io/$GCLOUD_PROJECT_ID/gameserver-php:$CI_COMMIT_SHA
