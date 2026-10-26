# Ruma POS — Demo Kasir

Demo POS sederhana dengan HTML, CSS, dan JavaScript murni. Tidak membutuhkan framework, database, build step, atau koneksi API.

## Isi paket

- `index.html` — struktur halaman POS.
- `style.css` — desain responsif untuk desktop, tablet, dan ponsel.
- `script.js` — katalog produk, keranjang, pembayaran simulasi, riwayat, dan laporan.
- `assets/products/` — 10 ilustrasi produk SVG lokal.

## Cara menjalankan

1. Ekstrak ZIP.
2. Buka `pos-kasir/index.html` di browser, atau jalankan melalui server lokal proyek Anda.
3. Tambahkan produk ke pesanan, pilih metode pembayaran, lalu proses transaksi.

## Cara menimpa demo lama di proyek UMKM

1. Buat cadangan folder lama `umkm/public/demo/pos-kasir/` jika masih diperlukan.
2. Ekstrak ZIP ini ke folder `umkm/public/demo/` sehingga folder `pos-kasir` dari paket bergabung/menggantikan folder lama.
3. Buka kembali URL demo POS yang biasa digunakan.

Pastikan file `index.html`, `style.css`, `script.js`, dan folder `assets/` berada di dalam `public/demo/pos-kasir/`.

## Fitur demo

- Pencarian produk dan filter kategori.
- Tambah produk, ubah kuantitas, hapus item, dan kosongkan pesanan.
- Metode pembayaran Tunai, QRIS, dan Debit.
- Perhitungan total, uang diterima, dan kembalian untuk pembayaran tunai.
- Nama pelanggan opsional.
- Struk transaksi yang dapat dicetak dari browser.
- Riwayat transaksi, ringkasan penjualan, produk terlaris, dan metode pembayaran.
- Penyimpanan data demo di `localStorage` browser.
- Gambar produk lokal; tidak bergantung pada layanan gambar eksternal.

## Catatan

Ini hanya demo sisi frontend. Transaksi tidak mengirim pembayaran, tidak terhubung ke database, stok, printer kasir fisik, atau sistem backend. Untuk mengosongkan data demo yang tersimpan, hapus data situs/browser untuk halaman ini atau jalankan `localStorage.removeItem('ruma-pos-demo-v1')` dari konsol browser.
