# Базовый образ
FROM node:20-alpine AS builder

# Установка рабочей директории
WORKDIR /app

# Копирование зависимостей
COPY package.json ./

# Установка зависимостей
RUN yarn install

# Установка curl
RUN apk add --no-cache curl

# Копирование исходного кода
COPY . .

# Сборка приложения
RUN yarn build

# Производственный образ
FROM node:18-alpine

WORKDIR /app

# Копирование собранного приложения
COPY --from=builder /app/build ./build

# Запуск сервера
CMD ["npx", "serve", "-s", "build"]