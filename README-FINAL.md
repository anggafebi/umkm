# Aditech Multisolusi UMKM — Redesign Final

Paket ini berisi website Laravel, dashboard admin, database SQLite demo, serta lima demo produk mandiri. Tampilan publik, landing page, login, dan panel admin telah disusun ulang dalam satu sistem visual yang konsisten.

## Yang diperbarui
- Landing page baru dengan hero, pratinjau produk, layanan, demo, proses, FAQ, CTA, dan footer.
- Tipografi, ukuran teks, warna, spacing, border, radius, shadow, serta state interaksi yang konsisten.
- Navigasi responsif dan mode terang/gelap.
- Halaman internal, form, detail produk/layanan, artikel, portofolio, kontak, konsultasi, dan error state.
- Dashboard admin, sidebar, topbar, metrik, tabel, modal, form, media manager, serta login admin.
- Aset pratinjau WebP dan logo mark SVG baru.
- Fallback konten publik ketika database sementara tidak tersedia, serta sitemap dinamis yang tidak tertimpa file statis.
- Penghapusan stylesheet dan bundle demo lama yang sudah tidak digunakan.

## Menjalankan proyek
Persyaratan minimum:

- PHP 8.2 atau lebih baru.
- Ekstensi `mbstring`, `pdo_sqlite`, `dom`, `fileinfo`, `openssl`, dan `tokenizer`.
- Folder `storage` dan `bootstrap/cache` dapat ditulis.

Linux/macOS:

```sh
./Jalankan-Website.sh
```

Windows:

```text
Jalankan-Website.bat
```

Buka `http://127.0.0.1:8000`.

Akun admin demo:

- Email: `admin@aditech.id`
- Kata sandi: `ChangeMe123!`

Ganti kredensial, `APP_KEY`, dan konfigurasi lingkungan sebelum digunakan pada server produksi.

## Pemeriksaan cepat

```sh
python3 tests/package_smoke.py
```

Folder `vendor/` dan database SQLite demo sudah disertakan dalam paket ini.
