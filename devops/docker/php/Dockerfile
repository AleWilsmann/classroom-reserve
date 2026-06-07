FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
  git curl zip unzip \
  libpng-dev libonig-dev libxml2-dev \
  libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql mbstring

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN echo '[global]' > /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'daemonize = no' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo '[www]' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'listen = 0.0.0.0:9000' >> /usr/local/etc/php-fpm.d/zz-docker.conf


WORKDIR /var/www
