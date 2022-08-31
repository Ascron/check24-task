FROM php:8.1-fpm

RUN usermod -u 1000 www-data

RUN apt-get update \
    && pecl install xdebug-3.1.5 \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo_mysql \
    && rm -rf /var/www/html

COPY php.ini $PHP_INI_DIR/php.ini

WORKDIR /var/www
