#!/bin/bash

php artisan migrate

php artisan db:seed

php-fpm
