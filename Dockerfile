FROM node:20-alpine AS build-assets

WORKDIR /app

COPY package*.json vite.config.* postcss.config.* tailwind.config.* ./
RUN npm install

COPY resources ./resources
COPY public ./public
RUN npm run build


FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libzip-dev libxml2-dev libicu-dev \
    libpq-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo_mysql pdo_pgsql pgsql mbstring zip gd intl \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy toàn bộ source trước để các lệnh artisan trong composer.json
# (post-autoload-dump) có thể chạy được khi cài đặt
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction
COPY --from=build-assets /app/public/build ./public/build

RUN chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

CMD php artisan migrate:fresh --seed --force && \
    php artisan serve --host=0.0.0.0 --port=10000