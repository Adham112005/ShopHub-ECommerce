FROM php:8.5-cli

RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:clear || true
RUN php artisan route:clear || true
RUN php artisan view:clear || true

EXPOSE 8080

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8080}