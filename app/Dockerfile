FROM node:20 AS build

WORKDIR /var/www/app

RUN npm install -g pnpm

COPY package*.json ./
RUN pnpm install

COPY . .

RUN pnpm run build

FROM nginx:alpine as build-stage

COPY --from=build /var/www/app/dist /usr/share/nginx/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
