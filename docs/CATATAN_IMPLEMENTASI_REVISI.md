# Catatan implementasi PRD revisi v1.0

Berdasarkan `docs/PRD_Revisi_Website_Aditech_Multisolusi_v1.md`.
Proyek **tidak** diinisialisasi ulang: histori `.git`, remote, branch, `vendor`, demo, dan berkas asli tetap dipertahankan. Perubahan belum di-commit agar rekan kolaborasi bisa meninjau `git diff` terlebih dahulu.

## Pemasangan dan migrasi

1. **Backup** database aktif dan file `.env` terlebih dahulu sebelum menjalankan migrasi. File `.env` bawaan ZIP dipertahankan seperti aslinya; cek koneksi database yang benar sebelum menjalankan perintah. Contoh `.env.example` menggunakan SQLite, sedangkan `.env` di ZIP dapat menggunakan koneksi yang berbeda.
2. Pada lingkungan yang memiliki **PHP >= 8.2 beserta ekstensi yang diwajibkan Laravel**, jalankan `php artisan migrate`. Migrasi baru `2026_10_31_000001_add_client_consultation_features.php` mempertahankan data konsultasi dan produk lama (kolom relasi baru nullable).
3. Jika perlu, jalankan `php artisan optimize:clear` lalu `php artisan serve`. Pastikan folder storage writable. Tetap gunakan konfigurasi server dan `composer install` sesuai alur kerja proyek yang sudah ada.
4. Login admin/editor tetap memakai akun dan route lama. Client dapat mendaftar melalui `/daftar`, login `/login`, kemudian membuka `/akun`.
5. **Jangan** commit file `.env` atau kredensial. Folder `.git` disertakan pada ZIP ini; periksa `git status` dan `git diff`, lalu lakukan commit/push pada branch kolaborasi yang disepakati.

## Perubahan sesuai PRD

- FR-01: link `Tanyakan produk` membawa `?produk=slug`, form menampilkan produk, server memeriksa `product_id` dan menyimpan `product_name_snapshot` / `reference_code`. Form umum tetap berlaku.
- FR-02: registrasi/login client dengan batas 10 client (counter berbasis pembaruan atomik di database), profil, riwayat, status, balasan, proteksi role dan kepemilikan. Akun admin/editor tidak dihitung.
- FR-03: harga menggunakan sumber DB dan flag `price_is_starting_at`; placeholder bila harga kosong/0, tampil di katalog, detail, dan produk unggulan beranda.
- FR-04: pesan sukses/error, notifikasi dalam akun, badge notifikasi konsultasi untuk admin, token submit konsultasi mencegah pengiriman ganda.
- FR-05: daftar leads bisa difilter menurut produk/status/teks, halaman detail lengkap, balasan admin (khusus inbox client terdaftar), catatan privat, log status, CSV tetap ada.

## Hal yang perlu diperhatikan

- Kuota berlaku untuk seluruh akun client yang terdaftar; UI deaktivasi akun belum disediakan, mengikuti opsi implementasi awal di PRD. Counter diinisialisasi dari jumlah akun client pada saat migrasi. Jangan menambah atau menghapus client langsung melalui SQL tanpa menyesuaikan counter.
- Guest tidak mempunyai inbox atau melihat balasan admin; gunakan nomor WhatsApp/email yang disediakan untuk tindak lanjut.
- Konsultasi historis yang tidak memiliki `product_id` akan tertulis “Umum / belum pilih produk”. Produk yang dihapus tidak menghapus `product_name_snapshot`.
- Tidak ada layanan email otomatis atau WebSocket tambahan. Notifikasi menggunakan penyimpanan database; refresh halaman untuk melihat pembaruan.

## Daftar UAT (jalankan di browser setelah migrasi)

- [ ] UAT-01: klik POS → form dan admin menampilkan POS.
- [ ] UAT-02: form konsultasi umum tetap menerima tanpa produk.
- [ ] UAT-03: guest tanpa email ditolak.
- [ ] UAT-04: client login menggunakan identitas dari profil dan tersimpan user_id.
- [ ] UAT-05: registrasi 10 akun berhasil, akun ke-11 ditolak, guest masih bisa konsultasi.
- [ ] UAT-06: client tidak bisa mengakses admin (403).
- [ ] UAT-07: client A tidak dapat membuka konsultasi client B.
- [ ] UAT-08: admin ubah status → client melihat status dan notifikasi.
- [ ] UAT-09: catatan privat tidak muncul di client, balasan admin muncul.
- [ ] UAT-10: detail konsultasi terbaca langsung di panel admin.
- [ ] UAT-11: harga yang diedit di admin tampil konsisten di katalog/detail.
- [ ] UAT-12: produk tanpa harga menampilkan teks penyesuaian.
- [ ] UAT-13: produk yang dihapus/diubah tetap ada dalam snapshot konsultasi.
- [ ] UAT-14: klik submit dua kali tidak membuat data ganda.
- [ ] UAT-15: notifikasi dapat ditandai dibaca dan menuju detail milik sendiri.
- [ ] UAT-16: demo tetap bisa diakses sebagai guest.

**Status verifikasi dalam paket ini:** lint sintaks PHP dan audit rute dijalankan; belum ada pengujian browser/DB end-to-end di lingkungan ini (ekstensi PHP `pdo_sqlite`, `mbstring`, dan `dom` tidak tersedia). Karena itu jangan menandai UAT sebagai Lulus tanpa menjalankan pengujian di komputer pengembang.
