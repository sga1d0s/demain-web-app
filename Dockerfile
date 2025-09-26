# Etapa 1: Composer
FROM composer:2 AS deps
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader || true
COPY . .
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader || true

# Etapa 2: Node (Vite)
FROM node:20-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY . .
# si usas variables de build de Vite, pásalas con --build-arg o .env.production
RUN npm run build

# Etapa 3: PHP runtime
FROM php:8.3-cli-bookworm
RUN docker-php-ext-install pdo_mysql
WORKDIR /var/www/html
COPY --from=deps /app ./
# Copia solo lo necesario del build de Vite
COPY --from=assets /app/public/build /var/www/html/public/build
RUN mkdir -p storage/framework/{cache,sessions,views} bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R ug+rwx storage bootstrap/cache
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]