# BaseImage
FROM php:7.3-fpm
COPY php.ini /usr/local/etc/php/

# package update & install
# Dockerは文を実行するたびにイメージのレイヤーを作成されてしまうので ; でワンライナーにする \ で次行に続く
RUN apt-get update \
  && apt-get install -y zlib1g-dev libzip-dev default-mysql-client \
  && docker-php-ext-install zip pdo_mysql \
  && apt-get install -y locales \
  && locale-gen ja_JP.UTF-8 \
  && echo "export LANG=ja_JP.UTF-8" >> ~/.bashrc

ENV LANG=ja_JP.UTF-8 \
  LC_ALL=ja_JP.UTF-8

# Composer install
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

RUN composer global require "laravel/installer"