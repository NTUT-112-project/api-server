FROM php:8.2.11-fpm

RUN apt-get update

# Install important libraries
RUN echo "\e[1;33mInstall important libraries\e[0m"
RUN apt-get update && \
    apt-get install -y \
    libzip-dev \
    zip
    
# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/
COPY . .

# Install important docker dependencies
RUN composer install

# set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Install Postgre PDO
RUN apt-get install -y libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN docker-php-ext-install pdo pdo_mysql bcmath

RUN php artisan cache:clear \
    && php artisan config:clear \
    && php artisan route:clear \
    && php artisan key:generate
    # && php artisan migrate \
    # && php artisan clear-compiled \
    # && composer dump-autoload \
    # && php artisan optimize

CMD [ "./entrypoint.sh" ]