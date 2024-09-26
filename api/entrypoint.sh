#!/bin/bash

php artisan cache:clear

php artisan migrate

php artisan db:seed

php-fpm
