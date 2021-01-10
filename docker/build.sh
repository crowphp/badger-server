#!/bin/bash
set -e
display_usage() {
    echo -e "usage:\t ./build.sh <command>\n"
    echo -e "Commands:\n   image\t\tBuilds the images and pushes it to gcr\n"
}

GCR_PATH=crowphp/badger-server:1.4
LATEST=crowphp/badger-server:latest

case $1 in
    image)

        echo "docker build --tag ${GCR_PATH} ."
        docker build --tag ${GCR_PATH} --tag ${LATEST} --file ./docker/Dockerfile .
        docker -- push ${GCR_PATH}
        docker -- push ${LATEST}
        ;;
    * )
        display_usage
        exit 1
esac