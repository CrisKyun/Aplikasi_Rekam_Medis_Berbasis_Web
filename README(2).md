<div align="center">

<img src="public/images/logo-rediswangi.png" alt="Logo RedisWangi" width="140">

# RedisWangi

### Aplikasi Rekam Medis Berbasis Web untuk Pendataan Pasien di Tempat Praktik Mandiri dr. Luria Widijana Haribawanti

**Project Based Learning (PBL) Tahun 2026**

Program Studi Teknologi Rekayasa Perangkat Lunak  
Jurusan Bisnis dan Informatika  
Politeknik Negeri Banyuwangi

</div>

---

## Deskripsi Proyek

**RedisWangi** adalah aplikasi rekam medis berbasis web yang dikembangkan untuk membantu digitalisasi pelayanan di Tempat Praktik Mandiri dr. Luria Widijana Haribawanti.

Proyek ini dikembangkan berdasarkan permasalahan pencatatan rekam medis pasien yang masih dilakukan secara manual, kesulitan pengelolaan dan pencarian data pasien, serta kebutuhan pengelolaan antrean pelayanan yang lebih terstruktur. RedisWangi menyediakan layanan pengelolaan data pasien, rekam medis, dan antrean secara digital untuk mendukung proses pelayanan antara pasien dengan pihak klinik.

## Fitur yang Tersedia

Fitur RedisWangi disajikan berdasarkan fungsi yang tersedia pada proyek dan dokumentasi pelaksanaan PBL.

### Pasien

- Registrasi dan login pasien.
- Melihat informasi umum klinik.
- Mengakses dashboard pasien.
- Mengelola profil pasien.
- Melihat riwayat dan detail rekam medis.
- Melakukan pendaftaran antrean secara online.
- Melihat daftar antrean.
- Membatalkan antrean.
- Lupa password dan reset password.

### Dokter / Staf Klinik

- Login dokter atau staf.
- Mengakses dashboard pelayanan.
- Mencari dan melihat data pasien.
- Menambah, mengubah, melihat detail, dan menghapus data pasien.
- Mengelola status keaktifan pasien.
- Melihat, menambah, mengubah, dan menghapus rekam medis.
- Melakukan pencarian data ICD-10.
- Mengelola antrean pasien.
- Memanggil, menyelesaikan, dan membatalkan antrean.
- Mengubah estimasi antrean.
- Melihat indikator jumlah antrean.
- Mengelola informasi klinik.
- Mengelola data dokter.
- Melihat riwayat aktivitas sistem.

### Superadmin

- Mengelola data staf.
- Menambah, mengubah, dan menghapus data staf.

## Tech Stack

| Kategori | Teknologi |
| --- | --- |
| Bahasa Pemrograman | PHP `^8.3` |
| Framework Backend | Laravel `^13.0` |
| Template Engine | Laravel Blade |
| Frontend Styling | Tailwind CSS `^4.0.0` |
| Build Tool | Vite `^8.0.0` |
| Database Default Repository | SQLite |
| Package Manager Backend | Composer |
| Package Manager Frontend | npm |

## Panduan Instalasi dan Menjalankan Aplikasi

### Prasyarat

Pastikan komputer telah memiliki:

- PHP yang sesuai dengan requirement pada `composer.json`.
- Composer.
- Node.js dan npm.
- Git.
- Ekstensi PHP yang dibutuhkan oleh Laravel dan SQLite.

### 1. Clone Repository

```bash
git clone <URL-REPOSITORY-GITHUB-CLASSROOM>
cd <NAMA-FOLDER-REPOSITORY>
```

Ganti URL dan nama folder sesuai repository GitHub Classroom kelompok.

### 2. Install Dependency PHP

```bash
composer install
```

### 3. Buat File Environment

Windows Command Prompt:

```bash
copy .env.example .env
```

Linux, macOS, atau Git Bash:

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Siapkan Database

Konfigurasi default repository menggunakan SQLite. Jika file database belum tersedia, buat file:

```text
database/database.sqlite
```

Pastikan file `.env` menggunakan konfigurasi database yang sesuai dengan source code.

### 6. Jalankan Migration dan Seeder

```bash
php artisan migrate --seed
```

Seeder yang tersedia pada proyek meliputi:

- `DatabaseSeeder.php`
- `DokterSeeder.php`
- `Icd10Seeder.php`
- `InfoKlinikSeeder.php`
- `RoleSeeder.php`
- `UserSeeder.php`

### 7. Install Dependency Frontend

```bash
npm install
```

### 8. Jalankan Aplikasi

Proyek menyediakan script development pada `composer.json`:

```bash
composer dev
```

Sebagai alternatif, aplikasi dapat dijalankan secara terpisah menggunakan:

```bash
php artisan serve
```

dan pada terminal lain:

```bash
npm run dev
```

## Struktur Utama Proyek

```text
├── app/
│   ├── Console/
│   ├── Helpers/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Middleware/
│   └── Models/
├── config/
├── database/
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
├── tests/
├── .env.example
├── artisan
├── composer.json
├── package.json
└── vite.config.js
```

## Anggota Kelompok

| Nama | NIM |
| --- | --- |
| Cristiano Ronaldo | 362458302008 |
| M. Razaka Reza M | 362458302064 |
| Tsabitah Rifdah Nur Arifah | 362458302066 |
| Muhammad Mufqi Fajar | 362458302067 |

## Informasi Akademik

RedisWangi dikembangkan sebagai proyek **Project Based Learning (PBL) Tahun 2026** oleh mahasiswa Semester 4 Program Studi Teknologi Rekayasa Perangkat Lunak, Jurusan Bisnis dan Informatika, Politeknik Negeri Banyuwangi.

---

<div align="center">

**RedisWangi — Project Based Learning 2026**

</div>
