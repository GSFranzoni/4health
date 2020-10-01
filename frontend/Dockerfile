FROM node:12.16-alpine
WORKDIR /var/www/quasar
COPY package*.json ./
RUN npm i -g @quasar/cli@latest
COPY . .