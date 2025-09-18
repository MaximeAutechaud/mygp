FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libicu-dev libonig-dev libxml2-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql intl zip gd opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Installer dépendances PHP (pas le code pour permettre hot reload)
COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --no-interaction

COPY . .

RUN composer dump-autoload --optimize
