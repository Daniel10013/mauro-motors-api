FROM php:8.2-apache

COPY . /var/www/html/

RUN echo "date.timezone=America/Sao_Paulo" > /usr/local/etc/php/conf.d/timezone.ini

RUN a2enmod rewrite

EXPOSE 80
