# Select base image 
FROM php:8.3.12-apache
# Update and install dependencies including mbstring
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    libpq-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    --no-install-recommends \
    && docker-php-ext-install zip mbstring exif pgsql pdo pdo_pgsql \
    && apt-get clean \
    && rm -r /var/lib/apt/lists/*
# Set php folder as target
WORKDIR /var/www/html
# Copy source files to php directory 
COPY php-development.ini "$PHP_INI_DIR/php.ini"
COPY composer.json .
COPY composer.lock .
COPY ./src .
# Install composer from script
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# Add flags on server environment
RUN composer install \
    --no-interaction \
    --no-plugins     \
    --no-scripts     \
    --no-dev         \
    --prefer-dist    \
    --optimize-autoloader

