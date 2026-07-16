# Personal Portfolio — Destria Angelyne

Website portofolio pribadi yang dibangun sebagai bagian dari **PKL (Praktik Kerja Lapangan)** dan persiapan **UKK (Uji Kompetensi Keahlian)** jurusan Rekayasa Perangkat Lunak, SMK Negeri 2 Surabaya.

🔗 **Live Demo:** _(isi link Vercel kamu di sini)_

## Tentang Project

Portofolio ini dibangun untuk menampilkan profil, riwayat pendidikan, keahlian teknis, proyek-proyek yang pernah dikerjakan, serta menyediakan form kontak yang fungsional — semuanya dikelola secara dinamis lewat database, bukan konten statis.

## Fitur Utama

- **Hero section interaktif** — foto profil dengan efek reveal warna saat hover, plus glow border
- **Background animasi berlapis** — kombinasi shader Three.js (GLSL) dan partikel (tsParticles)
- **Marquee showcase teknologi** — ikon tech stack dengan efek kaca cembung (glassmorphism) yang scroll otomatis
- **Timeline pendidikan** vertikal dengan animasi scroll
- **Kartu proyek** dengan spotlight cursor-glow, menampilkan deskripsi, tech stack, dan fitur utama tiap proyek
- **Soft skills showcase**
- **Form kontak fungsional** — terhubung ke email (SMTP), dilengkapi rate limiting dan honeypot anti-spam
- **Unduh CV** langsung dari halaman utama
- **Scroll progress bar** dan tombol back-to-top
- Desain **dark theme**, responsif penuh untuk desktop dan mobile

## Tech Stack

**Backend**
- Laravel
- MySQL

**Frontend**
- Vue 3
- Inertia.js
- Tailwind CSS
- Three.js (background shader)
- tsParticles (efek partikel)

**Tools & Lainnya**
- Vite
- Mailtrap / Gmail SMTP (pengiriman pesan kontak)

## Proyek yang Ditampilkan

Beberapa proyek unggulan yang ditampilkan di dalam portofolio ini:

- **Sistem Informasi Puskesmas** — Laravel REST API + Vue 3 SPA (TypeScript, Pinia) dengan empat peran pengguna (Admin, Loket, Perawat, Pasien)
- **AgriNova** — platform e-commerce agritech (Laravel + Inertia + Vue 3)

## Instalasi & Menjalankan Secara Lokal

```bash
# Clone repository
git clone https://github.com/DestriaAngelyne/Personal-Portofolio.git
cd Personal-Portofolio

# Install dependency PHP
composer install

# Install dependency JavaScript
npm install

# Salin file environment
cp .env.example .env
php artisan key:generate

# Sesuaikan koneksi database & SMTP di file .env

# Jalankan migrasi dan seeder
php artisan migrate --seed

# Buat symbolic link storage (untuk foto profil & gambar proyek)
php artisan storage:link

# Jalankan server development
php artisan serve
npm run dev
```

Buka `http://127.0.0.1:8000` di browser.

## Struktur Environment

Beberapa variabel penting yang perlu diisi di `.env`:

```
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

MAIL_MAILER=
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
```

## Kontak

Terbuka untuk peluang magang, kolaborasi, dan pengembangan proyek menarik.

- 📍 Surabaya, Jawa Timur
- 🏫 SMK Negeri 2 Surabaya — Rekayasa Perangkat Lunak

---

© 2026 Destria Angelyne. Dibuat sebagai bagian dari PKL & UKK RPL.
