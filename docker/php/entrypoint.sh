#!/bin/bash

chown -R www-data:www-data /var/www/html/public
chown -R www-data:www-data /var/www/html/storage
chmod -R 777 /var/www/html/public
chmod -R 777 /var/www/html/storage

composer install --no-interaction --no-progress
npm install -g npm

php artisan key:generate            # generujemy klucz
php artisan migrate                 # robimy migracje wraz
php artisan cache:clear             # czyścimy cache
php artisan config:clear            # czyścimy konfiguracje
php artisan route:clear             # czyścimy routing

service cron start

exec docker-php-entrypoint apache2-foreground
