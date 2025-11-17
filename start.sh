#!/bin/bash

set -e

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

# Create storage link
echo "Creating storage link..."
php artisan storage:link --force || echo "Storage link skipped"

# Run migrations
echo "Running migrations..."
php artisan migrate --force || {
    echo "✗ Migration failed!"
    exit 1
}

# Check if database is empty (no data)
echo "Checking if database needs seeding..."
PRODUCT_COUNT=$(php artisan tinker --execute="echo \App\Models\Product::count();" 2>/dev/null || echo "0")
echo "Current product count: $PRODUCT_COUNT"

if [ "$PRODUCT_COUNT" -eq "0" ]; then
    echo "Database is empty, running seeders..."
    php artisan db:seed --force || {
        echo "✗ Seeding failed!"
        exit 1
    }
    echo "✓ Seeding completed successfully"
else
    echo "Database already has data, skipping seeder"
fi

# Clear cache
echo "Clearing cache..."
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Start server
echo "Starting server on port $PORT..."
php artisan serve --host=0.0.0.0 --port=$PORT