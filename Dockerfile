FROM php:8.2-apache

RUN apt-get update && \ 
apt install -y libsqlite3-dev && \
docker-php-ext-install pdo pdo_mysql pdo_sqlite mysqli && \
apt-get clean && \
rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

COPY . /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]