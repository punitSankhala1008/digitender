FROM php:7.4-apache

# Required by legacy app code that uses mysqli_* functions.
RUN docker-php-ext-install mysqli
