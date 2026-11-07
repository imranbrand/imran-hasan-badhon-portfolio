# Stage 1: Build frontend assets
FROM node:22-bookworm-slim AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build


# Stage 2: Install PHP dependencies
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

COPY . .
RUN composer dump-autoload --no-dev --optimize


# Stage 3: Production PHP + Apache
FROM php:8.3-apache-bookworm

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libsqlite3-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libxml2-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_pgsql \
        pdo_sqlite \
        mbstring \
        bcmath \
        intl \
        gd \
        zip \
        opcache \
    && a2enmod rewrite headers \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build

RUN printf '%s\n' \
    '<VirtualHost *:10000>' \
    '    ServerName localhost' \
    '    DocumentRoot /var/www/html/public' \
    '    DirectoryIndex index.php' \
    '    <Directory /var/www/html/public>' \
    '        AllowOverride All' \
    '        Require all granted' \
    '        Options FollowSymLinks' \
    '    </Directory>' \
    '    Header always set X-Content-Type-Options "nosniff"' \
    '    Header always set X-Frame-Options "SAMEORIGIN"' \
    '    Header always set Referrer-Policy "strict-origin-when-cross-origin"' \
    '    Header always set Strict-Transport-Security "max-age=15552000"' \
    '    Header always set Permissions-Policy "geolocation=(), microphone=()"' \
    '    ErrorLog ${APACHE_LOG_DIR}/error.log' \
    '    CustomLog ${APACHE_LOG_DIR}/access.log combined' \
    '</VirtualHost>' \
    > /etc/apache2/sites-available/000-default.conf \
    && sed -i 's/^Listen 80$/Listen 10000/' /etc/apache2/ports.conf

RUN mkdir -p database storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache \
    && touch database/database.sqlite \
    && chown -R www-data:www-data database storage bootstrap/cache \
    && chmod -R ug+rwx database storage bootstrap/cache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
ENV PORT=10000

EXPOSE 10000

CMD ["bash", "-lc", "php artisan config:clear && php artisan route:clear && php artisan view:clear && php artisan migrate --force && apache2-foreground"]
