#!/bin/bash

chown -R www-data:www-data /var/www/html/public
chmod -R 777 /var/www/html/public

composer install --no-interaction --no-progress
npm install -g npm

exec docker-php-entrypoint apache2-foreground
