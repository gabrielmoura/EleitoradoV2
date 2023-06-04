FROM alpine:3.18

LABEL maintainer="Gabriel Moura"
ARG POSTGRES_VERSION=14-client
ARG WWWGROUP
ENV PHP_INI_DIR=/etc/php

WORKDIR /var/www/html/

# Essentials
ENV TZ=America/Sao_Paulo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
RUN apk add --no-cache zip unzip curl sqlite supervisor postgresql$POSTGRES_VERSION composer

# Installing bash
RUN apk add bash
RUN sed -i 's/bin\/ash/bin\/bash/g' /etc/passwd

# Installing PHP
RUN apk update && apk add --no-cache php82 \
    php82-common \
    php82-fpm \
    php82-pdo \
    php82-opcache \
    php82-zip \
    php82-phar \
    php82-iconv \
    php82-cli \
    php82-curl \
    php82-openssl \
    php82-mbstring \
    php82-tokenizer \
    php82-fileinfo \
    php82-json \
    php82-xml \
    php82-xmlwriter \
    php82-simplexml \
    php82-dom \
    php82-pdo_mysql \
    php82-pdo_sqlite \
    php82-pdo_pgsql \
    php82-tokenizer \
    php82-pecl-redis \
    php82-pecl-swoole \
    php82-pecl-igbinary


# Configure supervisor
RUN mkdir -p /etc/supervisor.d/
COPY ./supervisord.conf /etc/supervisor.d/supervisord.ini

COPY ./php-fpm.conf /etc/php82/php-fpm.d/www.conf
COPY ./php.ini /etc/php82/php.ini

RUN addgroup fpm -g 1000 \
    && addgroup nobody fpm \
    && chown -R nobody:fpm /var/www/html

EXPOSE 9000
CMD ["supervisord", "-c", "/etc/supervisor.d/supervisord.ini"]
