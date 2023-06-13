FROM php:8.2-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip wget gnupg\
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN echo 'deb http://apt.newrelic.com/debian/ newrelic non-free' | tee /etc/apt/sources.list.d/newrelic.list \
    && wget -O- https://download.newrelic.com/548C16BF.gpg | apt-key add - \
    && apt-get update \
    && apt-get install -y newrelic-php5 \
    && newrelic-install install

RUN echo 'extension=newrelic.so' > /usr/local/etc/php/conf.d/newrelic.ini

ENV NEW_RELIC_LICENSE_KEY '%env(resolve:NEW_RELIC_LICENSE_KEY)%'
ENV NEW_RELIC_APP_NAME todolist
ENV NEW_RELIC_LOG /var/log/newrelic/php_agent.log
ENV NEW_RELIC_LOG_LEVEL info

RUN echo "newrelic.license=$NEW_RELIC_LICENSE_KEY" >> /usr/local/etc/php/conf.d/newrelic.ini \
    && echo "newrelic.appname=$NEW_RELIC_APP_NAME" >> /usr/local/etc/php/conf.d/newrelic.ini \
    && echo "newrelic.logfile=$NEW_RELIC_LOG" >> /usr/local/etc/php/conf.d/newrelic.ini \
    && echo "newrelic.loglevel=$NEW_RELIC_LOG_LEVEL" >> /usr/local/etc/php/conf.d/newrelic.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash

ENV PHP_EXTRA_CONFIGURE_ARGS --enable-fpm --with-fpm-user=www-data --with-fpm-group=www-data
ENV NOTVISIBLE "in users profile"

RUN echo "export VISIBLE=now" >> /etc/profile

RUN groupadd -g 1000 -r kiora \
    && useradd -u 1000 -r -g kiora kiora \
    && mkdir -p /home/kiora/.ssh \
    && chown -R kiora:kiora /home/kiora \
    && chown -R kiora:kiora /var/www

USER kiora

WORKDIR /var/www/projet8-todolist
