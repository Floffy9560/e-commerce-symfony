FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev zip curl postgresql-client \
    && docker-php-ext-install pdo pdo_pgsql zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Installer Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copier les sources
COPY popOptik/ ./

EXPOSE 9000

CMD ["php-fpm"]
