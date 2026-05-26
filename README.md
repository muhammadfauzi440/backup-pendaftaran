# Sistem Pendaftaran Magang — PT Global Intermedia Nusantara

Sistem informasi pendaftaran magang berbasis web yang dibangun menggunakan **Laravel 12**, **Tailwind CSS (via Vite)**, dan **MySQL**. Aplikasi ini dirancang untuk memudahkan manajemen pendaftar dan instansi dalam satu platform terpusat, dilengkapi notifikasi otomatis melalui **WhatsApp (WAHA)** dan **Email (SMTP)**.

---

## Fitur Utama

| Fitur | Keterangan |
|---|---|
| Manajemen Pendaftar | CRUD data pendaftaran magang (individu & kelompok) |
| Manajemen Instansi | CRUD data instansi/kampus tujuan magang |
| Status Approval | Pengelolaan status: Pending, Diterima, Ditolak |
| Notifikasi WhatsApp | Kirim kode pendaftaran otomatis via WAHA API |
| Notifikasi Email | Kirim kode pendaftaran otomatis via SMTP |
| Kirim Ulang Notifikasi | User dapat kirim ulang notif via WhatsApp / Email dari dashboard |
| Export Data | Export daftar pendaftar ke Excel dan PDF |
| Cek Status Publik | Cek status pendaftaran menggunakan kode tanpa login |
| Audit Log | Rekam jejak setiap perubahan status oleh admin |
| Cetak Surat Balasan | Generate PDF surat penerimaan magang bagi yang diterima |
| UI/UX Modern | Antarmuka responsif, Alpine.js, SweetAlert2 |

---

## Persyaratan Sistem

| Komponen | Versi Minimum |
|---|---|
| PHP | >= 8.2 |
| Composer | >= 2.x |
| Node.js & NPM | >= 18.x |
| MySQL | >= 8.0 |
| Docker | >= 24.x _(untuk WAHA WhatsApp)_ |

---

## Panduan Instalasi Localhost

### 1. Clone Repository

Buka terminal, arahkan ke folder `www` (Laragon) atau `htdocs` (XAMPP), lalu jalankan:

```bash
git clone https://github.com/muhammadfauzi440/backup-pendaftaran.git
cd Pendaftaran
```

### 2. Instalasi Dependency

Instal library PHP melalui Composer:

```bash
composer install
```

Instal asset frontend melalui NPM:

```bash
npm install
```

### 3. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`:

```bash
copy .env.example .env   # Windows
cp .env.example .env     # Linux / macOS
```

Buka file `.env` dan sesuaikan konfigurasi berikut:

#### ▶ Konfigurasi Database (MySQL)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=backup_form_pendaftaran
DB_USERNAME=root
DB_PASSWORD=
```

#### ▶ Konfigurasi Email SMTP (Gmail)

> Gunakan **App Password** Gmail (bukan password biasa).  
> Aktifkan 2FA di akun Google → buat App Password di: https://myaccount.google.com/apppasswords

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME="emailanda@gmail.com"
MAIL_PASSWORD=xxxx_xxxx_xxxx_xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="emailanda@gmail.com"
MAIL_FROM_NAME="Admin PT Global Intermedia Nusantara"
```

#### ▶ Konfigurasi WAHA WhatsApp API

```env
WAHA_API_URL=http://localhost:3000
WAHA_API_KEY=waha_api_key_anda
```

> Pastikan container Docker WAHA sudah berjalan (lihat bagian **Instalasi WAHA** di bawah).

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Migrasi & Seeder Database

Pastikan database dengan nama sesuai `DB_DATABASE` sudah dibuat terlebih dahulu, lalu jalankan:

```bash
php artisan migrate --seed
```

### 6. Storage Link

Agar file dokumen yang diunggah dapat diakses secara publik:

```bash
php artisan storage:link
```

### 7. Jalankan Server

Jalankan server lokal Laravel:

```bash
php artisan serve
```

Di terminal terpisah, jalankan server Vite untuk asset frontend:

```bash
npm run dev
```

Akses aplikasi di browser: **http://127.0.0.1:8000**

---

## Instalasi WAHA (WhatsApp HTTP API) via Docker

WAHA adalah self-hosted WhatsApp API yang berjalan sebagai container Docker. Aplikasi ini menggunakan WAHA untuk mengirimkan notifikasi kode pendaftaran ke nomor HP peserta.

### 1. Pastikan Docker Sudah Terinstal

```bash
docker --version
```

Jika belum terinstal, unduh di: https://docs.docker.com/get-docker/

### 2. Pull Image WAHA

```bash
docker pull devlikeapro/waha
```

### 3. Jalankan Container WAHA

Buat dan jalankan container dengan konfigurasi environment kustom berikut:

```bash
docker run -d \
  --name waha \
  -p 3000:3000 \
  -e WAHA_DASHBOARD_USERNAME=username_anda \
  -e WAHA_DASHBOARD_PASSWORD=password_anda \
  -e WAHA_API_KEY=waha_api_key_anda \
  devlikeapro/waha
```

**Keterangan setiap argument `-e`:**

| Environment Variable | Nilai | Keterangan |
|---|---|---|
| `WAHA_DASHBOARD_USERNAME` | `username_anda` | Username login WAHA Dashboard |
| `WAHA_DASHBOARD_PASSWORD` | `password_anda` | Password login WAHA Dashboard |
| `WAHA_API_KEY` | `waha_api_key_anda` | API Key untuk autentikasi request dari Laravel |

> **Catatan:** Sesuaikan nilai `WAHA_API_KEY` dengan nilai `WAHA_API_KEY` yang ada di file `.env` Laravel Anda.

**Di Windows (PowerShell / CMD), gunakan format satu baris:**

```powershell
docker run -d --name waha -p 3000:3000 -e WAHA_DASHBOARD_USERNAME=username_anda -e WAHA_DASHBOARD_PASSWORD=password_anda -e WAHA_API_KEY=waha_api_key_anda devlikeapro/waha
```

### 4. Akses WAHA Dashboard

Setelah container berjalan, buka browser dan akses:

```
http://localhost:3000/dashboard
```

Login menggunakan:
- **Username**: `username_anda`
- **Password**: `password_anda`

### 5. Hubungkan WhatsApp (Scan QR Code)

1. Buka WAHA Dashboard → **http://localhost:3000/dashboard**
2. Klik tombol **"Start Session"** pada sesi `default`
3. Scan QR Code yang muncul menggunakan aplikasi WhatsApp di HP Anda
4. Tunggu hingga status berubah menjadi **WORKING** ✅

### 6. Cek Status Container

```bash
# Lihat log container
docker logs waha

# Cek container berjalan
docker ps

# Stop container
docker stop waha

# Start ulang container
docker start waha
```

---

## Konfigurasi `.env` Lengkap

Berikut adalah contoh konfigurasi `.env` yang lengkap untuk proyek ini:

```env
APP_NAME="Portal Magang PT Global Intermedia Nusantara"
APP_ENV=local
APP_KEY=base64:GENERATE_DENGAN_php_artisan_key:generate
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=id_ID

APP_MAINTENANCE_DRIVER=file

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_LEVEL=debug

# ─── Database ──────────────────────────────────────────────
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=form_pendaftaran
DB_USERNAME=root
DB_PASSWORD=

# ─── Session ───────────────────────────────────────────────
SESSION_DRIVER=database
SESSION_LIFETIME=120

# ─── Cache ─────────────────────────────────────────────────
CACHE_STORE=database
QUEUE_CONNECTION=sync

# ─── Email SMTP ────────────────────────────────────────────
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME="emailanda@gmail.com"
MAIL_PASSWORD=xxxx_xxxx_xxxx_xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="emailanda@gmail.com"
MAIL_FROM_NAME="Admin PT Global Intermedia Nusantara"

# ─── WAHA WhatsApp API ─────────────────────────────────────
WAHA_API_URL=http://localhost:3000
WAHA_API_KEY=waha_api_key_anda

VITE_APP_NAME="${APP_NAME}"
```

---

## Daftar Route Aplikasi

### 🌐 Publik (Tanpa Login)

| Method | URL | Nama Route | Keterangan |
|:---:|---|---|---|
| `GET` | `/` | — | Halaman landing/welcome |
| `GET` | `/login` | `login` | Form login |
| `POST` | `/login` | — | Proses login _(throttle: 5/menit)_ |
| `GET` | `/register` | `register` | Form registrasi |
| `POST` | `/register` | — | Proses registrasi _(throttle: 5/menit)_ |
| `POST` | `/logout` | `logout` | Proses logout |
| `GET` | `/lupa-password` | `password.request` | Form lupa password |
| `POST` | `/lupa-password` | `password.email` | Kirim link reset password |
| `GET` | `/reset-password/{token}` | `password.reset` | Form reset password |
| `POST` | `/reset-password` | `password.update` | Proses reset password |
| `GET` | `/cek-status` | `cek-status.index` | Halaman cek status publik |
| `POST` | `/cek-status` | — | API cek status by kode _(throttle: 5/menit)_ |

---

### 🔐 Admin (Middleware: `auth`, `role:admin`)

#### Dashboard & Pendaftaran

| Method | URL | Nama Route | Keterangan |
|:---:|---|---|---|
| `GET` | `/admin/dashboard` | `admin.dashboard` | Dashboard admin |
| `GET` | `/admin/kelola-pendaftaran` | `admin.pendaftaran.index` | List semua pendaftaran |
| `GET` | `/admin/kelola-pendaftaran/{id}` | `admin.pendaftaran.show` | Detail pendaftaran |
| `GET` | `/admin/kelola-pendaftaran/{id}/edit` | `admin.pendaftaran.edit` | Form edit pendaftaran |
| `PUT` | `/admin/kelola-pendaftaran/{id}` | `admin.pendaftaran.update` | Update pendaftaran |
| `DELETE` | `/admin/kelola-pendaftaran/{id}` | `admin.pendaftaran.destroy` | Hapus pendaftaran |
| `DELETE` | `/admin/kelola-pendaftaran/bulk-delete` | `admin.pendaftaran.bulkDestroy` | Hapus massal pendaftaran |
| `POST` | `/admin/kelola-pendaftaran/{id}/update-status` | `admin.pendaftaran.updateStatus` | Update status pendaftaran |

#### Manajemen Instansi

| Method | URL | Nama Route | Keterangan |
|:---:|---|---|---|
| `GET` | `/admin/instansi` | `admin.instansi.index` | List instansi |
| `GET` | `/admin/instansi/create` | `admin.instansi.create` | Form tambah instansi |
| `POST` | `/admin/instansi` | `admin.instansi.store` | Simpan instansi baru |
| `GET` | `/admin/instansi/{id}` | `admin.instansi.show` | Detail instansi |
| `GET` | `/admin/instansi/{id}/edit` | `admin.instansi.edit` | Form edit instansi |
| `PUT` | `/admin/instansi/{id}` | `admin.instansi.update` | Update instansi |
| `DELETE` | `/admin/instansi/{id}` | `admin.instansi.destroy` | Hapus instansi |

#### Manajemen Pengguna

| Method | URL | Nama Route | Keterangan |
|:---:|---|---|---|
| `GET` | `/admin/users` | `admin.users.index` | List semua user |
| `GET` | `/admin/users/create` | `admin.users.create` | Form tambah user |
| `POST` | `/admin/users` | `admin.users.store` | Simpan user baru |
| `GET` | `/admin/users/{id}/edit` | `admin.users.edit` | Form edit user |
| `PUT` | `/admin/users/{id}` | `admin.users.update` | Update user |
| `DELETE` | `/admin/users/{id}` | `admin.users.destroy` | Hapus user |

#### Export & Audit

| Method | URL | Nama Route | Keterangan |
|:---:|---|---|---|
| `GET` | `/admin/export/excel` | `admin.export.excel` | Export data ke Excel |
| `GET` | `/admin/export/pdf` | `admin.export.pdf` | Export data ke PDF |
| `GET` | `/admin/audit-logs` | `admin.audit-logs.index` | Lihat audit log |

---

### 👤 User (Middleware: `auth`, `role:user`)

| Method | URL | Nama Route | Keterangan |
|:---:|---|---|---|
| `GET` | `/user/dashboard` | `user.dashboard` | Dashboard user |
| `GET` | `/user/daftar` | `user.daftar` | Form pendaftaran |
| `POST` | `/user/daftar` | `user.daftar.store` | Submit pendaftaran baru |
| `PUT` | `/user/daftar` | `user.daftar.update` | Update data pendaftaran |
| `GET` | `/user/profile` | `profile.index` | Halaman profil user |
| `PUT` | `/user/profile/update` | `profile.update` | Update profil user |
| `GET` | `/user/cetak-surat` | `user.cetak-surat` | Download surat penerimaan (PDF) |
| `POST` | `/user/resend-notifikasi` | `user.resend-notifikasi` | Kirim ulang notifikasi (WA/Email) |

---

## Akun Demo

| Role | Email | Password |
|---|---|---|
| Admin | `admin@gi.com` | `admin123` |
| User | `testing@gmail.com` | `123456` |

---

## Struktur Teknologi

| Layer | Teknologi |
|---|---|
| Backend | Laravel 12 (PHP 8.2+) |
| Frontend | Blade, Tailwind CSS, Alpine.js, Vite |
| Database | MySQL 8.0 |
| Notifikasi WA | WAHA (Docker container) |
| Notifikasi Email | SMTP Gmail |
| PDF | DomPDF (barryvdh/laravel-dompdf) |
| Excel | Laravel Excel (maatwebsite) |
| UI Feedback | SweetAlert2 |

---

## Lisensi

Project ini dibuat untuk keperluan internal **PT Global Intermedia Nusantara**.
