#!/bin/bash

set -e

echo "===== Starting Application Setup ====="

# Create database
echo "Creating database..."
mkdir -p /app/database
touch /app/database/database.sqlite
chmod 666 /app/database/database.sqlite
chmod 755 /app/database

echo "✓ Database created"

# Verify Vite assets exist
echo "Checking Vite assets..."
if [ -f "public/build/manifest.json" ]; then
    echo "✓ Vite manifest found"
    cat public/build/manifest.json
else
    echo "✗ CRITICAL: Manifest not found!"
    ls -la public/build/ || echo "public/build directory not found"
    exit 1
fi

# Storage link
php artisan storage:link --force || echo "Storage link skipped"

# Migrations
echo "Running migrations..."
php artisan migrate --force
php artisan db:seed --force || echo "Seeding skipped"

# Clear cache
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Start server
echo "Starting server..."
php artisan serve --host=0.0.0.0 --port=$PORT