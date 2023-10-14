FROM php:8.1 as php

#install php extension
RUN apt-get update -y
RUN apt-get install -y unzip libpq-dev libcur14-gntls-dev
RUN docker-php-ext-install pdo pdo_mysql bcmatch

#install redis
RUN precl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable radis

#enter the working dir
WORKDIR /var/www
#copy the laravel code in it
COPY . .
#install composer
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer


ENTRYPOINT [ "docker/entrypoint.sh"]