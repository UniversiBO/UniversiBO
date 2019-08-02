FROM php:5.6-apache

ENV DATA system/config

WORKDIR /var/www/project

RUN apt-get update &&\
    apt-get install -y\
        clamav\
        libpq-dev\
        libicu-dev\
        zlib1g-dev\
        git\
        unzip\
        &&\
    docker-php-ext-install\
        pdo\
        pdo_pgsql\
        pdo_mysql\
        pgsql\
        intl\
        zip\
        calendar\
        &&\
    pecl install apcu-4.0.11 &&\
    echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini &&\
    rm -rf /var/lib/apt/lists/*

COPY ${DATA}/vhosts/default.conf /etc/apache2/sites-enabled/000-default.conf

RUN a2enmod rewrite

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php
