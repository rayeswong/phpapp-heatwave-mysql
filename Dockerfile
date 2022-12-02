FROM php:8.0-apache
WORKDIR /var/www/html

COPY * .
COPY src/ src
COPY img/ img
COPY rh/ rh
COPY progressbar/ progressbar
EXPOSE 80