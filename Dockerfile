FROM php:7.4-apache

# Required by legacy app code that uses mysqli_* functions.
RUN docker-php-ext-install mysqli

# Render does not use docker-compose volumes, so we must copy the code into the image
COPY ./web /var/www/html/

# Set appropriate permissions for file uploads
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 777 /var/www/html/admin/img
