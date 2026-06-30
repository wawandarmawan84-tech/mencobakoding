# SiPenKa — Sistem Pengaduan Masyarakat Kelurahan Konoha

Dokumen ini memberikan panduan setup lokal untuk project SiPenKa.

## Prasyarat

- PHP 8.3+
- Composer
- Node.js + npm
- MySQL 8.0+
- Git

## Setup Lokal

1. Salin file environment:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

2. Install dependensi PHP dan JavaScript:

   ```bash
   composer install
   npm install
   ```

3. Buat database MySQL lokal dan sesuaikan konfigurasi di `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sipenka
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   Contoh SQL jika ingin membuat database manual:

   ```sql
   CREATE DATABASE sipenka;
   ```

4. Jalankan migrasi dan seed data awal:

   ```bash
   php artisan migrate --seed
   ```

   Jika ingin membersihkan database lalu migrate ulang dengan seed, gunakan:

   ```bash
   php artisan migrate:fresh --seed
   ```

5. Buat storage link agar file upload dapat diakses:

   ```bash
   php artisan storage:link
   ```

6. Jalankan server lokal:

   ```bash
   php artisan serve
   npm run dev
   ```

## Informasi `.env`

Pastikan konfigurasi berikut sudah benar untuk environment lokal:

- `APP_NAME=SiPenKa`
- `APP_ENV=local`
- `APP_DEBUG=true`
- `APP_URL=http://localhost`
- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=sipenka`
- `DB_USERNAME=root`
- `DB_PASSWORD=`

## Akun Default (Seeder)

Jika project telah menyediakan seeder, akun default biasanya dapat dibuat dengan perintah `php artisan migrate:fresh --seed`.

- Email: `warga@test.com` | Password: `password`
- Email: `petugas@test.com` | Password: `password`
- Email: `admin@test.com` | Password: `password`

## Catatan Penting

- Jangan commit file `.env` ke repository.
- Gunakan `npm run dev` untuk development dan `npm run build` untuk produksi.
- Pastikan MySQL berjalan sebelum menjalankan migrasi.
