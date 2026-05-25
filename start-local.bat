@echo off
cd /d "%~dp0"

echo [1/4] Clearing caches...
php artisan optimize:clear

echo [2/4] Database migrate + seed...
php artisan migrate --force
php artisan db:seed --class=ShopSeeder --force

echo [3/4] Starting server at http://127.0.0.1:8000
echo Open in browser and press Ctrl+F5 for hard refresh.
echo.
php artisan serve --host=127.0.0.1 --port=8000
