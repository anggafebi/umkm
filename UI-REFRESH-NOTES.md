# Catatan Redesign Antarmuka UMKM

## Arah visual
- Seluruh website publik sekarang menggunakan satu sistem desain melalui `public/assets/css/site.css`.
- Panel admin dan halaman login menggunakan satu sistem desain melalui `public/assets/css/admin.css`.
- Palet utama memakai biru yang tegas, hijau sebagai aksen, permukaan netral, serta mode terang dan gelap yang konsisten.
- Tipografi memakai Manrope untuk judul dan Inter untuk isi, dengan fallback font sistem.

## Perubahan halaman publik
- Landing page dibangun ulang: hero yang lebih jelas, pratinjau produk, ringkasan layanan, pusat demo, alasan memilih layanan, alur kerja, FAQ, CTA, dan footer baru.
- Navigasi desktop dan mobile dirapikan, termasuk state aktif, overlay, tema, dan CTA konsultasi.
- Halaman layanan, produk, portofolio, artikel, kontak, konsultasi, detail, demo, serta halaman error diselaraskan dengan komponen dan hierarki yang sama.
- Ditambahkan logo mark SVG baru dan lima gambar pratinjau WebP untuk demo, kartu produk, serta portofolio.
- Halaman publik memiliki fallback konten terpusat ketika koneksi database tidak tersedia; sitemap tetap dihasilkan secara dinamis.
- Form, tombol, kartu, tabel, pagination, focus state, dan responsivitas diperbaiki.

## Perubahan panel admin
- Sidebar, topbar, dashboard, metrik, grafik, tabel, form, kartu konten, modal, media manager, dan halaman login dibangun ulang.
- Struktur navigasi dikelompokkan menjadi Ringkasan, Konten Website, dan Sistem.
- Interaksi sidebar mobile, mode gelap, modal, fokus keyboard, serta backdrop dibuat lebih konsisten.

## Penyederhanaan aset
- Lapisan CSS lama yang saling menimpa dihapus.
- Hanya `site.css` dan `admin.css` yang digunakan untuk tampilan utama.
- Bundle demo lama yang tidak lagi dipakai dihapus; lima demo tetap mandiri dan dapat dibuka tanpa proses build.

## Demo yang tersedia
- `public/demo/sepatu/index.html`
- `public/demo/iphone/index.html`
- `public/demo/toko-online/index.html`
- `public/demo/pos-kasir/index.html`
- `public/demo/katalog-produk/index.html`

Semua pembayaran, pesanan, dan transaksi pada demo hanya simulasi di browser.
