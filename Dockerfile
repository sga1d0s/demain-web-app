# Dockerfile
FROM php:8.3-fpm-bookworm

# Evita prompts de apt
ARG DEBIAN_FRONTEND=noninteractive

# Dependencias de sistema mínimas
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        libzip-dev \
        unzip \
        git \
        curl; \
    # zip de PHP necesita configurarse antes de compilar
    docker-php-ext-configure zip; \
    docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        zip; \
    # Limpieza
    rm -rf /var/lib/apt/lists/*

# Evita problemas de permisos/memoria y consigue logs si falla
ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_MEMORY_LIMIT=-1

COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-progress --prefer-dist -vvv
COPY . .
# No hace falta repetir install; si quieres autoloader optimizado:
RUN composer dump-autoload --optimize

# Etapa 2: runtime
RUN apt-get update && apt-get install -y libicu-dev git unzip \
 && docker-php-ext-install pdo_mysql intl bcmath
WORKDIR /var/www/html
COPY --from=deps /app ./

# Directorios Laravel y permisos
RUN mkdir -p storage/framework/{cache,sessions,views} bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R ug+rwx storage bootstrap/cache

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
