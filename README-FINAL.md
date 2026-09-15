# UMKM Premium Final

Versi ini merupakan hasil audit dan polishing final dari project Laravel UMKM.

## Perbaikan utama
- Frontend premium responsive, Light/Dark Mode, system theme, dan penghilangan theme flash.
- Navbar mobile dengan overlay dan aksesibilitas yang lebih baik.
- Hero, trust metrics, optional client proof, services, portfolio, pricing, process, testimonials, blog, FAQ, dan CTA.
- CMS homepage diperluas melalui Settings admin.
- Fallback media terpusat melalui `App\Support\Media`.
- WhatsApp floating CTA, lazy loading media, focus state, reduced-motion support, dan form labels.
- SEO metadata, Open Graph, Twitter Card, dynamic sitemap, dan penghapusan sitemap statis yang konflik.
- Admin responsive, Light/Dark Mode, sidebar overlay, role protection untuk Website & SEO.
- Proteksi slug otomatis agar tidak gagal saat judul yang sama digunakan.
- Cast boolean/integer yang konsisten dan migration index untuk query utama.

## Vendor
`vendor/` tidak disertakan. Jika `composer.json` dan `composer.lock` sama dengan project lama Anda, folder vendor lama dapat dicopy ke root project ini. Alternatifnya jalankan `composer install`.

## Setelah mengganti project
1. Copy `.env` lama Anda.
2. Copy `vendor/` lama jika ingin menggunakannya.
3. Pertahankan/copy `storage/app/public/` lama jika ada upload media.
4. Jalankan:

```bash
php artisan optimize:clear
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan serve
```

Jika `public/storage` sudah tersambung, pesan bahwa link already exists dapat diabaikan.

## Catatan
Project telah diperiksa dengan `php -l` pada source PHP. Pengujian runtime penuh membutuhkan folder vendor/Composer pada mesin target.
