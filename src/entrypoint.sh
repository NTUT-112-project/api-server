#!/bin/bash
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    echo "directory \"vendor\" or \"vendor/autoload.php\" not found. Installing composer dependencies..."
    composer install
else
    echo "directory \"vendor\" and \"vendor/autoload.php\" file exists."
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

exec php-fpm