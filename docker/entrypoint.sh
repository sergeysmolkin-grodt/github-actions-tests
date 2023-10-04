#!/bin/sh
set -e

if [ "$stage" = "development" ]; then
  echo "=== Composer Install ==="
  composer install
  chmod -R 777 /var/www/html/storage && chmod -R 777 /var/www/html/logs
fi

echo "=== Run Migrations ==="
cd /var/www/html && php artisan migrate

echo "=== Run defined command in CMD Dockerfile ==="
exec "$@"
