Instalasi Project Laravel

1. Install dependency:
composer install

2. Buat env:
copy .env.example .env

3. Generate key:
php artisan key:generate

4. Setting database pada .env

5. Jalankan migration:
php artisan migrate --seed

6. Jalankan:
php artisan serve
