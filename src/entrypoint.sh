#!/bin/bash

# Install important docker dependencies
composer install

# set permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan key:generate
php artisan migrate
php artisan clear-compiled
composer dump-autoload
php artisan optimize

exec php-fpm