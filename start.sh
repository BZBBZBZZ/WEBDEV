#!/bin/bash

set -e  # Exit on error

echo "===== Starting Application Setup ====="

# Create database directory
echo "===== Creating database directory ====="
mkdir -p /app/database
chmod 755 /app/database

# Create SQLite database file
echo "===== Creating SQLite database file ====="
touch /app/database/database.sqlite
chmod 666 /app/database/database.sqlite

# Verify database file exists
if [ -f /app/database/database.sqlite ]; then
    echo "✓ Database file created successfully"
else
    echo "✗ Failed to create database file"
    exit 1
fi

# Verify Vite assets exist (should be pre-built and committed)
echo "===== Checking Vite assets ====="
if [ -f "public/build/manifest.json" ]; then
    echo "✓ Vite assets found"
    cat public/build/manifest.json
else
    echo "✗ Vite assets not found!"
    echo "Checking public/build directory:"
    ls -la public/build/ || echo "public/build directory not found"
    exit 1
fi

# Create storage link
echo "===== Creating storage link ====="
php artisan storage:link --force || echo "Storage link skipped"

# Run migrations
echo "===== Running migrations ====="
php artisan migrate --force

# Seed database
echo "===== Seeding database ====="
php artisan db:seed --force || echo "Seeding skipped"

# Clear cache
echo "===== Clearing cache ====="
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Cache config for production
echo "===== Caching config ====="
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start server
echo "===== Starting server on port $PORT ====="
php artisan serve --host=0.0.0.0 --port=$PORT