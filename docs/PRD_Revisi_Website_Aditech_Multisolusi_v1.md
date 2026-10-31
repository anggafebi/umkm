## DOKUMEN KEBUTUHAN PRODUK

## PRODUCT REQUIREMENTS DOCUMENT

PRD Revisi Website Aditech Multisolusi

Dokumen kerja untuk pengembangan fitur berdasarkan hasil bimbingan dosen.

Berfokus pada 5 perubahan: konsultasi berbasis produk, akun client terbatas, harga awal produk, pesan sistem, dan pengelolaan konsultasi di admin.

| Informasi | Keterangan |
| --- | --- |
| Nama sistem | Aditech Multisolusi — Website Katalog & Konsultasi |
|   | Produk Digital |
| Jenis dokumen | Product Requirements Document (PRD) |
| Versi / status | 1.0 • Draft untuk pembahasan dan persetujuan |
| Tanggal penyusunan | 31 Oktober 2026 |
| Dasar penyusunan | 5 arahan revisi dosen + audit struktur kode ZIP |
|   | umkm15.zip |
| Teknologi teridentifikasi | Laravel / PHP, Blade, autentikasi berbasis session, |
|   | SQLite demo |

Catatan: Dokumen ini adalah rancangan kebutuhan, bukan implementasi kode. Harga, kapasitas akun, serta definisi pesan sistem perlu disepakati sebelum pembangunan.


## 01 / KONTEKS DAN TUJUAN

## Ringkasan revisi

Website saat ini sudah memiliki katalog produk, detail dan demo produk, form konsultasi, login admin/editor, serta dashboard leads. Revisi diarahkan untuk menjadikan konsultasi lebih kontekstual, memberikan akses tindak lanjut kepada client, dan mempermudah pengelolaan data oleh admin.

## Masalah yang diselesaikan

| Masalah saat ini | Dampak | Solusi PRD |
| --- | --- | --- |
| Tombol konsultasi pada detail produk | Admin belum dapat mengenali produk | Kirim ID produk melalui alur konsultasi |
| menuju form umum. | yang dimaksud secara pasti. | dan simpan snapshot nama produk. |
| Akun publik/client belum tersedia. | Client perlu mengulang identitas dan | Registrasi/login client, profil, riwayat, |
|   | tidak bisa memantau konsultasi. | status dan balasan. |
| Harga tampil sebagai nilai nominal. | Belum jelas bahwa harga adalah harga | Gunakan label “Mulai dari” untuk produk |
|   | awal. | yang berharga dasar. |
| Pesan sistem untuk aktivitas client belum | Client tidak memperoleh jejak pembaruan | Feedback form, notifikasi dalam akun, |
| terstruktur. | yang mudah dipahami. | dan balasan admin. |
| Admin melihat ringkasan lead di tabel dan | Informasi terkait produk dan tindak lanjut | Perkaya detail pada dashboard, balasan, |
| modal, CSV tersedia. | masih terbatas. | dan filter produk. |

## Tujuan produk dan indikator keberhasilan

- 100% konsultasi yang berasal dari detail produk menyimpan referensi produk yang valid atau snapshot-nya.

- Guest tetap bisa berkonsultasi; seluruh form guest mewajibkan nama, email dan WhatsApp.

- Client login melihat hanya konsultasinya sendiri, status terkini, dan balasan admin.

- Admin membaca isi lengkap konsultasi serta membalas tanpa membuka atau mengunduh CSV.

- Harga awal ditampilkan konsisten di daftar dan detail produk sesuai data yang dikelola admin.

Cakupan: pengembangan website saat ini — bukan redesain total maupun sistem pembayaran.


## 02 / PENGGUNA DAN BATASAN

## Aktor, akses, dan ruang lingkup

## Matriks hak akses

| Kemampuan | Guest | Client login | Admin / Editor |
| --- | --- | --- | --- |
| Lihat produk, detail, harga, | Ya | Ya | Ya |
| demo |   |   |   |
| Kirim konsultasi | Ya, isi identitas | Ya, identitas otomatis | Ya bila perlu |
| Lihat konsultasi sendiri | Tidak | Ya | — |
| Lihat status dan balasan | Hanya pesan konfirmasi saat | Ya | Ya, semua lead |
| admin | kirim |   |   |
| Ubah profil sendiri | Tidak | Ya | Ya |
| Lihat/kelola semua konsultasi | Tidak | Tidak | Ya |
| Ubah status / kirim balasan | Tidak | Tidak | Ya |
| Kelola produk dan harga | Tidak | Tidak | Sesuai izin CMS saat ini |

## Batas produk (keputusan PRD)

- Kuota: maksimal 10 akun dengan role client yang aktif. Akun admin dan editor tidak dihitung.

- Kuota berlaku ketika registrasi akun client; guest tidak memerlukan akun dan tidak dibatasi kuota 10.

- Saat kuota penuh, tampilkan pesan sistem yang jelas, tetapi akses katalog, demo dan konsultasi guest tetap terbuka.

- Batas 10 akun adalah pembatasan cakupan studi/kebutuhan, bukan jaminan otomatis website lebih ringan; optimasi query dan halaman tetap diperlukan.

## Prioritas

| Prioritas | Masuk cakupan | Di luar cakupan versi ini |
| --- | --- | --- |
| P0 — wajib | F01 konteks produk, F02 akun client dan | Pembayaran online; chat |
|   | kuota, F03 harga awal, F04 pesan sistem | real-time/WebSocket; sistem tiket multi- |
|   | dasar, F05 detail konsultasi admin + | agent. |
|   | balasan. |   |
| P1 — disarankan | Filter produk di admin, notifikasi belum | Notifikasi email/SMS otomatis; analitik |
|   | dibaca, timeline status, link referensi | komersial lanjutan. |
|   | konsultasi. |   |


## 03 / FR-01

## Konsultasi otomatis terhubung ke produk

User story: Sebagai calon client yang tertarik pada “POS Kasir Digital”, saya ingin form konsultasi langsung menunjukkan produk tersebut agar admin mengetahui konteks permintaan saya.

## FR-01.1 Konteks dari halaman produk

Tombol “Tanyakan Produk” di detail produk mengarahkan ke halaman konsultasi sambil membawa identitas produk (slug/ID).

- Form menampilkan kotak “Produk yang dikonsultasikan: POS Kasir Digital” sebagai ringkasan yang terlihat jelas.

- Client boleh mengisi kebutuhan spesifik, budget dan pesan seperti form saat ini.

- Server memvalidasi produk berdasarkan data asli; tidak mempercayai nama produk dari parameter pengguna.

## FR-01.2 Form konsultasi umum

Jika client membuka menu Konsultasi dari navbar tanpa memilih produk, form tetap dapat digunakan; kolom “Produk yang diminati” boleh dipilih atau dikosongkan.

- Nilai kosong disimpan sebagai konsultasi umum; admin melihat label “Umum / belum pilih produk”.

- Jika parameter produk tidak valid, sistem tidak boleh salah mengaitkan konsultasi ke produk lain.

## FR-01.3 Penyimpanan dan jejak produk

Saat submit, simpan product_id bila ada, dan nama produk saat dikirim (snapshot) agar konteks tetap tersedia bila katalog kemudian berubah.

- Dashboard admin menampilkan nama produk secara jelas di daftar dan halaman detail.

- Notifikasi internal admin / WhatsApp yang sudah tersedia, bila terkirim, juga menyertakan produk.

## Contoh tampilan dan proses

| Langkah | Tampilan / tindakan |
| --- | --- |
| 1. Detail produk | POS Kasir Digital • Mulai dari Rp5.000.000 • [Tanyakan |
|   | Produk] |
| 2. Form konsultasi | Konsultasi untuk: POS Kasir Digital | |
|   | Nama/Email/WhatsApp (guest) | Pesan |
| 3. Data tersimpan | ID konsultasi + product_id + nama_produk_snapshot + |
|   | identitas + isi pesan. |
| 4. Panel admin | Nama client — Produk: POS Kasir Digital — Status: Baru — |
|   | Buka Detail. |

## Kriteria penerimaan utama

- Klik “Tanyakan Produk” di POS → form dan daftar admin keduanya menampilkan POS Kasir Digital.

- Form umum tetap menerima konsultasi tanpa produk; perubahan atau penghapusan nama produk tidak menghilangkan snapshot historis.


## 04 / FR-02

## Akun client, login, dan batas 10 pengguna

Autentikasi admin/editor sudah ada di kode; kebutuhan baru adalah role client dengan halaman registrasi, login, profil, dan dashboard konsultasi pribadi.

## FR-02.1 Registrasi akun client

Client dapat membuat akun dengan nama, email unik, nomor WhatsApp dan password minimal 8 karakter.

- Validasi field wajib, konfirmasi password dan email unik.

- Jika jumlah akun client aktif sudah 10, tolak registrasi ke-11 secara aman serta tampilkan pesan kuota penuh.

- Proses hitung-kuota dan pembuatan akun harus atomik untuk mencegah dua registrasi bersamaan melewati batas.

## FR-02.2 Login, sesi, dan pengalihan

Client login menggunakan email/password; setelah berhasil diarahkan ke dashboard akun client, bukan admin. Admin/editor tetap menuju panel admin.

- Menu publik menampilkan “Masuk / Daftar” bagi guest, atau “Akun Saya / Keluar” bagi client.

- Endpoint admin tetap menolak role client (403); client yang belum login diarahkan ke login bila membuka halaman pribadi.

- Batasi percobaan login dan gunakan sesi aman serta password hash seperti pola autentikasi yang sudah ada.

## FR-02.3 Konsultasi oleh guest dan client

Guest wajib mengisi nama, email, WhatsApp serta pesan. Client yang login memperoleh data identitas dari profil secara otomatis.

- Form client menampilkan identitas tersimpan dalam ringkasan dan boleh menyediakan tautan Edit Profil.

- Identitas dicatat sebagai snapshot pada konsultasi; field user_id menghubungkan konsultasi ke akun client.

- Konsultasi guest tidak otomatis menjadi milik akun lain yang menggunakan email sama.

## FR-02.4 Profil pribadi

Client dapat melihat/mengubah nama, WhatsApp, email dan password dengan validasi aman.

- Perubahan profil berlaku untuk konsultasi berikutnya; riwayat sebelumnya tetap mempertahankan data saat pengiriman.

- Perubahan password tidak boleh memperlihatkan password lama, dan email tetap harus unik.

## Aturan batasan akun

Kuota dihitung hanya untuk role = client berstatus aktif. Jika belum dibuat fitur deaktivasi, implementasi awal menghitung seluruh akun client yang terdaftar. Penghapusan akun tidak menghapus riwayat konsultasi yang sudah tersimpan; relasi user_id diizinkan kosong setelah tindakan administratif yang sah.


## 04 / FR-02 LANJUTAN

## Dashboard akun dan riwayat konsultasi

## FR-02.5 Daftar riwayat

Client login dapat melihat daftar konsultasi miliknya: nomor referensi, tanggal, nama produk, cuplikan pesan, status, dan indikator balasan baru.

- Urutkan dari terbaru, dengan pagination sederhana apabila data bertambah.

- Tidak ada konsultasi milik client lain yang bisa ditampilkan, termasuk lewat manipulasi URL.

## FR-02.6 Detail konsultasi dan balasan

Client dapat membuka satu konsultasi untuk melihat pesan awal, informasi produk, status terakhir, pembaruan status, dan balasan resmi dari admin.

- Hanya pesan dengan jenis “balasan client” yang tampil; admin_notes tetap privat di sisi admin.

- Saat ada balasan atau status berubah, sistem membuat notifikasi untuk akun pemilik.

- Versi awal tidak wajib menyediakan balas-balik dari client; konsultasi lanjutan bisa dilakukan lewat WhatsApp atau konsultasi baru.

## Status yang ditampilkan ke client

| Status basis data | Label client | Makna singkat |
| --- | --- | --- |
| new | Baru | Konsultasi diterima dan menunggu |
|   |   | pemeriksaan. |
| contacted | Dihubungi | Admin mulai menindaklanjuti |
|   |   | konsultasi. |
| follow_up | Tindak lanjut | Masih ada diskusi atau kebutuhan |
|   |   | lanjutan. |
| deal | Disepakati | Ada kesepakatan lanjutan atas |
|   |   | kebutuhan client. |
| closed | Selesai | Konsultasi telah diselesaikan / ditutup. |

## Navigasi yang disarankan

| Halaman | Konten utama |
| --- | --- |
| /daftar | Pendaftaran client baru, petunjuk kuota, validasi error. |
| /login | Satu form login untuk seluruh role; hasil login mengarah sesuai |
|   | role. |
| /akun | Ringkasan akun: jumlah konsultasi, status terbaru, notifikasi |
|   | belum dibaca. |
| /akun/konsultasi | Riwayat konsultasi milik akun yang sedang login. |
| /akun/konsultasi/{id} | Detail konsultasi serta balasan admin yang dapat dibaca client. |
| /akun/profil | Form pembaruan profil. |

Catatan: Nama route di atas adalah usulan antarmuka, bukan bukti bahwa seluruh route sudah ada di kode.


## 05 / FR-03 DAN FR-04

## Harga awal dan pesan sistem

## FR-03 — Harga produk yang transparan

## FR-03.1 Format harga awal

Pada katalog, detail produk dan area produk unggulan di beranda, tampilkan “Mulai dari RpX” bagi produk yang memiliki harga dasar.

- Format Rupiah tanpa desimal: Rp3.500.000; menggunakan sumber harga dari database, bukan teks hard- coded.

- Harga POS Kasir Digital dalam data seed saat ini Rp5.000.000; Website Toko Online UMKM Rp3.500.000.

- Admin tetap bisa mengubah harga melalui panel produk; label harga awal sebaiknya ditentukan oleh pengaturan/flag produk.

- Jika harga kosong, gunakan teks “Harga menyesuaikan kebutuhan” dan tombol konsultasi, bukan angka Rp0.

## FR-03.2 Keterangan harga

Tampilkan keterangan pendek: “Harga awal. Total biaya dapat berubah sesuai fitur dan kebutuhan.” Hindari kesan bahwa harga awal adalah penawaran final.

## FR-04 — Pesan sistem dan notifikasi

Penafsiran yang digunakan dalam PRD ini: “pesan sistem” mencakup pemberitahuan otomatis di website, baik feedback aksi maupun notifikasi terkait konsultasi. Pengiriman email atau WhatsApp otomatis tambahan belum diwajibkan.

| Peristiwa | Pesan sistem yang harus terlihat | Penerima |
| --- | --- | --- |
| Guest/client mengirim form | “Konsultasi berhasil dikirim. Nomor | Pengirim |
|   | referensi: KSL-XXXX.” |   |
| Data formulir tidak lengkap | “Periksa nama, email, WhatsApp, dan | Pengirim |
|   | pesan.” + error per field. |   |
| Registrasi berhasil | “Akun berhasil dibuat. Silakan masuk.” | Client |
| Kuota client penuh | “Pendaftaran akun sedang ditutup | Calon client |
|   | (maksimal 10 akun). Anda tetap dapat |   |
|   | berkonsultasi tanpa login.” |   |
| Konsultasi baru | “Ada konsultasi baru: [produk / umum] dari | Admin/editor |
|   | [nama].” |   |
| Admin membalas | “Ada balasan baru untuk konsultasi | Client pemilik |
|   | [referensi].” |   |
| Status diperbarui | “Status konsultasi [referensi] berubah | Client pemilik |
|   | menjadi [status].” |   |

## Aturan pesan sistem

- Feedback submit harus jelas dan tidak menggandakan data bila tombol ditekan berulang; sediakan proteksi submit ganda.

- Notifikasi akun memiliki penanda dibaca/belum dibaca dan tautan ke detail konsultasi terkait.

- Guest hanya memperoleh pesan sukses pada halaman sesudah submit; tidak memperoleh inbox akun.


## 06 / FR-05

## Panel admin: konsultasi dibaca langsung

Kondisi eksisting: halaman admin sudah memiliki daftar leads, filter status dan pencarian, tombol “Kelola” yang membuka modal pesan, serta ekspor CSV. Revisi memperkuat tampilan dan alur kerja, bukan membangun daftar lead dari nol.

## FR-05.1 Daftar konsultasi yang informatif

Admin melihat tabel terbaru yang minimal memuat tanggal, nama client, WhatsApp/email, nama produk, status, dan jumlah balasan atau indikator belum dibaca.

- Filter berdasarkan status dan produk, cari nama/email/nomor telepon/pesan, serta pagination.

- Tombol “Lihat Detail” membuka halaman detail (disarankan) atau panel modal yang setara; tidak memerlukan CSV.

## FR-05.2 Detail lead lengkap

Admin dapat membaca semua data form, identitas, produk yang dipilih, budget, pesan, tanggal, status dan riwayat balasan.

- Admin dapat mengganti status dengan pilihan yang sudah ada: Baru, Dihubungi, Tindak lanjut, Disepakati, Selesai.

- Catatan internal admin berbeda dari kolom Balasan untuk Client dan tidak pernah terlihat oleh client.

- Admin dapat mengirim balasan, yang tercatat waktu, pengirim, dan konsultasi terkait.

## FR-05.3 Pemberitahuan admin

Konsultasi baru memberi indikator pada menu “Konsultasi” dan masuk daftar teratas. Tampilan boleh diperbarui melalui refresh biasa, tanpa syarat live update.

- Ekspor CSV dipertahankan sebagai fungsi opsional untuk pelaporan; bukan cara utama membaca pesan.

- Aksi update status dan pengiriman balasan dicatat dalam log aktivitas.

## Contoh detail konsultasi admin

| Area | Data atau aksi |
| --- | --- |
| Header | KSL-00042 • POS Kasir Digital • Status: Baru • Masuk 31 |
|   | Okt 2026 15.42 |
| Data client | Nama, WhatsApp, email, nama bisnis, budget, sumber: |
|   | website_detail_produk. |
| Isi konsultasi | Pesan lengkap dari client, bisa dibaca langsung tanpa CSV. |
| Tindakan admin | [Ubah Status] [Simpan Catatan Internal] [Kirim Balasan ke |
|   | Client] |
| Riwayat | Admin membalas 15.52, status berubah 15.55; balasan terlihat |
|   | oleh client login. |


## 07 / ALUR PENGGUNA

## Alur utama dan aturan bisnis

## Alur A — konsultasi produk oleh guest

Katalog → Detail POS Kasir Digital → Klik Tanyakan Produk → Form menampilkan POS → Guest isi nama + email + WhatsApp + pesan → Kirim → Validasi dan simpan referensi produk → Pesan sukses + kode referensi → Admin dapat melihat detail.

## Alur B — konsultasi produk oleh client login

Login → Detail produk → Konsultasi → Identitas otomatis dari profil + produk terbaca → Kirim → Riwayat konsultasi bertambah → Admin mengubah status / membalas → Notifikasi dalam akun → Client melihat status dan balasan.

## Alur C — tindak lanjut oleh admin

Admin login → Menu Konsultasi (badge baru) → Filter / buka detail → Cek data client + produk → Ubah status → Isi Catatan Internal (opsional) → Kirim Balasan Client → Sistem menyimpan pesan dan mengirim notifikasi dalam akun jika konsultasi milik registered client.

## Aturan bisnis yang wajib dijaga

| Kode | Aturan |
| --- | --- |
| BR-01 | Produk yang datang dari detail divalidasi server-side; |
|   | product_id dan snapshot harus sesuai. |
| BR-02 | Guest: nama, email, WhatsApp dan pesan wajib. Client login: |
|   | sumber identitas dari profil. |
| BR-03 | Satu konsultasi dapat terkait 0 atau 1 produk. 0 artinya |
|   | konsultasi umum. |
| BR-04 | Maksimal 10 akun client; akun admin dan editor dikecualikan |
|   | dari kuota. |
| BR-05 | Client hanya dapat membuka konsultasi yang memiliki user_id = |
|   | ID akun sendiri. |
| BR-06 | Catatan internal admin bukan pesan client dan tidak boleh |
|   | dikirim ke inbox client. |
| BR-07 | Perubahan status dan balasan tersimpan sebagai peristiwa |
|   | terpisah agar dapat diaudit. |
| BR-08 | Hapus/ubah produk atau data profil tidak menghapus isi |
|   | konsultasi historis. |

## Halaman utama yang terdampak

Publik: navbar, detail produk, katalog produk, area produk unggulan di beranda, form konsultasi, login dan registrasi. Client: dashboard akun, riwayat, detail, profil, notifikasi. Admin: daftar konsultasi, detail konsultasi, produk dan harga.


## 08 / RANCANGAN TEKNIS

## Perubahan data dan keamanan

Rancangan berikut mengikuti pola Laravel / Blade dan entitas database yang teridentifikasi dari berkas ZIP. Nama kolom baru merupakan usulan implementasi.

## Perubahan skema data

| Entitas | Perubahan yang diusulkan | Alasan |
| --- | --- | --- |
| users | Tambah role client; phone; status aktif | Akun client / profil / batas kapasitas. |
|   | (opsional). Tetap gunakan email unik dan |   |
|   | password hash. |   |
| consultations | Tambah user_id nullable, product_id | Riwayat kepemilikan dan identifikasi |
|   | nullable, product_name_snapshot | produk. |
|   | nullable, reference_code unik. Field lama |   |
|   | tetap. |   |
| products | Pakai price yang sudah ada; tambah | Format “Mulai dari” fleksibel. |
|   | price_is_starting_at boolean bila |   |
|   | diperlukan. |   |
| consultation_messages | Tabel baru: id, consultation_id, | Balasan admin terpisah dari catatan |
|   | sender_user_id, sender_role, body, | internal. |
|   | created_at, read_at nullable. |   |
| system_notifications | Tabel baru: user_id penerima, | Notifikasi client/admin dan indikator |
|   | consultation_id nullable, type, title, body, | belum dibaca. |
|   | read_at, timestamps. |   |
| consultation_status_logs | Opsional P1: consultation_id, old_status, | Timeline pembaruan status. |
|   | new_status, changed_by, created_at. |   |

## Keamanan, kinerja, dan kualitas

- Gunakan middleware auth serta pemeriksaan role dan policy kepemilikan konsultasi di server, bukan hanya menyembunyikan tombol di UI.

- CSRF untuk seluruh form POST/PUT, validasi server, escaping output Blade, dan query menggunakan ORM / parameter binding.

- Password disimpan sebagai hash; rate limiting login dan registrasi; jangan pernah memperlihatkan password atau data client lain.

- Kuota akun diberlakukan secara atomik, termasuk permintaan registrasi simultan; buat pengujian kondisi race.

- Gunakan pagination dan index database untuk consultations.user_id, product_id, status, created_at; minimalkan query per halaman.

- Aksesibilitas dasar: label form, fokus keyboard, error per field, kontras memadai, serta feedback sukses yang diumumkan screen reader.

- Jaga kompatibilitas rute publik, demo produk, login admin/editor, serta struktur data konsultasi yang sudah ada.

## Catatan migrasi

Gunakan migrasi baru tanpa menghapus record sebelumnya. Konsultasi lama tetap dapat ditampilkan sebagai “Umum / data produk belum tersedia”; user_id bisa NULL. Perlu data back-up sebelum migrasi pada database yang aktif.


## Skenario UAT dan kriteria selesai

Pengerjaan dinyatakan selesai apabila seluruh skenario P0 lulus pada browser desktop dan mobile serta tidak merusak fungsi demo dan admin eksisting.

| ID | Skenario pengujian | Ekspektasi kelulusan |
| --- | --- | --- |
| UAT-01 | Guest klik Tanyakan Produk di POS. | Form menyebut POS; admin melihat POS |
|   |   | untuk lead tersebut. |
| UAT-02 | Guest membuka konsultasi langsung dari | Form tetap dapat dipakai tanpa produk; |
|   | navbar. | label admin “Umum”. |
| UAT-03 | Guest kirim form tanpa email. | Server menolak dan menunjukkan error |
|   |   | di email. |
| UAT-04 | Client login mengirim konsultasi. | Nama/email/WA dari profil; konsultasi |
|   |   | terhubung user_id. |
| UAT-05 | Buat 10 akun client, lalu daftar akun ke-11. Akun 10 lolos; ke-11 ditolak dengan pesan |   |
|   |   | kuota; guest tetap bisa konsultasi. |
| UAT-06 | Client login lalu akses /admin/dashboard. Ditolak 403; admin/editor tetap bisa |   |
|   |   | masuk admin. |
| UAT-07 | Client A mengakses ID konsultasi client | Ditolak 403/404; tidak ada kebocoran |
|   | B. | data. |
| UAT-08 | Admin mengubah status konsultasi client. Status tersimpan dan terlihat pada detail |   |
|   |   | client; notifikasi muncul. |
| UAT-09 | Admin menulis catatan internal dan | Client hanya melihat balasan, bukan |
|   | balasan. | catatan internal. |
| UAT-10 | Admin membuka pesan konsultasi baru. | Data lengkap terbaca di dashboard tanpa |
|   |   | unduh CSV. |
| UAT-11 | Ubah harga produk di admin. | Katalog dan detail menampilkan “Mulai |
|   |   | dari Rp...” sesuai nilai. |
| UAT-12 | Produk tanpa harga dasar. | Tampil “Harga menyesuaikan |
|   |   | kebutuhan”; tidak ada Rp0. |
| UAT-13 | Nama produk berubah / produk dihapus. | Konsultasi lama tetap menampilkan nama |
|   |   | produk saat dikirim. |
| UAT-14 | Kirim form gagal / klik cepat berulang. | Error jelas; tidak membuat lead ganda |
|   |   | akibat double-submit biasa. |
| UAT-15 | Notifikasi client dibuka. | Status dibaca tersimpan; tautan menuju |
|   |   | konsultasi miliknya. |
| UAT-16 | Coba demo produk sebagai guest. | Demo tetap dapat dibuka tanpa akun. |

## Definition of Done

- Semua fitur P0 selesai dan diuji; bug kritis keamanan/otorisasi = 0.

- Data baru dan data lama sama-sama dapat dibuka; migrasi berhasil dan dapat dipulihkan bila gagal.

- Alur guest, client, dan admin memiliki pesan sukses/gagal yang jelas.

- Skenario UAT ditandai Lulus/Gagal dengan bukti tangkapan layar oleh pengembang.


## 10 / IMPLEMENTASI

## Urutan pengerjaan dan keputusan

## Rencana implementasi bertahap

| Tahap | Pekerjaan | Hasil yang dapat diuji |
| --- | --- | --- |
| 1. Fondasi | Migrasi user/client, relasi konsultasi- | Bisa daftar/login, kuota 10, keamanan |
|   | produk, kode referensi dan role access. | route dan skema data. |
| 2. Konsultasi produk | Ubah tombol detail produk, form dengan | UAT-01 s.d. UAT-04 dan UAT-13. |
|   | konteks, penyimpanan snapshot, aturan |   |
|   | guest/client. |   |
| 3. Area client | Dashboard akun, profil, riwayat, detail | UAT-06, UAT-07 dan riwayat. |
|   | konsultasi, status. |   |
| 4. Admin & balasan | Detail lead, produk di daftar, filter, | UAT-08 s.d. UAT-10. |
|   | catatan privat, balasan client. |   |
| 5. Harga & notifikasi | Format mulai dari, informasi harga, | UAT-11, UAT-12, UAT-15. |
|   | feedback pesan dan notifikasi. |   |
| 6. Uji & perbaikan | UAT keseluruhan, uji mobile, regresi | Seluruh skenario P0 lulus. |
|   | admin/demo, dokumentasi. |   |

## Risiko dan mitigasi

| Risiko | Mitigasi |
| --- | --- |
| Penambahan akun client mengganggu login admin saat ini. | Pertahankan route/role admin dan lakukan regression test. |
|   | Login diarahkan menurut role. |
| Jumlah akun client melewati 10 akibat registrasi simultan. | Validasi kuota di level database transaction, bukan hanya di |
|   | tampilan. |
| Catatan admin tidak sengaja muncul pada halaman client. | Pisahkan field admin_notes dan tabel balasan client; tes |
|   | otorisasi. |
| Konsultasi lama tidak memiliki produk dan user_id. | Field nullable dan fallback tampilan; hindari migrasi destruktif. |
| Harga “mulai dari” menimbulkan salah paham. | Tambahkan catatan harga awal dan lakukan review harga per |
|   | produk. |

## Keputusan yang perlu dikonfirmasi sebelum coding

- Definisi 10 akun: PRD menetapkan 10 akun client aktif, tidak termasuk admin/editor.

- Makna “pesan sistem”: PRD menetapkan alert aksi + notifikasi di dashboard, bukan chat real-time.

- Harga: angka existing dianggap harga dasar jika admin menandai produk “Mulai dari”; perlu validasi daftar harga.

- Balasan: versi ini mewajibkan admin → client login. Guest ditindaklanjuti melalui kontak WhatsApp/email yang diberikan, bukan inbox publik.

- Akun client dihapus/dinonaktifkan: harus dijaga agar data konsultasi historis tidak ikut hilang.


## 11 / LAMPIRAN AUDIT

## Referensi kondisi kode yang diperiksa

Daftar ini bertujuan membantu pengembang menelusuri bagian yang terdampak. Temuan berasal dari inspeksi statis berkas pada ZIP; fungsi belum dijalankan dan bukan hasil pengujian langsung di browser.

| Komponen kode | Temuan / perubahan |
| --- | --- |
| routes/web.php | Route /produk, /produk/{slug}, /konsultasi dan POST /konsultasi |
|   | sudah ada; perlu pengantar konteks produk. |
| resources/views/products/detail.blade.php | Tombol “Tanyakan produk” saat ini menuju route consultation umum |
|   | tanpa parameter produk. |
| resources/views/products/index.blade.php | Harga sudah ditampilkan pada kartu produk sebagai “Rp ...” atau |
|   | “Hubungi kami”. |
| app/Models/Product.php & ProductController | Product memiliki name, slug, description, price, image; harga sudah |
|   | berasal dari model. |
| resources/views/consultation/index.blade.php | Form meminta name dan WhatsApp; email sekarang opsional; |
|   | service_interest dipilih manual. |
| app/Http/Controllers/ConsultationController.php | Server menyimpan lead dan mencoba mengirim notifikasi |
|   | WhatsApp; belum menyimpan user_id/product_id. |
| routes/auth.php & Auth/LoginController.php | Login dan logout sudah ada, dengan rate limit; login berhasil |
|   | diarahkan ke admin dashboard. |
| app/Models/User.php & AdminMiddleware.php | Role admin/editor sudah dipakai; belum ada akses publik untuk |
|   | client. |
| admin/consultations/index.blade.php | Ada tabel leads, filter status, modal Kelola yang bisa membaca |
|   | pesan, dan tombol Export CSV. |
| Admin/ConsultationController.php | Admin dapat mengubah status dan admin_notes, tetapi belum ada |
|   | balasan client yang terpisah. |
| database/migrations/* | Consultations sudah punya status, admin_notes, last_contacted_at |
|   | dan source; users punya role. |
| database/seeders/ProductSeeder.php | Harga contoh: Website Toko Online UMKM Rp3.500.000; POS Kasir |
|   | Digital Rp5.000.000. |

Dokumen disusun sebagai baseline revisi. Perubahan kebutuhan baru setelah persetujuan sebaiknya dicatat sebagai versi 1.1 agar cakupan pengerjaan tetap terkendali.
