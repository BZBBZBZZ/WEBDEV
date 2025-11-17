#!/bin/bash

set -e

echo "===== Starting Application ====="

# Create database
mkdir -p /app/database
touch /app/database/database.sqlite
chmod 666 /app/database/database.sqlite
chmod 755 /app/database

echo "✓ Database created"

# Storage link
php artisan storage:link --force || echo "Storage link skipped"

# Migrations
php artisan migrate --force
php artisan db:seed --force || echo "Seeding skipped"

# Start server
echo "Starting server..."
php artisan serve --host=0.0.0.0 --port=$PORT