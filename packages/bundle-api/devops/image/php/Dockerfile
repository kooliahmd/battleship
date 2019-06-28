FROM php:7.2-fpm

#install libs
RUN apt-get update \
    && apt-get install -y \
    zip libyaml-dev

#install xdebug ext
# @TODO install only when in dev env
RUN pecl install xdebug \
  && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)\n" >> /usr/local/etc/php/conf.d/xdebug.ini


#install yaml ext
RUN pecl install yaml \
  && echo "extension=yaml.so" >> /usr/local/etc/php/conf.d/yaml.ini
#install exts
RUN docker-php-ext-install \
   bcmath

#setup user access
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

# @TODO do not install when in prod env
#install composer
RUN curl https://getcomposer.org/installer  \
    | php -- --filename=composer --install-dir=/bin

COPY --chown=www-data:www-data . /var/www/app

RUN chown www-data:www-data /var/www

WORKDIR /var/www/app