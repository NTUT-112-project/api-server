#!/bin/bash

# Change to the directory where your docker-compose.yml file is located
cd "$(dirname "$0")"

docker compose down
# Run docker-compose up command
docker compose --env-file ./src/.env up --build -d