# Исправленный Dockerfile
FROM php:8.2-cli as builder

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .

# Установка ВСЕХ зависимостей (включая validator)
RUN composer install --optimize-autoloader --no-interaction --no-scripts

FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean

COPY --from=builder /app /app
WORKDIR /app

CMD sh -c "php bin/console cache:clear --env=prod && \
           php bin/console cache:warmup --env=prod && \
           php bin/console doctrine:migrations:migrate --no-interaction && \
           php -S 0.0.0.0:8000 -t public"