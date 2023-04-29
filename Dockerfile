# Образ PHP
ARG PHP_VERSION="7.3"
FROM php:${PHP_VERSION}-fpm

# Install tools required for build stage
RUN apt update && apt upgrade -y \
    && apt install -y \
        wget \
        git \
        unzip

# Версия Xdebug
ARG XDEBUG_VERSION="3.1.5"
# Скачивание и включение XDebug
RUN pecl install "xdebug-${XDEBUG_VERSION}"
RUN docker-php-ext-enable xdebug
ADD php.ini /usr/local/etc/php/php.ini

# Версия Composer
ARG COMPOSER_VERSION="2.3.10"
# Установка Composer'а
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '55ce33d7678c5a611085589f1f3ddf8b3c52d662cd01d4ba75c0ee0459970c2200a51f492d557530c71c15d8dba01eae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php --version=${COMPOSER_VERSION} --filename=composer --install-dir=/usr/local/bin
RUN php -r "unlink('composer-setup.php');"

# Установка Lavarel
RUN composer global require laravel/installer --update-with-all-dependencies

# Install PDO and PGSQL Drivers
RUN apt update && apt upgrade -y \
    && apt install -y \
        libpq-dev
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pdo_pgsql pgsql

WORKDIR /usr/share/nginx/html
ADD . /usr/share/nginx/html

WORKDIR /usr/share/nginx/html/public
