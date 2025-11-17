#!/bin/bash

set -e  # Exit on error

echo "===== Starting Application Setup ====="
echo "Current directory: $(pwd)"
echo "Listing files:"
ls -la

# Create database directory
echo "===== Creating database directory ====="
mkdir -p /app/database
chmod 755 /app/database
echo "Directory created: $(ls -la /app/ | grep database)"

# Create SQLite database file
echo "===== Creating SQLite database file ====="
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

# Check Node.js
echo "===== Checking Node.js ====="
node --version || echo "Node.js not found!"
npm --version || echo "npm not found!"

# Check if node_modules exists
echo "===== Checking node_modules ====="
if [ -d "node_modules" ]; then
    echo "✓ node_modules exists"
else
    echo "✗ node_modules not found, installing..."
    npm ci --include=dev
fi

# Check if Vite build exists
echo "===== Checking Vite build ====="
if [ ! -d "public/build" ]; then
    echo "⚠ Vite assets not found, building now..."
    npm run build
    
    # Verify build succeeded
    if [ -d "public/build" ]; then
        echo "✓ Vite build successful"
        ls -la public/build/
    else
        echo "✗ Vite build failed!"
        exit 1
    fi
else
    echo "✓ Vite assets found"
    ls -la public/build/
fi

# Create storage link
echo "===== Creating storage link ====="
php artisan storage:link --force || echo "Storage link skipped"

# Run migrations
echo "===== Running migrations ====="
php artisan migrate --force || {
    echo "✗ Migration failed!"
    exit 1
}

# Seed database
echo "===== Seeding database ====="
php artisan db:seed --force || echo "Seeding skipped"

# Clear all cache (IMPORTANT!)
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

# Test database connection
echo "===== Testing database connection ====="
php artisan tinker --execute="echo 'DB Test: ' . DB::connection()->getPdo()->getAttribute(PDO::ATTR_SERVER_VERSION);" || echo "DB test skipped"

# Show Laravel version
echo "===== Laravel Info ====="
php artisan --version

# Start server
echo "===== Starting server on port $PORT ====="
php artisan serve --host=0.0.0.0 --port=$PORT