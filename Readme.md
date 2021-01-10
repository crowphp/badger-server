# Badger Server

A small server that provides REST API for the badger utility, this lets you save the coverage report in JSON format
which can be than available to use with shields.io.

Badger CLI can update the coverage report in the format for sheilds.io to a given badger server.

## Running you server with docker

Use our official docker image to spin a new badger service

```bash
sudo docker run --name=badger --privileged --env SECRET_KEY=${provide-secret-key} -d --restart=unless-stopped -p 80:80 crowphp/badger-server:1.4
``` 

## Endpoints

`Creating/Updating`  new coverage report for a branch
```bash
curl --location --request POST 'http://localhost:5005/coverage/{branch}' \
--header 'secret-key: Your-secret-here' \
--header 'Content-Type: application/json' \
--data-raw '{
  "schemaVersion": 1,
  "label": "coverage",
  "message": "80%",
  "color": "yellow"
}'
``` 

Notice the schema we are using the shields.io compatible json.

`Retrieving`  the public coverage report for the `branch`

```
curl --location --request GET 'http://localhost:5005/coverage/{branch}'
```

That's It!
Happy Coding.