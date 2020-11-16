FROM php:7.4-apache
 
RUN apt-get update && apt-get install -y git \
    zlib1g-dev \
    nano \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    gnupg

RUN docker-php-ext-install \
    pdo_mysql \
    mysqli \
    gd \
    mbstring 

RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-install zip
  
RUN a2enmod rewrite
 
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/bin/composer

# RUN a2dissite 000-default && service apache2 reload

RUN usermod -u 1000 www-data

RUN a2enmod headers

RUN apt-get clean -y

WORKDIR /var/www/html
