#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    composer install --no-progess --no-interaction
fi

if [ ! -f ".env" ]; then
    echo "creating env file"
    cp .env.example .env
else
    echo ".env file exists."
fi

php artisan cache:clear
php artisan config:clear
php artisan route:clear

php artisan key:generate
php artisan migrate
php artisan clear-compiled
composer dump-autoload
php artisan optimize

php artisan serve --port=$PORT --host=0.0.0.0
exec docker-php-entrypoint "$@"