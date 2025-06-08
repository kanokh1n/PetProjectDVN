# frontend/Dockerfile
FROM node:20

WORKDIR /app

# Копируем package.json и устанавливаем зависимости
COPY package*.json ./
RUN npm install

# Базовая команда (временно)
CMD ["sh", "-c", "echo 'Frontend is not ready yet'; sleep infinity"]