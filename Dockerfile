FROM node:22-alpine AS frontend

WORKDIR /app

COPY package.json package-lock.json ./

RUN npm ci

COPY resources ./resources
COPY public ./public
COPY vite.config.js ./

RUN npm run build


FROM php:8.4-fpm-alpine AS production

RUN apk add --no-cache \
    nginx \
    postgresql-dev \
    libzip-dev \
    oniguruma-dev \
    icu-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install \
        pdo_pgsql \
        mbstring \
        bcmath \
        zip \
        intl \
        opcache

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

COPY . .

COPY --from=frontend /app/public/build ./public/build

RUN composer dump-autoload --optimize \
    && mkdir -p \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/start.sh /usr/local/bin/start

RUN chmod +x /usr/local/bin/start

EXPOSE 10000

CMD ["/usr/local/bin/start"]
