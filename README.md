# Aditech Multisolusi UMKM — Paket Demo

## Membuka demo produk tanpa instalasi

Buka `BUKA_DEMO_PRODUK.html`. Alternatif untuk Windows: jalankan `Buka-Demo-Produk.bat`.

Pusat demo berisi lima prototipe interaktif: toko sepatu, toko gadget, toko online UMKM, POS kasir, dan katalog produk. Semua data hanya disimpan selama halaman terbuka dan tidak dikirim ke server.


## Tampilan yang telah diperbarui

- Landing page, navigasi, halaman internal, form, dan footer menggunakan satu sistem desain responsif.
- Dashboard admin dan login admin telah dibangun ulang dengan sidebar, tabel, kartu, modal, dan mode gelap yang konsisten.
- Stylesheet utama disederhanakan menjadi `public/assets/css/site.css` dan `public/assets/css/admin.css`.

## Menjalankan website Laravel

Persyaratan minimum:

- PHP 8.2 atau lebih baru.
- Ekstensi PHP `mbstring`, `pdo_sqlite`, `dom`, `fileinfo`, `openssl`, dan `tokenizer`.
- Folder `storage` dan `bootstrap/cache` dapat ditulis.

Windows: jalankan `Jalankan-Website.bat`.

Linux/macOS:

```sh
./Jalankan-Website.sh
```

Lalu buka `http://127.0.0.1:8000`.

Database demo SQLite sudah tersedia di `database/database.sqlite`, sehingga MySQL tidak diperlukan untuk menjalankan paket lokal ini.

Akun admin demo:

- Email: `admin@aditech.id`
- Kata sandi: `ChangeMe123!`

Ganti kredensial, `APP_KEY`, dan konfigurasi lingkungan sebelum penggunaan produksi. Jangan mengaktifkan `APP_DEBUG` di server publik.

## Pengujian paket

Pemeriksaan cepat tanpa dependensi tambahan:

```sh
python3 tests/package_smoke.py
```
