<div align="center">

<img src="public/images/logo-rediswangi.png" alt="Logo RedisWangi" width="150">

#RedisWangi

### Aplikasi Rekam Medis Berbasis Web di Tempat Praktik Mandiri dr. Luria Widijana Haribawanti

**Digitalisasi layanan kesehatan untuk pengelolaan pasien, rekam medis, dan antrean yang lebih terstruktur.**

`Laravel 13` · `PHP 8.3+` · `Tailwind CSS 4` · `SQLite` · `Vite 8`

</div>

---

## Tentang RedisWangi

**RedisWangi** adalah aplikasi rekam medis berbasis web yang dikembangkan untuk mendukung digitalisasi pelayanan di Tempat Praktik Mandiri dr. Luria Widijana Haribawanti.

Proyek ini berangkat dari proses pendataan pasien dan pencatatan rekam medis yang masih dilakukan secara manual. Kondisi tersebut dapat menyulitkan pencarian data pasien, meningkatkan risiko kehilangan data, menghambat koordinasi pelayanan, serta membuat proses pendaftaran dan antrean menjadi kurang efisien.

RedisWangi menghadirkan sistem terintegrasi yang menghubungkan kebutuhan pasien dengan pengelolaan layanan klinik. Melalui satu aplikasi, pasien dapat mengakses layanan antrean dan riwayat medis, sedangkan dokter atau staf dapat mengelola pasien, rekam medis, antrean, informasi klinik, dan aktivitas pelayanan.

## Dari Permasalahan Menuju Solusi Digital

| Permasalahan | Solusi RedisWangi |
| --- | --- |
| Pencatatan rekam medis masih dilakukan secara manual | Pengelolaan rekam medis secara digital |
| Pencarian data pasien membutuhkan waktu | Pencarian dan pengelolaan data pasien terintegrasi |
| Proses pendaftaran dan antrean kurang efisien | Pendaftaran antrean secara online |
| Riwayat pelayanan sulit dipantau | Riwayat rekam medis tersimpan dalam sistem |
| Pengelolaan layanan tersebar | Dashboard khusus untuk pasien, dokter/staf, dan superadmin |
| Aktivitas pengelolaan sistem sulit ditelusuri | Pencatatan riwayat aktivitas sistem |

---

## Pengalaman Sistem

RedisWangi dirancang dengan pembagian akses berdasarkan peran pengguna sehingga setiap pengguna memperoleh fungsi yang sesuai dengan kebutuhannya.

### Patient Experience

Pasien dapat melakukan registrasi dan autentikasi, mengakses dashboard, mengelola profil dan data pasien, melihat rekam medis, mendaftar antrean online, melihat daftar antrean, serta membatalkan antrean yang telah dibuat.

### Clinical Workspace

Dokter atau staf dapat mengakses dashboard pelayanan, mencari dan melihat data pasien, mengaktifkan atau menonaktifkan akun pasien, mengelola rekam medis, menggunakan pencarian ICD-10, mengelola antrean, memperbarui estimasi antrean, mengelola informasi klinik, mengelola data dokter, dan melihat riwayat aktivitas.

### System Administration

Superadmin memperoleh akses tambahan untuk mengelola data staf yang dapat menggunakan sistem.

---

## Fitur Utama

- **Autentikasi Multi-Role** — menyediakan alur autentikasi untuk pasien serta dokter/staf dengan pembatasan akses melalui middleware.
- **Manajemen Data Pasien** — menambah, melihat, memperbarui, menghapus, dan mencari data pasien.
- **Rekam Medis Digital** — mengelola riwayat rekam medis pasien melalui proses tambah, lihat, ubah, dan hapus data.
- **Antrean Online** — pasien dapat melakukan pendaftaran antrean dan memantau data antrean melalui sistem.
- **Pengelolaan Antrean Klinik** — dokter/staf dapat memanggil, menyelesaikan, membatalkan, dan memperbarui estimasi antrean.
- **Pencarian ICD-10** — mendukung pencarian data ICD-10 berdasarkan kode atau nama.
- **Pengelolaan Klinik dan Dokter** — menyediakan fungsi pengaturan informasi klinik serta pengelolaan data dokter.
- **Manajemen Status Pasien** — dokter/staf dapat mengatur status keaktifan akun pasien.
- **Activity History** — menyediakan halaman riwayat aktivitas untuk membantu penelusuran aktivitas sistem.
- **Forgot & Reset Password** — menyediakan alur permintaan dan pengaturan ulang kata sandi.
- **Staff Management** — superadmin dapat menambah, mengubah, dan menghapus data staf.

---

## Technology Behind RedisWangi

| Layer | Technology | Peran |
| --- | --- | --- |
| Backend Framework | Laravel 13 | Framework utama aplikasi |
| Programming Language | PHP 8.3+ | Logika dan proses server-side |
| Frontend | Blade & Tailwind CSS 4 | Antarmuka pengguna |
| Build Tool | Vite 8 | Pengelolaan dan bundling frontend assets |
| Database | SQLite | Database default pada konfigurasi repository |
| HTTP Client | Axios | HTTP request pada sisi frontend |
| Mail Library | PHPMailer 7 | Dukungan pengiriman email |
| Testing | PHPUnit 12 | Pengujian aplikasi |
| Development Tools | Laravel Pint, Pail, Tinker | Code formatting, log monitoring, dan interactive shell |

---

## Getting Started

Panduan berikut ditujukan bagi developer, dosen, atau pengguna repository yang ingin menjalankan RedisWangi pada komputer lokal.

### Prasyarat

Pastikan perangkat telah memiliki:

- PHP **8.3 atau lebih baru**
- Composer
- Node.js dan npm
- Git
- Ekstensi PHP yang dibutuhkan oleh Laravel dan SQLite

### 1. Clone Repository

```bash
git clone <URL-REPOSITORY-GITHUB-CLASSROOM>
cd <NAMA-FOLDER-REPOSITORY>
```

Ganti `<URL-REPOSITORY-GITHUB-CLASSROOM>` dan `<NAMA-FOLDER-REPOSITORY>` sesuai repository yang digunakan.

### 2. Install Backend Dependencies

```bash
composer install
```

### 3. Siapkan Environment

Untuk Windows Command Prompt:

```bash
copy .env.example .env
```

Untuk Linux, macOS, atau Git Bash:

```bash
cp .env.example .env
```

Kemudian generate application key:

```bash
php artisan key:generate
```

### 4. Siapkan Database SQLite

Konfigurasi default proyek menggunakan SQLite. Buat file database apabila belum tersedia.

Untuk Windows Command Prompt:

```bash
type nul > database\database.sqlite
```

Untuk Linux, macOS, atau Git Bash:

```bash
touch database/database.sqlite
```

Pastikan konfigurasi berikut tetap tersedia pada file `.env`:

```env
DB_CONNECTION=sqlite
```

### 5. Jalankan Migration dan Seeder

```bash
php artisan migrate --seed
```

Perintah ini membuat struktur database sekaligus mengisi data awal yang disediakan oleh proyek.

### 6. Install Frontend Dependencies

```bash
npm install
```

### 7. Jalankan Development Environment

RedisWangi menyediakan Composer script untuk menjalankan Laravel development server, queue listener, log monitoring, dan Vite secara bersamaan:

```bash
composer dev
```

Setelah server aktif, buka alamat lokal yang ditampilkan pada terminal.

### Alternatif: Menjalankan Service Secara Terpisah

Backend:

```bash
php artisan serve
```

Frontend development server:

```bash
npm run dev
```

Queue worker:

```bash
php artisan queue:listen --tries=1 --timeout=0
```

---

## Quick Setup

Repository juga menyediakan Composer setup script untuk mempersiapkan aplikasi:

```bash
composer setup
```

Script tersebut menjalankan instalasi dependency Composer, menyiapkan `.env`, membuat application key, menjalankan migration, menginstal dependency npm, dan melakukan frontend build.

> **Catatan:** konfigurasi database tetap perlu diperiksa sebelum menjalankan setup. Jika menggunakan SQLite dan file `database/database.sqlite` belum tersedia, buat file tersebut terlebih dahulu.

Setelah proses setup selesai, jalankan:

```bash
composer dev
```

---

## Database & Initial Data

RedisWangi menggunakan migration untuk membentuk struktur data aplikasi, termasuk data pengguna, role, dokter, jadwal dokter, pasien, pendaftaran, rekam medis, informasi klinik, password reset token, ICD-10, activity log, cache, dan queue jobs.

Data awal aplikasi dikelola melalui seeder:

```text
database/seeders/
├── DatabaseSeeder.php
├── DokterSeeder.php
├── Icd10Seeder.php
├── InfoKlinikSeeder.php
├── RoleSeeder.php
└── UserSeeder.php
```

Untuk membangun ulang database beserta data awal:

```bash
php artisan migrate:fresh --seed
```

> Perintah `migrate:fresh` akan menghapus seluruh tabel dan data yang telah tersimpan. Gunakan hanya pada environment pengembangan.

---

## Struktur Proyek

```text
RedisWangi/
├── app/
│   ├── Console/Commands/
│   ├── Helpers/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   └── Models/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
│   └── images/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
│   └── web.php
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
└── vite.config.js
```

---

## Development Team

| Nama | NIM |
| --- | --- |
| Cristiano Ronaldo | 362458302008 |
| Muhammad Razaka Reza Muharromi | 362458302064 |
| Tsabitah Rifdah Nur Arifah | 362458302066 |
| Muhammad Mufqi Fajar | 362458302067 |

---

## Academic Context

RedisWangi dikembangkan sebagai bagian dari **Project Based Learning (PBL) Tahun 2026** oleh mahasiswa Semester 4 Program Studi Teknologi Rekayasa Perangkat Lunak, Jurusan Bisnis dan Informatika, Politeknik Negeri Banyuwangi.

Proyek ini mengintegrasikan proses analisis kebutuhan, perancangan perangkat lunak, pengembangan aplikasi, pengalaman pengguna, keamanan perangkat lunak, dan manajemen proyek dalam penyelesaian permasalahan nyata pada mitra.

---

<div align="center">

<img src="public/images/logo-rediswangi.png" alt="Logo RedisWangi" width="80">

### RedisWangi

**Connecting patient care with structured digital health services.**

Project Based Learning · 2026

</div>
