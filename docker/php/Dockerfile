FROM php:8.0.30-fpm

RUN apt-get update && apt-get install -y libzip-dev zip libpng-dev libpq-dev libicu-dev

RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-install mysqli pdo pdo_mysql zip gd intl \
    && pecl install --force redis \
    && docker-php-ext-enable redis

RUN usermod -u 1000 www-data && groupmod -g 1000 www-data && chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html