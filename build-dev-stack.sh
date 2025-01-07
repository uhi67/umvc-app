#!/bin/bash
# This sample script builds the docker stack for development purposes.
# Creates `docker-compose.yml` and `.env` files if not exist.
set -e
if [ ! -f docker-compose.yml ]; then
    cp docker-compose-template.yml docker-compose.yml
fi

if [ ! -f .env ]; then
    cp .env.template .env
fi

if [ ! -f .dockerignore ]; then
    cp .dockerignore.template .dockerignore
fi

eval "$(ssh-agent -s)"
ssh-add ~/.ssh/id_rsa
docker compose -f docker-compose.yml build --no-cache
docker compose -f docker-compose.yml up --force-recreate --remove-orphans
