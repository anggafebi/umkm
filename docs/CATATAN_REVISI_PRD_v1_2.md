# Catatan implementasi PRD v1.2 — Aditech Multisolusi

## Ruang lingkup perubahan

- **FR-06:** Halaman Tentang Kami memuat profil resmi CV. Aditif Tekno Multisolusi, visi/misi, nilai ATM, kapabilitas, dan deskripsi tim kolektif tanpa mengarang nama atau statistik.
- **FR-07:** Blok Cara Kerja di beranda menjadi tepat enam langkah: Konsultasi, Analisis, Proposal, Development, Testing, Launching. Layout desktop 3 kolom, tablet 2 kolom, ponsel 1 kolom.
- **FR-08:** Tautan Instagram resmi `https://www.instagram.com/aditech.id/` pada footer dan halaman Kontak. WhatsApp tetap ada. Tidak menambahkan LinkedIn tanpa URL resmi.
- **FR-09:** Balasan dua arah asinkron di satu konsultasi/nomor referensi. Client login membalas miliknya sendiri, admin/editor menerima notifikasi per akun, dan riwayat pesan tampil kronologis. Pesan tidak menggunakan WebSocket.
- **Tambahan permintaan:** Pilihan **Lainnya (ketik sendiri)** pada formulir konsultasi. Jika dipilih, input penjelasan wajib dan disimpan di kolom `service_interest` sebagai `Lainnya: ...`.

## Keamanan dan perilaku penting

- Route client `POST /akun/konsultasi/{consultation}/balasan` memeriksa middleware auth/client dan kepemilikan konsultasi di server. Route admin dibatasi middleware admin sebelumnya.
- Setelah konsultasi berstatus `closed`, baik client maupun admin tidak dapat mengirim pesan. Admin dapat mengganti status kembali ke `follow_up` melalui pengelolaan status yang sudah ada, dan status log tersimpan.
- Catatan internal `admin_notes` tidak ditampilkan di halaman client. Konsultasi guest tetap bisa dikirim tanpa login, tetapi tidak memiliki inbox publik.
- Notifikasi `consultation_client_reply` dibuat per admin/editor aktif, dan penanda dibaca mengikuti penerima masing-masing. Login/client, status tiket, produk, dan fitur ekspor CSV lama dipertahankan.
- Form balasan menggunakan CSRF, rate limit, validasi isi maks. 2.000 karakter, token unik per pengiriman yang disimpan di database, serta pencegahan submit ganda di UI.
- Tidak ada perubahan kuota 10 client, pengaturan remote Git, histori commit, atau struktur branch.

## Berkas utama yang berubah/ditambahkan

- `resources/views/about/index.blade.php`, `resources/views/home/index.blade.php`, `resources/views/layouts/footer.blade.php`, `resources/views/contact/index.blade.php`
- `resources/views/consultation/index.blade.php`, `app/Http/Controllers/ConsultationController.php`
- `resources/views/client/consultation-detail.blade.php`, `resources/views/client/consultations.blade.php`, `app/Http/Controllers/Client/AccountController.php`, `routes/web.php`
- `resources/views/admin/consultations/show.blade.php`, `resources/views/admin/consultations/index.blade.php`, `resources/views/admin/layouts/app.blade.php`, `app/Http/Controllers/Admin/ConsultationController.php`, `routes/admin.php`
- `app/Support/ConsultationNotifications.php`, `app/Models/ConsultationMessage.php`, CSS terkait, dan migration `2026_10_31_000002_add_tickets_reply_tokens.php`.

## Instalasi di Laragon / kolaborasi Git

1. **Backup database dan folder proyek sebelum memasang revisi.** ZIP menyertakan `.git` asli, namun saat menggabungkan ke working copy yang sudah ada, **jangan timpa `.git`, `.env`, `storage`, database, atau file upload** yang sudah aktif.
2. Setelah menyalin revisi ke working copy, lakukan review dengan `git status` dan `git diff`. Perubahan baseline PRD v1.0 yang sudah ada di ZIP masih uncommitted sebagaimana sumber; jangan otomatis menghapusnya.
3. Di root proyek Laravel, jalankan `composer install`, kemudian `php artisan migrate`, dan `php artisan optimize:clear`.
4. Login sebagai client dan admin pada dua browser/sesi berbeda. Kirim konsultasi produk, balas admin, balas client, lalu tutup dan buka kembali tiket. Periksa juga konsultasi guest dan input pilihan Lainnya.
5. Setelah pengujian lokal, commit ke branch kolaborasi terpisah, lalu buat pull request jika diperlukan. **Tidak ada commit/push yang dilakukan dalam ZIP ini.**

## Pemeriksaan yang sudah dilakukan

- `php -l` pada file PHP baru/diubah: lulus.
- Pendaftaran route Laravel untuk area akun dan konsultasi admin: lulus (menggunakan polyfill CLI sementara karena lingkungan ini tidak memiliki ekstensi `mbstring`; polyfill tidak disertakan dalam proyek).
- Kompilasi dan pemeriksaan sintaks 54 template Blade: lulus.
- Pengujian regresi statis v1.0 dan v1.2 (`python tests/prd_revision_smoke.py` dan `python tests/prd_v12_smoke.py`): lulus.
- **Belum diuji end-to-end dengan database/browser** dalam lingkungan ini karena ekstensi PHP `pdo_sqlite`/`mbstring`/`DOM` tidak tersedia. UAT fungsi nyata tetap wajib dijalankan di Laragon.

## Checklist UAT prioritas

- [ ] Tentang Kami lengkap dan tidak ada data tim atau statistik fiktif.
- [ ] Tepat 6 tahap Cara Kerja berurutan dan responsif.
- [ ] Instagram membuka URL resmi, WhatsApp tetap berfungsi.
- [ ] Guest dapat konsultasi; client login dapat melihat dan membalas tiket miliknya saja.
- [ ] Admin menerima notifikasi balasan client, lalu dapat membalas pada tiket yang sama.
- [ ] Client A tidak dapat membaca atau membalas tiket milik client B.
- [ ] Catatan internal admin tetap privat di seluruh halaman client.
- [ ] Tiket closed tidak menerima balasan; pembukaan kembali oleh admin memulihkan fungsi balas.
- [ ] Kebutuhan Lainnya wajib diisi, dan admin melihat teks hasil input.
- [ ] Cegah submit ganda, XSS, input kosong, dan pertahankan semua fitur demo, harga, login, kuota 10, dan ekspor CSV lama.
