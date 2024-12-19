FROM php:8.2-apache

# Set server name to avoid warnings
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Install necessary packages and PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip libicu-dev libzip-dev libonig-dev libxml2-dev libpng-dev \
    && docker-php-ext-install pdo pdo_mysql intl zip mbstring gd


# Enable Apache mod_rewrite for Symfony routing
RUN a2enmod rewrite

# Copy vhosts configuration
COPY vhosts/vhosts.conf /etc/apache2/sites-enabled/000-default.conf

# Set working directory and fix ownership
WORKDIR /var/www
RUN chown -R www-data:www-data /var/www