FROM php:7.2.4-apache-stretch

RUN apt-get update &&\
    apt-get install -y\
        libpq-dev\
        libicu-dev\
        zlib1g-dev\
        git\
        &&\
    docker-php-ext-install\
        pdo\
        pdo_pgsql\
        intl\
        zip\
        &&\
    pecl install apcu &&\
    echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini

RUN rm /etc/apache2/sites-available/*
ADD ./etc/apache2/sites-available /etc/apache2/sites-available
