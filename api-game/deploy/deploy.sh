#!/usr/bin/env bash
docker build . -t cloud-sdk
docker run  --env-file .env cloud-sdk sh -c \
   'sed -i "s/CI_COMMIT_SHA/$CI_COMMIT_SHA/g" /kubernetes/* &&
    sed -i "s/GCLOUD_PROJECT_ID/$GCLOUD_PROJECT_ID/g" /kubernetes/* &&
    sed -i "s/APP_NAME/$APP_NAME/g" /kubernetes/* &&

    gcloud auth activate-service-account --key-file /key-file.json &&
    gcloud container clusters get-credentials --region europe-west4-a battleship &&
    kubectl apply -f /kubernetes
    '

