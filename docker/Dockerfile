FROM php:8.1-apache AS base

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    supervisor \
    netcat-traditional \
&& \
    docker-php-ext-install \
    zip \
    pdo_mysql \
    gd \
&& \ 
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
&& \
    a2enmod rewrite

WORKDIR /var/www/html
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

#Dockerfile for development
FROM base AS development-stage

ENV stage=development

WORKDIR /var/www/html

ENTRYPOINT ["/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/var/www/html/supervisor/supervisord.conf"]

#Dockerfile for production
FROM base AS production-stage

ENV stage=production

WORKDIR /var/www/html
COPY --chown=www-data:www-data . /var/www/html

RUN chmod -R 755 /var/www/html/storage && /var/www/html/logs

#Composer for main app
RUN composer install

ENTRYPOINT ["/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/var/www/html/supervisor/supervisord.conf"]
