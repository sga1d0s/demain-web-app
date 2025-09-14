# Etapa composer
FROM php:8.3-fpm-bookworm

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-scripts --no-progress
COPY . .
RUN composer install --no-interaction

# Runtime PHP
FROM php:8.3-cli
RUN docker-php-ext-install pdo pdo_mysql
WORKDIR /var/www/html
COPY --from=vendor /app ./

# Nota: la APP_KEY la generamos desde fuera con artisan.
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
