FROM php:7.2-cli
EXPOSE 8080/tcp
#install libs
RUN apt-get update \
    && apt-get install -y \
    zip libyaml-dev

#install xdebug ext
# @TODO install only when in dev env
RUN pecl install xdebug \
  && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)\n" >> /usr/local/etc/php/conf.d/xdebug.ini

#setup user access
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

# @TODO do not install when in prod env
#install composer
RUN curl https://getcomposer.org/installer  \
    | php -- --filename=composer --install-dir=/bin


RUN chown www-data:www-data /var/www

WORKDIR /var/www/app

USER www-data

CMD bash -c "php bin/game-server.php"
#ENTRYPOINT ["tail", "-f", "/dev/null"]