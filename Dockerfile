# ---------- Frontend Build ----------
FROM node:22 AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm install

COPY . .
RUN npm run build

# ---------- PHP ----------
FROM php:8.5-cli

RUN apt-get update && apt-get install -y \
    git unzip zip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
 && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    exif \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# انسخ ملفات Vite
COPY --from=frontend /app/public/build ./public/build

# أنشئ مجلدات Laravel قبل Composer
RUN mkdir -p \
    bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs

RUN chmod -R 777 storage bootstrap/cache

# منع تشغيل artisan أثناء composer
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-scripts

# ثم شغّل سكربتات Laravel
RUN php artisan package:discover --ansi

EXPOSE 8080

CMD php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8080}