FROM php:8.2-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash

ENV NOTVISIBLE "in users profile"
RUN echo "export VISIBLE=now" >> /etc/profile

RUN groupadd -g 1000 -r kiora \
 && useradd -u 1000 -r -g kiora kiora \
 && mkdir -p /home/kiora/.ssh \
 && chown -R kiora:kiora /home/kiora \
 && chown -R kiora:kiora /var/www

USER kiora

WORKDIR /var/www/projet8-todolist
