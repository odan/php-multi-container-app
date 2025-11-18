FROM php:8.4-apache

# PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
	curl \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    && docker-php-ext-install pdo pdo_mysql intl zip

# BZ2 extension
RUN apt-get install -y \
    libbz2-dev \
    && docker-php-ext-install bz2
	
# GD PHP extension
RUN apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
    && docker-php-ext-install exif gd

# Download the latest browscap.ini
RUN curl -L https://browscap.org/stream?q=BrowsCapINI -o /usr/local/etc/php/browscap.ini

# Enable browscap in PHP
RUN echo "browscap = /usr/local/etc/php/browscap.ini" >> /usr/local/etc/php/conf.d/browscap.ini

# Download the latest CA bundle
RUN mkdir -p /usr/local/share/certs \
    && curl -L https://curl.se/ca/cacert.pem -o /usr/local/share/certs/cacert.pem \
    && echo "curl.cainfo=/usr/local/share/certs/cacert.pem" \
        > /usr/local/etc/php/conf.d/curl-cainfo.ini \
    && echo "openssl.cafile=/usr/local/share/certs/cacert.pem" \
        >> /usr/local/etc/php/conf.d/curl-cainfo.ini

# Apache Document Root anpassen (optional)
#ENV APACHE_DOCUMENT_ROOT=/var/www/html

#RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
#    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Enable Apache modules
RUN a2enmod rewrite

# Allow .htaccess overrides
RUN sed -ri \
    -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    -e 's/AllowOverride None/AllowOverride All/g' \
    /etc/apache2/apache2.conf

# Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# PHP development settings
COPY php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html
