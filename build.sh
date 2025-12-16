#!/usr/bin/env bash
# exit on error
set -o errexit

# Install dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Generate application key
php artisan key:generate --force

# Clear and cache config
php artisan config:clear
php artisan config:cache

# Clear and cache routes
php artisan route:clear
php artisan route:cache

# Clear and cache views
php artisan view:clear
php artisan view:cache

# Install npm dependencies and build assets
npm install
npm run build
