#!/bin/bash

echo "===== Starting Application Setup ====="

# Create database directory
echo "Creating database directory..."
mkdir -p /app/database
chmod 755 /app/database

# Create SQLite database file
echo "Creating SQLite database file..."
touch /app/database/database.sqlite
chmod 666 /app/database/database.sqlite

# Verify database file exists
if [ -f /app/database/database.sqlite ]; then
    echo "✓ Database file created successfully"
    ls -la /app/database/
else
    echo "✗ Failed to create database file"
    exit 1
fi

# Check if assets are built
echo "Checking Vite build..."
if [ ! -d "public/build" ]; then
    echo "⚠ Vite assets not found, building now..."
    npm run build
else
    echo "✓ Vite assets found"
fi

# Create storage link
echo "Creating storage link..."
php artisan storage:link --force || echo "Storage link skipped"

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Seed database
echo "Seeding database..."
php artisan db:seed --force

# Clear and cache config
echo "Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start server
echo "Starting server on port $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT
