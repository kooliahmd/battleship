FROM php:7.2-cli
EXPOSE 8080/tcp

#install libs
RUN apt-get update \
    && apt-get install -y \
    zip libyaml-dev

#setup user access
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

COPY bin /var/www/app/bin
COPY src /var/www/app/src
COPY vendor /var/www/app/vendor

RUN chown www-data:www-data /var/www

WORKDIR /var/www/app

USER www-data

CMD bash -c "php bin/game-server.php"