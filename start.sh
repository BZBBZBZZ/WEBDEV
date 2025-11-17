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

# Verify and fix Vite manifest path
echo "Checking Vite assets..."
if [ -f "public/build/.vite/manifest.json" ]; then
    echo "✓ Vite manifest found in .vite folder"
    # Copy to root build folder
    cp public/build/.vite/manifest.json public/build/manifest.json
    echo "✓ Manifest copied to public/build/manifest.json"
else
    echo "✗ Vite assets not found!"
    exit 1
fi

# Storage link
php artisan storage:link --force || echo "Storage link skipped"

# Migrations
echo "Running migrations..."
php artisan migrate --force
php artisan db:seed --force || echo "Seeding skipped"

# Start server
echo "Starting server..."
php artisan serve --host=0.0.0.0 --port=$PORT