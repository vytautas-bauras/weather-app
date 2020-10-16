FROM php:7.4-fpm-alpine

RUN apk update && apk upgrade && \
    apk add --no-cache bash git openssh libintl icu icu-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer