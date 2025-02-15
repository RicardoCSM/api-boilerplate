# BASE IMAGE
FROM php:8.2-fpm-alpine

# Dependências básicas
RUN apk --no-cache add \
    libzip-dev \
    icu-dev \
    libpq-dev \
    nginx \
    supervisor \
    libjpeg-turbo-dev \
    libpng-dev \
    freetype-dev \
    imagemagick-dev \
    imagemagick \
    libtool \
    autoconf \
    g++ \
    make \
    pkgconfig \
    ghostscript \
    dcron

# Extensões PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    zip \
    intl \
    pgsql \
    pdo_pgsql \
    exif \
    gd

# Instalar a extensão imagick
RUN pecl install imagick \
    && docker-php-ext-enable imagick

# Limpar cache do apk
RUN rm -rf /tmp/pear \
    && rm -rf /var/cache/apk/*

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

COPY nginx-site.conf /etc/nginx/http.d/default.conf
COPY entrypoint.sh /etc/entrypoint.sh
RUN chmod +x /etc/entrypoint.sh

ADD . /var/www/html

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-ansi \
    --audit \
    --classmap-authoritative \
    && php artisan storage:link

RUN echo "* * * * * php /var/www/html/artisan schedule:run >>/tmp/schedule.log 2>&1" >> /etc/crontabs/root

RUN chgrp -R www-data /var/www/html/bootstrap /var/www/html/storage /var/www/html/storage/logs \
    && chmod -R g+w /var/www/html/bootstrap /var/www/html/storage /var/www/html/storage/logs

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:9000", "-t", "public/"]

ENTRYPOINT ["/etc/entrypoint.sh"]

HEALTHCHECK --start-period=5s --interval=2s --timeout=5s --retries=8 CMD php || exit 1