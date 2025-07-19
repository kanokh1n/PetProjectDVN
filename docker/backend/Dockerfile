FROM php:8.2-cli as builder

# Установка системных зависимостей
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .

# Установка PHP зависимостей без запуска скриптов
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# ----------------------------
# Финальный образ
# ----------------------------
FROM php:8.2-cli

# Установка runtime зависимостей
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Копируем установленные зависимости из builder-стадии
COPY --from=builder /app /app

WORKDIR /app

# Выполняем миграции и запускаем сервер
CMD sh -c "php bin/console doctrine:migrations:migrate --no-interaction && php -S 0.0.0.0:8000 -t public"