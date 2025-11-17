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

# ALWAYS copy manifest from .vite to root
echo "Fixing Vite manifest path..."
if [ -f "public/build/.vite/manifest.json" ]; then
    cp -f public/build/.vite/manifest.json public/build/manifest.json
    echo "✓ Manifest copied"
    cat public/build/manifest.json
else
    echo "⚠ Manifest not found in .vite folder"
fi

# Verify manifest exists
if [ ! -f "public/build/manifest.json" ]; then
    echo "✗ CRITICAL: Manifest not found at public/build/manifest.json"
    echo "Checking public/build structure:"
    ls -la public/build/
    exit 1
fi

echo "✓ Manifest verified at public/build/manifest.json"

# Storage link
php artisan storage:link --force || echo "Storage link skipped"

# Migrations
echo "Running migrations..."
php artisan migrate --force
php artisan db:seed --force || echo "Seeding skipped"

# Start server
echo "Starting server..."
php artisan serve --host=0.0.0.0 --port=$PORT