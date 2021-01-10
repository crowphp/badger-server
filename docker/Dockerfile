FROM crowphp/php:8.0-cli-buster

RUN apt update

WORKDIR /badger-server

COPY ./composer.json ./composer.json
COPY ./server.php ./server.php

RUN composer install

EXPOSE  80
CMD [ "php", "./server.php" ]

