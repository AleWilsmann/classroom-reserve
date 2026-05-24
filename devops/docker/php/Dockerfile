FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
  git curl zip unzip \
  libpng-dev libonig-dev libxml2-dev \
  libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql mbstring

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY www.conf /usr/local/etc/php-fpm.d/www.conf

WORKDIR /var/www
