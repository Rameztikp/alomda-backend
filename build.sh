#!/bin/bash
set -e

# Disable ElasticPHP
echo 'elastic_php.enabled = 0' > /usr/local/etc/php/conf.d/disable_elastic.ini
echo 'elastic.enabled = 0' >> /usr/local/etc/php/conf.d/disable_elastic.ini

# Create required directories
mkdir -p storage/framework/cache/data
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set proper permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# Install PHP dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Generate application key if not exists
[ -f .env ] || cp .env.example .env
php artisan key:generate --force

# Clear and cache configuration
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan view:clear
php artisan optimize:clear

# Cache routes and views
php artisan route:cache
php artisan view:cache

# Install and build assets
npm install --no-audit --prefer-offline --no-progress
npm run build

# Set proper ownership (if running as root)
if [ "$(id -u)" = "0" ]; then
    chown -R www-data:www-data .
fi

echo "Build completed successfully!"
