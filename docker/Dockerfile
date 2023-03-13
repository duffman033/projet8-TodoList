FROM php:8.2-fpm

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

#RUN curl -L https://download.newrelic.com/php_agent/archive/10.2.0.314/newrelic-php5-10.2.0.314-linux.tar.gz | tar -C /tmp -zx \
#    && export NR_INSTALL_USE_CP_NOT_LN=1 \
#    && export NR_INSTALL_SILENT=1 \
#    && /tmp/newrelic-php5-10.2.0.314-linux/newrelic-install install \
#    && rm -rf /tmp/newrelic-php5-* /tmp/nrinstall*
#
#COPY newrelic.ini /usr/local/etc/php/conf.d/

#######

ARG NEWRELIC_KEY
ARG NEWRELIC_APP_NAME
ARG NEWRELIC_DAEMON_ADDRESS

RUN curl -o newrelic.tar.gz https://download.newrelic.com/php_agent/release/newrelic-php5-10.7.0.319-linux.tar.gz \
  && gzip -dc newrelic.tar.gz | tar xf - \
  && cd newrelic-php5-10.7.0.319-linux \
  && NR_INSTALL_USE_CP_NOT_LN=1 NR_INSTALL_SILENT=1 ./newrelic-install install \
  && rm -rf ../newrelic-php5-10.7.0.319-linux newrelic.tar.gz \
  && sed -i \
           -e 's/"REPLACE_WITH_REAL_KEY"/'"$NEWRELIC_KEY"'/' \
           -e 's/newrelic.appname = "PHP Application"/newrelic.appname = '"$NEWRELIC_APP_NAME"'/' \
           -e 's/;newrelic.daemon.app_connect_timeout =.*/newrelic.daemon.app_connect_timeout=15s/' \
           -e 's/;newrelic.daemon.start_timeout =.*/newrelic.daemon.start_timeout=5s/' \
           -e 's/;newrelic.daemon.address =.*/newrelic.daemon.address='"$NEWRELIC_DAEMON_ADDRESS"'/' \
           -e 's/;newrelic.daemon.dont_launch =.*/newrelic.daemon.dont_launch = 3/' \
           /usr/local/etc/php/conf.d/newrelic.ini


#############


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
