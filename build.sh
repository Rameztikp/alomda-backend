#!/usr/bin/env bash
# Exit on error
set -e

# Debug info
echo "Starting build process..."

# Create storage and cache directories if they don't exist
mkdir -p storage/framework/{sessions,views,cache/data}
mkdir -p bootstrap/cache

# Set permissions
chmod -R 777 storage
chmod -R 777 bootstrap/cache

# Install dependencies
echo "Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Generate application key if not exists
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate --force
fi

# Clear all caches
echo "Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear

# Cache configuration
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Install and build assets
echo "Installing and building assets..."
npm install --no-audit --prefer-offline --no-progress
npm run build

# Optimize the application
echo "Optimizing application..."
php artisan optimize

# Set proper ownership (if running as root)
if [ "$(id -u)" = "0" ]; then
    chown -R www-data:www-data .
fi

echo "Build process completed successfully!"
