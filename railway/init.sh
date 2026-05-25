#!/bin/sh
set -e

cd /app 2>/dev/null || cd "$(dirname "$0")/.."

echo "[railway] Clearing config cache..."
php artisan config:clear --no-interaction 2>/dev/null || true

echo "[railway] Running migrations..."
php artisan migrate --force --no-interaction

echo "[railway] Seeding database..."
php artisan db:seed --force --no-interaction

echo "[railway] Database ready."
