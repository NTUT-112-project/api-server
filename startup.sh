#!/bin/bash



docker compose down
# Run docker-compose up command
docker compose --env-file ./src/.env up --build -d