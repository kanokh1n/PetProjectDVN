#FROM node:20-alpine AS builder
#WORKDIR /app
#COPY package.json ./
#RUN yarn install
#COPY . .
#RUN yarn build

#FROM node:18-alpine
#WORKDIR /app
#RUN apk add --no-cache curl
#COPY --from=builder /app/build ./build
#CMD ["npx", "serve", "-s", "build", "-l", "3000"]