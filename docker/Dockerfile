FROM php:8.4-apache

# PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    curl \
    ca-certificates \
    vim \
    libzip-dev \
    libicu-dev \
    libxml2-dev \
    libbz2-dev \
    libpng-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        intl \
        zip \
        bz2 \
        exif \
        gd \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Download the latest browscap.ini
RUN curl -L https://browscap.org/stream?q=BrowsCapINI -o /usr/local/etc/php/browscap.ini \
    && echo "browscap = /usr/local/etc/php/browscap.ini" >> /usr/local/etc/php/conf.d/browscap.ini

# Enable Apache mod_reqrite
RUN a2enmod rewrite \
    && sed -ri \
    -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    -e 's/AllowOverride None/AllowOverride All/g' \
    /etc/apache2/apache2.conf

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN mkdir -p /tmp && chmod 777 /tmp

WORKDIR /var/www/html
