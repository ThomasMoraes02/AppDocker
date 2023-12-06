FROM php:8.2-apache

RUN apt-get update && \ 
apt install -y libsqlite3-dev && \
docker-php-ext-install pdo pdo_mysql pdo_sqlite mysqli && \
apt-get clean && \
apt-get install -y unzip && \
rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

# Instalando o XDebug
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# Instalando o Composer
RUN php -r "copy('http://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer

COPY . /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]