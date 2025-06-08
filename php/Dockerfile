FROM php:8.4-fpm

# Установка зависимостей
RUN apt-get update && \
    apt-get install -y \
        git \
        unzip \
        libicu-dev \
        libpq-dev \
    && docker-php-ext-install -j$(nproc) intl opcache pdo_pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Установка Composer
RUN curl -sS https://getcomposer.org/installer  | php -- --install-dir=/usr/local/bin --filename=composer

# Рабочая директория
WORKDIR /var/www/html

# Копируем только composer.json и composer.lock для кэширования зависимостей
COPY ./backend/composer.json ./backend/composer.lock ./

# Установка зависимостей
RUN composer install --no-dev --optimize-autoloader --no-scripts --no-plugins

# Копируем остальной код
COPY ./backend .

# Права доступа
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/var/cache /var/www/html/var/log