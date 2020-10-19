#!/bin/bash
set -e

docker-compose up -d --build --force-recreate
docker-compose exec -T php composer install --verbose --optimize-autoloader
