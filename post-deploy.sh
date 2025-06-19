#!/bin/bash
set -e  # Exit on any error
set -u  # Exit on undefined variables

# Go to the application directory
cd ~/subsites/eventr.be || exit 1

# Basic deployment confirmation
echo "Files deployed successfully to subsites/eventr.be"

# Check if .env file exists, if not notify to create one
if [ ! -f .env ]; then
    echo "⚠️  WARNING: .env file not found!"
    echo "Please create a .env file by copying .env.example and configuring it for your environment."
    echo "Run: cp .env.example .env && php artisan key:generate"
fi

# Verify critical environment variables exist
if ! grep -q "APP_KEY=" .env || ! grep -q "DB_DATABASE=" .env; then
    echo "⚠️  WARNING: Critical environment variables may be missing!"
fi

# Display PHP version for verification
php -v

# Laravel deployment tasks
echo "📦 Running Laravel deployment commands..."

# Install/update PHP dependencies with Composer
echo "🔄 Updating Composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

php artisan livewire:publish --assets

# Clear and rebuild caches in optimal order
echo "🔄 Optimizing application caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Rebuild optimized caches for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage symlink only if it doesn't exist
if [ ! -L public/storage ]; then
    php artisan storage:link
    echo "✅ Storage link created"
else
    echo "ℹ️  Storage link already exists"
fi

# Run migrations
php artisan migrate --force

# Build frontend assets
npm run build

echo "✅ Deployment completed successfully!"