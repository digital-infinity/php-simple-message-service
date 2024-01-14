FROM php:8.3.1-fpm-bookworm
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug