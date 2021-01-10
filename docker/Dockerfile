FROM crowphp/php:8.0-cli-buster

WORKDIR /badger-server

COPY ./composer.json ./composer.json
COPY ./server.php ./server.php

RUN composer install

CMD [ "php", "./server.php" ]
