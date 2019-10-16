FROM php:7.2-fpm

#install libs
RUN apt-get update \
    && apt-get install -y \
    zip libyaml-dev


#install yaml ext
RUN pecl install yaml \
  && echo "extension=yaml.so" >> /usr/local/etc/php/conf.d/yaml.ini
#install exts
RUN docker-php-ext-install \
  pdo_mysql bcmath

#setup user access
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

COPY bin /var/www/app/bin
COPY config /var/www/app/config
COPY public /var/www/app/public
COPY src /var/www/app/src
COPY vendor /var/www/app/vendor
COPY .env /var/www/app/.env



RUN chown -R www-data:www-data /var/www

WORKDIR /var/www/app