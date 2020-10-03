FROM php:7.3-apache
RUN docker-php-ext-install mysqli
RUN a2enmod rewrite
RUN docker-php-ext-install pdo pdo_mysql

RUN apt-get update && \
apt-get install -y git

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
       mv composer.phar /usr/local/bin/composer

COPY composer.json composer.lock .env ./

# Configure web root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf