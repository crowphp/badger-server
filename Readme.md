# Badger Server

A small server that provides REST API for the badger utility, this lets you save the coverage report in JSON format
which can be than available to use with shields.io.

Badger CLI can update the coverage report in the format for sheilds.io to a given badger server.

## Running you server with docker

Use our official docker image to spin a new badger service

```bash
sudo docker run --name=badger --privileged --env SECRET_KEY=${provide-secret-key} -d --restart=unless-stopped -p 80:80 crowphp/badger-server:1.4
``` 
