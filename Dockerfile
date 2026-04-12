FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libicu-dev \
    default-mysql-client \
    && docker-php-ext-install intl pdo pdo_mysql

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

COPY docker/php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN git config --global --add safe.directory /var/www/html
RUN composer install --no-interaction --optimize-autoloader

CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]