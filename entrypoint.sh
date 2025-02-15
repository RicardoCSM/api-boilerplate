#!/bin/sh
nginx -g 'daemon on;'

crond -f -l 2 &

composer dump-autoload
php artisan optimize

php-fpm