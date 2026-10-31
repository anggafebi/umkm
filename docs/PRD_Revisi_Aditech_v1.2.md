# PRODUCT REQUIREMENTS DOCUMENT (PRD)
## Revisi Website Aditech Multisolusi — Versi 1.2

**Status:** Draft untuk persetujuan dosen/tim  
**Tanggal:** 31 Oktober 2026  
**Produk:** Website Katalog Layanan & Konsultasi Aditech Multisolusi  
**Jenis perubahan:** Pengembangan bertahap pada proyek Laravel yang sudah ada, **bukan** pembangunan ulang  
**Sumber:** *Brief Project Website Catalog Layanan Website Development UMKM* (9 halaman); *ADITECH MULTISOLUSI* (company profile, 8 halaman); PRD revisi v1.0; dan arahan revisi terbaru.

> **Kendali perubahan:** PRD ini menambahkan FR-06 sampai FR-09 di atas baseline PRD v1.0. Semua fitur lama (katalog, demo, harga mulai dari, login admin/editor dan client, konsultasi berbasis produk, riwayat, notifikasi, ekspor CSV) tetap dipertahankan. PRD ini tidak mewajibkan checkout maupun payment gateway.

---

## 1. Ringkasan eksekutif

Website Aditech berfungsi sebagai *company profile*, katalog layanan, portfolio/demo, serta kanal untuk menangkap dan menindaklanjuti calon client. Empat revisi diperlukan: (1) memperkaya halaman Tentang Kami memakai profil resmi; (2) menyamakan alur Cara Kerja menjadi enam tahap sesuai brief; (3) menambahkan tautan media sosial resmi; dan (4) mengubah balasan konsultasi satu arah menjadi **tiket percakapan dua arah** untuk akun client yang login. Untuk pengunjung tanpa akun, mekanisme konsultasi guest tetap berjalan dan tindak lanjut dilakukan melalui kontak yang diserahkan.

### 1.1 Masalah dan hasil yang dituju

| Kode | Kondisi saat ini | Hasil yang dibutuhkan |
|---|---|---|
| FR-06 | Profil/prinsip ada, tetapi visi–misi serta tim belum terstruktur | Tentang Kami memuat profil, visi, misi, nilai inti, tim, dan pengalaman yang dapat dipertanggungjawabkan |
| FR-07 | Cara Kerja menampilkan empat tahap | Menjadi enam tahap: Konsultasi → Analisis → Proposal → Development → Testing → Launching |
| FR-08 | WhatsApp ada, Instagram resmi belum tampil jelas | Instagram resmi bisa diakses dari website publik |
| FR-09 | Admin dapat membalas, client login hanya membaca | Client dan admin dapat mengirim beberapa pesan dalam satu tiket konsultasi yang sama |

**Indikator keberhasilan:** seluruh skenario UAT prioritas P0 lulus; identitas/tiket konsultasi serta produk terkait tidak berubah akibat balasan; data client lain dan catatan internal tidak bocor; alur konsultasi guest dan login admin lama tetap berfungsi.

## 2. Ruang lingkup, prioritas, dan aktor

**Dalam cakupan (P0):** konten resmi Tentang Kami; 6 tahap Cara Kerja; link Instagram; balasan client pada tiket miliknya; tampilan percakapan urut waktu di client dan admin; otorisasi, validasi, notifikasi dan indikator belum dibaca; status tiket; regresi fitur lama.

**P1 (bila tersedia waktu):** manajemen anggota tim via CMS; unggah foto tim; filter tiket berdasarkan pesan terbaru; pencarian di percakapan; indikator ketikan tidak disertakan.

**Di luar cakupan:** checkout/pembayaran, WebSocket/live chat real-time, bot AI, unggahan lampiran pada chat, edit/hapus pesan setelah terkirim, inbox publik bagi guest, akun LinkedIn yang belum diberikan.

| Aktor | Izin utama |
|---|---|
| Guest | Melihat halaman publik dan media sosial; mengirim konsultasi dengan nama, email, WhatsApp, pesan; tidak bisa membuka inbox tiket publik |
| Client login | Melihat dan membalas **hanya** tiket miliknya; membaca status, balasan, dan notifikasi; mengubah profil |
| Admin/editor berizin | Melihat seluruh tiket; membalas client; mengubah status; mencatat catatan internal; mengelola konten sesuai kewenangan CMS |

**Batas akun dari PRD v1.0:** maksimal 10 akun **client** aktif; admin/editor tidak dihitung. Guest tidak terkena kuota. Pembatasan ini tidak berubah.

---

## 3. FR-06 — Penyempurnaan halaman Tentang Kami

### 3.1 Konten yang wajib ditampilkan

1. **Identitas dan profil perusahaan.** Nama legal: **CV. Aditif Tekno Multisolusi**; merek: **Aditech Multisolusi**. Ringkasan dari dokumen profil: perusahaan *system integrator* dan penyedia solusi TI terpadu, dengan fokus pengembangan aplikasi web/mobile, pengadaan perlengkapan/peralatan kantor, dan pembangunan infrastruktur digital; melayani kebutuhan B2G dan B2B. Naskah pada web boleh diringkas tanpa mengubah substansi.
2. **Visi (mengikuti dokumen resmi, halaman 2):** “Menjadi mitra system integrator terpercaya dalam menyediakan solusi teknologi terpadu yang andal, adaptif, dan berkelanjutan.”
3. **Misi (mengikuti dokumen resmi, halaman 2):** “Mendorong efisiensi, modernisasi, dan keamanan sistem kerja sektor publik maupun swasta melalui penyediaan solusi digital, fasilitas kantor modern, serta layanan terintegrasi yang andal dan terpercaya.”
4. **Nilai inti ATM (mengikuti dokumen resmi, halaman 5):** **A — Accountability & Integrity**, **T — Teamwork & Trust**, **M — Mastery & Improvement**. Tampilkan deskripsi singkat yang setia pada makna dalam profil: tanggung jawab dan keterbukaan; kolaborasi serta kepercayaan; peningkatan kemampuan berkelanjutan.
5. **Tim.** Sediakan bagian “Tim Kami” dengan struktur nama, jabatan/peran, foto (opsional), dan deskripsi singkat. **Dokumen perusahaan yang diberikan tidak mencantumkan nama anggota tim.** Jangan mengarang nama/foto/jabatan. Jika data belum disetujui, jangan tampilkan kartu placeholder fiktif; boleh gunakan subbagian “Tim di balik layanan kami” dengan deskripsi kolektif non-spesifik hingga data tersedia.
6. **Pengalaman/kompetensi.** Jelaskan kapabilitas terverifikasi yang sesuai profil: pengembangan website/aplikasi, integrasi sistem, dan implementasi proyek. Profil memuat halaman *Partnership* dan *Mitra Kami* (halaman 6–7), tetapi **tidak menyediakan tahun pengalaman, jumlah proyek, atau studi kasus per proyek**. Dilarang membuat angka/klaim keberhasilan sendiri. Logo pihak lain hanya dipublikasikan ulang setelah persetujuan perusahaan dan hak pakai dipastikan.

### 3.2 Perilaku dan tata letak

- Pertahankan rute **Tentang Kami** saat ini, identitas visual, navbar, footer, dan desain responsif.
- Urutan konten yang disarankan: Hero/Profil → Visi dan Misi → Nilai Inti → Kompetensi/Pengalaman → Tim → CTA Konsultasi.
- Bila tim belum tersedia, susunan halaman tetap rapi; bagian kosong tidak boleh menampilkan data palsu.
- Konten dapat dikelola sesuai pola aplikasi yang sudah ada. Jangan membuat sistem CMS baru bila halaman dapat diperbarui dari mekanisme yang tersedia.
- CTA “Konsultasikan Kebutuhan” tetap menuju form konsultasi yang sudah berjalan.

### 3.3 Kriteria penerimaan

- Visi/misi identik secara substansi dengan dokumen resmi; nilai ATM ditampilkan lengkap.
- Bagian tim tidak mengandung profil rekaan; deskripsi pengalaman tidak menggunakan angka yang tidak bersumber.
- Halaman bisa diakses tanpa login dan terbaca baik di layar mobile/desktop.

---

## 4. FR-07 — Perubahan Cara Kerja menjadi enam tahap

### 4.1 Urutan dan copy yang wajib

| No. | Tahap | Deskripsi untuk pengunjung |
|---|---|---|
| 1 | **Konsultasi** | Client menyampaikan kebutuhan dan tujuan bisnis. |
| 2 | **Analisis** | Tim mempelajari kebutuhan dan menentukan pendekatan solusi. |
| 3 | **Proposal** | Tim menyampaikan rekomendasi solusi, lingkup pekerjaan, dan penawaran bila diperlukan. |
| 4 | **Development** | Tim mengembangkan website atau sistem sesuai kebutuhan yang disepakati. |
| 5 | **Testing** | Tim menguji fungsi dan kesiapan sistem sebelum digunakan. |
| 6 | **Launching** | Website atau sistem disiapkan untuk digunakan dan diserahkan sesuai kesepakatan. |

Urutan dan nama tahap mengikuti brief pada bagian “Cara Kerja”; deskripsi merupakan penyajian ulang untuk kejelasan UI, bukan janji operasional tambahan.

### 4.2 Implementasi UI

- Ganti blok empat tahap lama di beranda/halaman relevan, **tidak** menambahkan blok duplikat.
- Desain dapat memakai timeline enam langkah atau grid responsif (desktop 3×2, mobile satu kolom).
- Tiap tahap memiliki nomor berurutan, judul, deskripsi singkat, ikon konsisten; jangan membingungkan tahap proyek dengan **status tiket konsultasi**.
- Pertahankan CTA konsultasi dan gaya website yang sudah ada.

### 4.3 Kriteria penerimaan

- Tepat enam tahap dalam urutan di atas, tanpa tahap lama tersisa pada lokasi yang diganti.
- Tahap tampil rapi di desktop/mobile dan mudah dibaca keyboard/screen reader.

---

## 5. FR-08 — Integrasi media sosial

### 5.1 Sumber tautan resmi

**Instagram Aditech:** https://www.instagram.com/aditech.id/  
**LinkedIn:** belum ada tautan resmi yang disertakan; **tidak ditambahkan** sampai URL terverifikasi diberikan.

### 5.2 Perilaku

- Tambahkan ikon dan label aksesibel **Instagram Aditech** di footer, serta bagian kontak bila relevan; jangan menimpa WhatsApp.
- Klik membuka URL yang diberikan melalui tab baru dengan `target="_blank"` dan `rel="noopener noreferrer"`.
- Hanya tautan yang diisi/diaktifkan ditampilkan. Tidak boleh membuat profil sosial dummy.
- Jika sudah tersedia mekanisme pengaturan kontak dalam CMS, gunakan itu; jika belum, gunakan konfigurasi sederhana yang mudah dikelola tanpa membuat migrasi baru hanya untuk satu URL.

### 5.3 Kriteria penerimaan

- Tautan Instagram tepat dan terlihat di desktop/mobile; ikon memiliki nama aksesibel.
- WhatsApp dan formulir konsultasi tetap berfungsi; LinkedIn tidak mengarah ke akun fiktif.

---

## 6. FR-09 — Tiket konsultasi dua arah client ↔ admin

### 6.1 Tujuan dan prinsip

Satu permintaan konsultasi menjadi **satu tiket** dengan nomor referensi yang sama (mis. `KSL-00042`). Client login dan admin dapat bertukar beberapa pesan tanpa membuka konsultasi baru. Ini adalah **percakapan asinkron berbasis database**, bukan live chat. Halaman dapat memperlihatkan balasan baru setelah refresh; polling opsional bukan syarat P0.

### 6.2 Alur utama

1. Client login memilih produk (mis. POS Kasir Digital) atau membuka konsultasi umum, lalu mengirim permintaan seperti sekarang.
2. Server membuat konsultasi beserta `reference_code`, `user_id`, `product_id` bila ada, dan `product_name_snapshot`; pesan awal tetap tercatat pada entitas konsultasi lama.
3. Admin membuka daftar dan detail tiket; admin mengirim balasan melalui kolom **Balasan untuk Client**.
4. Client menerima notifikasi dan membuka **Akun Saya → Riwayat Konsultasi → Detail**.
5. Client menulis **Balas Pesan** pada tiket miliknya; pesan tersimpan dengan pengirim, isi, dan waktu; admin mendapat indikator pesan baru.
6. Admin dapat membalas kembali berkali-kali dalam tiket yang sama; pesan diurutkan kronologis dan memiliki label pengirim yang jelas.
7. Admin mengubah status sesuai proses bisnis. Jika `closed` (Selesai), input balasan client dinonaktifkan dan diberi pesan “Konsultasi telah selesai”; admin dapat **membuka kembali** tiket sebelum percakapan dilanjutkan, dengan catatan peristiwa status.

### 6.3 Aturan guest dan akun client

- **Guest:** dapat mengirim konsultasi seperti PRD v1.0, wajib nama + email + WhatsApp + pesan; menerima nomor referensi dan konfirmasi. Tidak mendapat akses ke URL detail tiket tanpa akun. Tindak lanjut dilakukan lewat kontak yang diberikan.
- **Client login:** tidak perlu mengisi identitas berulang; dapat membaca/mengirim pesan hanya untuk tiket dengan `consultations.user_id = auth()->id()`.
- Tiket guest **tidak otomatis diklaim** oleh akun client hanya karena email sama. Jika ingin fitur klaim tiket di masa depan, buat PRD tersendiri dengan verifikasi kepemilikan.
- Admin/editor berizin dapat melihat tiket guest maupun client. **Catatan internal admin (`admin_notes`) tidak pernah ditampilkan pada halaman client atau di endpoint pesan client.**

### 6.4 Aturan pesan, status, dan pemberitahuan

| Peristiwa | Tindakan sistem |
|---|---|
| Client mengirim balasan | Simpan `sender_user_id`, `sender_role=client`, `body`, timestamp; buat notifikasi admin/editor berizin; tampilkan pesan berhasil |
| Admin membalas tiket client | Simpan pengirim admin dan pesan; buat notifikasi untuk pemilik tiket; tampilkan pada timeline client |
| Admin membalas tiket guest | Pesan dicatat di panel admin; **tidak** diklaim terkirim ke guest melalui website; tindak lanjut lewat kontak eksternal jika diperlukan |
| Status berubah | Simpan log perubahan; tampilkan status terbaru; notifikasi pemilik tiket login |
| Tiket selesai | Input client nonaktif; riwayat tetap bisa dibaca; pembukaan kembali hanya oleh admin/editor berizin |
| User melakukan submit berulang | Cegah double-submit biasa di UI dan validasi idempoten di server untuk permintaan ulang dengan kunci unik per pengiriman |

**Status eksisting yang dipertahankan:** `new` (Baru), `contacted` (Dihubungi), `follow_up` (Tindak lanjut), `deal` (Disepakati), `closed` (Selesai). Status “Disepakati” bukan berarti pembayaran atau checkout sudah terjadi.

**Perbedaan teknis penting:** indikator *pesan belum dibaca* harus mengikuti pembaca (client/admin), bukan hanya `read_at` global yang saling bertabrakan ketika admin lebih dari satu. Implementasi minimal boleh menggunakan notifikasi per penerima; model pembacaan pesan yang lebih detail bisa ditambahkan bila diperlukan.

### 6.5 Tampilan halaman

**Detail tiket client:** nomor referensi, nama/snapshot produk, status, pesan awal, **Percakapan Konsultasi** (balon/panel pesan admin dan client, waktu pesan), kolom `Balas Pesan`, tombol `Kirim Balasan`, serta riwayat status. Input tidak tampil ketika tiket ditutup.

**Detail tiket admin:** data client, konteks produk, budget, pesan awal, timeline balasan dua arah, kolom `Balasan untuk Client`, **kolom `Catatan Internal` terpisah**, aksi ubah status dan buka kembali tiket; daftar tiket menampilkan indikator balasan client baru. Pertahankan export CSV yang sudah ada sebagai fitur opsional.

**Notifikasi:** client mendapat tautan ke tiket miliknya; admin mendapat tautan ke detail tiket. Notifikasi yang dibaca disimpan statusnya; jangan memperlihatkan isi sensitif melalui notifikasi untuk pengguna tak berwenang.

### 6.6 Aturan otorisasi dan keamanan

- Gunakan middleware autentikasi dan pemeriksaan role/kepemilikan di controller/policy/server pada **GET detail, POST pesan, status, dan notifikasi**. Manipulasi ID tiket tidak boleh mengungkap data milik client lain.
- Validasi `body` wajib, teks dengan batas misalnya 2.000 karakter; buang konten kosong; lakukan escaping output Blade agar pesan tidak menjadi XSS; tidak menerima HTML arbitrer.
- Semua POST menggunakan CSRF dan throttle yang proporsional; tentukan pelaku dari session, **bukan** parameter `sender_role` dari browser.
- Saat mengirim balasan, cek status tiket di dalam transaksi; balasan tidak boleh diterima sesudah tiket `closed` kecuali dibuka kembali oleh admin.
- Simpan jejak balasan dan perubahan status, termasuk waktu dan pengirim; jangan hapus konsultasi historis saat mengubah nama produk atau profil.
- Jangan mengganti/menghapus isi kolom catatan internal lama ataupun mengubah perizinan admin yang sudah ada.

---

## 7. Rancangan teknis minimum (Laravel / Blade)

**Pendekatan:** migrasi **tambahan**, bukan reset database; gunakan route, service, model, dan komponen Blade yang sudah tersedia bila memungkinkan.

| Bagian | Kebutuhan perubahan |
|---|---|
| `consultations` | Tetap gunakan `id`, `reference_code`, `user_id`, `product_id`, `product_name_snapshot`, `status`, `admin_notes` dan data lama; **tidak perlu tabel tiket baru** |
| `consultation_messages` | Gunakan tabel balasan yang sudah direncanakan/ada; izinkan pesan `sender_role=client` maupun admin/editor; `consultation_id`, `sender_user_id`, `body`, timestamps; indeks `(consultation_id, created_at)` |
| `system_notifications` | Gunakan notifikasi per penerima untuk balasan baru/status; `user_id`, `consultation_id`, `read_at`, tipe |
| `consultation_status_logs` | Catat perubahan status termasuk `closed → follow_up` saat tiket dibuka kembali; gunakan tabel yang sudah ada atau migrasi tambahan bila belum tersedia |
| Controller client | Tambah endpoint `POST /akun/konsultasi/{id}/balasan` dengan verifikasi pemilik tiket |
| Controller admin | Sesuaikan detail dan pengiriman balasan agar mendukung percakapan dua arah; pengirim admin tetap server-side |
| Blade client/admin | Ganti label “Balasan Admin” menjadi “Percakapan Konsultasi” dan tambahkan form balas untuk client |
| Tentang Kami | Ubah template/konten eksisting tanpa membuat route duplikat |
| Cara Kerja | Ganti susunan empat tahap yang aktif di UI menjadi enam tahap |
| Media sosial | Tambahkan Instagram pada footer/kontak menggunakan konfigurasi yang aman |

**Kompatibilitas:** pertahankan struktur `.git`, nama branch, remote GitHub, `.env`, database, file upload, katalog, demo, autentikasi admin/editor, role client dengan kuota 10, notifikasi, halaman guest, route lama, dan ekspor CSV. Jangan commit ulang histori Git atau mengganti remote. Hindari perubahan yang tidak diperlukan.

### 7.1 Referensi alur route (usulan; cek nama aktual sebelum coding)

- `GET /akun/konsultasi/{id}` — detail dan timeline milik client.
- `POST /akun/konsultasi/{id}/balasan` — client kirim balasan baru.
- `GET /admin/konsultasi/{id}` — detail semua pesan dan catatan admin sesuai izin.
- `POST /admin/konsultasi/{id}/balasan` — admin kirim balasan.
- `PATCH /admin/konsultasi/{id}/status` — admin ubah status/buka kembali.

Endpoint di atas **rancangan**, bukan jaminan nama route dalam ZIP; gunakan pola route aktual saat implementasi supaya tidak merusak kompatibilitas.

---

## 8. Rancangan layar ringkas

### 8.1 Tentang Kami

`Profil Perusahaan` → `Visi | Misi` → `Nilai ATM` → `Kompetensi & Pengalaman` → `Tim Kami (jika data sah)` → `CTA Konsultasi`.

### 8.2 Cara Kerja

`01 Konsultasi` → `02 Analisis` → `03 Proposal` → `04 Development` → `05 Testing` → `06 Launching`.

### 8.3 Detail konsultasi

```text
KSL-00042  |  POS Kasir Digital  |  Tindak lanjut
----------------------------------------------------
Pesan awal — Client                         09.00
Saya membutuhkan POS untuk tiga kasir.

Admin                                       09.10
Apakah ketiga kasir berbagi data stok?

Client                                      09.15
Iya, dan saya butuh laporan harian.

Admin                                       09.20
Baik, kami akan mencatat kebutuhan tersebut.
----------------------------------------------------
[ Tulis balasan...                           ]
[ Kirim Balasan ]
```

Contoh ini **hanya ilustrasi UI**; bukan data client sebenarnya. Pesan tidak terkirim secara real-time tanpa refresh.

---

## 9. Pengujian penerimaan (UAT)

| ID | Skenario | Hasil yang diharapkan | Prioritas |
|---|---|---|---|
| UAT-17 | Buka Tentang Kami tanpa login | Profil, visi, misi, dan nilai ATM terbaca | P0 |
| UAT-18 | Periksa tim ketika belum ada data anggota resmi | Tidak ada nama/foto/jabatan fiktif atau kartu kosong | P0 |
| UAT-19 | Periksa klaim pengalaman | Tidak terdapat jumlah proyek/tahun pengalaman tanpa sumber | P0 |
| UAT-20 | Periksa Cara Kerja | Tepat 6 tahap dan urutan sesuai brief | P0 |
| UAT-21 | Klik Instagram dari footer | Membuka `https://www.instagram.com/aditech.id/` | P0 |
| UAT-22 | Buka website di ponsel | Konten, timeline, dan Instagram responsif | P0 |
| UAT-23 | Client login mengirim konsultasi produk POS | Tiket dan snapshot produk tersimpan, nomor referensi muncul | P0 |
| UAT-24 | Admin membalas tiket client | Pesan muncul pada timeline client dan notifikasi dibuat | P0 |
| UAT-25 | Client membalas pesan admin | Pesan muncul di timeline tiket yang **sama**, admin mendapat indikator baru | P0 |
| UAT-26 | Admin membalas lagi | Pertukaran berulang tercatat berurutan dengan pengirim dan waktu | P0 |
| UAT-27 | Client A memalsukan ID tiket client B | Ditolak 403/404 pada detail dan endpoint balasan | P0 |
| UAT-28 | Client mencoba mengakses catatan internal admin | Tidak terlihat di HTML/API/notifikasi client | P0 |
| UAT-29 | Guest membuat konsultasi | Guest tetap dapat mengirim tanpa akun; tidak mendapat inbox publik | P0 |
| UAT-30 | Client membalas tiket berstatus Selesai | Dilarang server-side; UI menunjukkan konsultasi selesai | P0 |
| UAT-31 | Admin membuka kembali tiket | Log status tersimpan, client bisa membalas kembali | P0 |
| UAT-32 | Submit balasan kosong atau mengandung script | Server menolak kosong; konten tersimpan/ditampilkan aman dari XSS | P0 |
| UAT-33 | Dua kali klik Kirim cepat | Tidak muncul dua pesan akibat double-submit biasa | P0 |
| UAT-34 | Guest mencoba demo produk, admin login dan ekspor CSV | Semua fitur lama tetap berfungsi | P0 |
| UAT-35 | Registrasi akun client ke-11 | Tetap ditolak; admin/editor tidak masuk hitungan | P0 |
| UAT-36 | Admin melakukan perubahan status | Client menerima informasi status; notifikasi terbaca dan dapat ditandai dibaca | P0 |

**Definition of Done:** UAT-17 s.d. UAT-36 lulus; pengujian regresi UAT v1.0 terkait katalog, konsultasi, harga, auth, dan keamanan juga lulus; migrasi data tanpa kehilangan riwayat; tidak ada kebocoran data, bypass perizinan, maupun rusaknya demo.

---

## 10. Urutan implementasi dan batas perubahan

| Tahap | Implementasi | Bukti selesai |
|---|---|---|
| 1 | Audit route, migration, tampilan yang sudah ada; backup DB dan cek `git status` | Baseline dan perubahan terdokumentasi |
| 2 | Tentang Kami: profil, visi/misi, ATM, kompetensi/tim tanpa data fiktif | UAT-17–19 |
| 3 | Cara Kerja enam tahap; Instagram di footer | UAT-20–22 |
| 4 | Backend balasan dua arah, policy kepemilikan, status tertutup/buka kembali | UAT-23–32 |
| 5 | Notifikasi, indikator balasan baru, pencegahan submit ganda | UAT-24–25, 33, 36 |
| 6 | Uji desktop/mobile, regresi, review dengan dosen/tim, dokumentasi perubahan | UAT-17–36 dan regresi v1.0 |

### 10.1 Risiko dan mitigasi

- **Balasan bocor ke user lain:** authorization di query/controller, bukan hanya menyembunyikan tombol.
- **`admin_notes` bocor:** model tampilan/API balasan dipisahkan dari catatan internal.
- **Tiket lama tanpa user:** nullable `user_id` tetap sah; jangan mengubahnya menjadi akun baru otomatis.
- **Perubahan konten tidak sahih:** gunakan visi/misi profil resmi, jangan merekayasa nama tim atau metrik pengalaman.
- **Duplikasi/perubahan Git:** buat perubahan seminimal mungkin; `.git` dan `.env` tidak disentuh, migrasi baru bersifat non-destruktif.
- **Akun client penuh:** guest tetap dapat konsultasi; kuota 10 tidak diperluas oleh fitur chat.

---

## 11. Keputusan yang perlu disetujui tim

1. **Nama/posisi anggota tim dan izin foto** belum tersedia dalam profil PDF; bagian dapat disembunyikan atau diisi setelah mendapat data resmi.
2. **Konten pengalaman** hanya memuat kompetensi dan sumber yang dapat diverifikasi; proyek/logo klien ditampilkan setelah izin publikasi dikonfirmasi.
3. **Instagram** memakai `https://www.instagram.com/aditech.id/`; LinkedIn ditunda sampai URL resmi tersedia.
4. **Percakapan dua arah** hanya untuk client login dan admin; guest tetap memakai WhatsApp/email untuk tindak lanjut.
5. **Tiket selesai** hanya dapat dibuka kembali oleh admin/editor berizin; tidak otomatis dibuka client.
6. **Balasan asinkron** (refresh halaman) dipilih untuk versi ini; tidak membutuhkan live chat, WebSocket, atau pembayaran.

## 12. Referensi dokumen

- *Brief Project Website Catalog Layanan Website Development UMKM*, halaman 5–7 (Cara Kerja, form konsultasi, alur pengunjung, fitur wajib dan media sosial).
- *ADITECH MULTISOLUSI*, halaman 2 (profil, visi, misi), halaman 4 (keunggulan), halaman 5 (nilai inti ATM), halaman 6–7 (referensi kemitraan), halaman 8 (kontak).
- *PRD Revisi Website Aditech Multisolusi v1.0*, FR-01 sampai FR-05 (konsultasi berbasis produk, client login/kuota, harga, notifikasi, dan pengelolaan admin).

**Status akhir dokumen:** Draft kebutuhan implementasi. Persetujuan tim/dosen diperlukan sebelum mengubah kode website.
