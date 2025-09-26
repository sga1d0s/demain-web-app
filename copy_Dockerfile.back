# Etapa 1: dependencias PHP (Composer)
FROM composer:2 AS deps
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader || true
COPY . .
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader || true

# Etapa 2: runtime (CLI para artisan serve)
FROM php:8.3-cli-bookworm
RUN docker-php-ext-install pdo_mysql
WORKDIR /var/www/html
COPY --from=deps /app ./

# (Opcional pero recomendable)
RUN mkdir -p storage/framework/{cache,sessions,views} bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R ug+rwx storage bootstrap/cache

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
