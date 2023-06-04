# Laravel Alpine - Nginx - PHP 8.2

- https://dev.to/jackmiras/laravel-with-php7-4-in-an-alpine-container-3jk6
- https://blog.devsense.com/2019/php-nginx-docker

## Build

```bash
docker build -t laravel-alpine:latest .
```

## Run

```bash
docker run -d -p 80:80 -v ${pwd}:/var/wwww/html laravel-alpine:latest
```

## Packages installed
* php82-common 
* php82-fpm 
* php82-pdo 
* php82-opcache 
* php82-zip 
* php82-phar 
* php82-iconv 
* php82-cli 
* php82-curl 
* php82-openssl 
* php82-mbstring 
* php82-tokenizer 
* php82-fileinfo 
* php82-json 
* php82-xml 
* php82-xmlwriter 
* php82-simplexml 
* php82-dom 
* php82-pdo_mysql 
* php82-pdo_sqlite 
* php82-pdo_pgsql 
* php82-tokenizer 
* php82-pecl-redis 
* php82-pecl-swoole 
* php82-pecl-igbinar
