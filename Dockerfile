FROM php:7.3-fpm

# Install tools required for build stage
RUN apt-get update
RUN apt-get install -y wget git unzip
RUN pecl install xdebug-2.7.2
RUN docker-php-ext-enable xdebug

# Enable XDebug
ADD php.ini /usr/local/etc/php/php.ini

# Install composer
RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/usr/local/bin --filename=composer --quiet

# Установка Lavarel
RUN composer global require laravel/installer --update-with-all-dependencies

# Install PDO and PGSQL Drivers
RUN apt-get install -y libpq-dev
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql pgsql

WORKDIR /usr/share/nginx/html
ADD . /usr/share/nginx/html

WORKDIR /usr/share/nginx/html/public
