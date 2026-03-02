# Sistem Pendaftaran Magang (Laravel 12)

Sistem informasi pendaftaran magang berbasis web yang dibangun menggunakan **Laravel 12**, **Tailwind CSS**, dan **MySQL**. Aplikasi ini dirancang untuk memudahkan manajemen pendaftar dan instansi dalam satu platform terpusat.

## Fitur Utama
- **Manajemen Pendaftar**: CRUD data pendaftar magang.
- **Manajemen Instansi**: CRUD data instansi/perusahaan tujuan.
- **Status Approval**: Pengelolaan status (Pending, Diterima, Ditolak).
- **Export Data**: Export daftar pendaftar ke format Excel dan PDF.
- **UI/UX Modern**: Antarmuka responsif dengan desain minimalis menggunakan Tailwind CSS.

---

## Panduan Instalasi Localhost

Ikuti langkah-langkah di bawah ini untuk menjalankan project di komputer lokal Anda (menggunakan XAMPP/Laragon).

### 1. Persyaratan Sistem
Pastikan komputer Anda sudah terinstal:
- PHP >= 8.2
- Composer
- MySQL (XAMPP/Laragon)
- Node.js & NPM

### 2. Clone Repository
Buka terminal atau CMD, arahkan ke folder `htdocs` (jika menggunakan XAMPP),atau `www` (jika menggunakan laragon) lalu jalankan:
```bash
git clone https://github.com/muhammadfauzi440/Pendaftaran.git
cd Pendaftaran
```
### 3. Instalasi Dependency
Instal library PHP melalui Composer:

```bash
composer install
```
Instal asset frontend melalui NPM:
```bash
npm install
```
### 4. Konfigurasi Environment
Salin fle `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan nama database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=form_pendaftaran
DB_USERNAME=root
DB_PASSWORD=
```
### 5. Generate Application Key
Jalankan ini untuk membuat kunci keamanan aplikasi:
```bash
php artisan key:generate
```
### 6. Migrasi & Seeder Database
Pastikan database dengan nama `form_pendaftaran` sudah dibuat di database, lalu jalankan:
```bash
php artisan migrate --seed
```
### 7. Storage Link
Agar file dokumen yang diunggah bisa diakses secara publik:
```bash
php artisan storage:link
```

### 8. Jalankan Server
Jalankan server lokal Laravel
```bash
php artisan serve
```
Akses di browser melalui `http://127.0.0.1:8000`
```bash
npm run dev
```
untuk menjalankan server Vite

## Optional
```bash
npm run build
```

## Akun Akses Demo
- **Admin**: `admin@gi.com` | **Password**: `admin123` 
- **User**: `testing@gmail.com` | **Pasword**: `123456`