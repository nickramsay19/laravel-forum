#!/bin/bash

npm install

composer update

composer install

touch database/database.sqlite

php artisan migrate

php artisan db:seed RoleSeeder
php artisan db:seed AdminSeeder
