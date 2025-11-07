# 🏠 Sistem Manajemen Kost

Aplikasi manajemen kost berbasis web yang dibangun dengan Laravel 11. Sistem ini menyediakan fitur lengkap untuk mengelola properti kost, penghuni, pembayaran, booking, keluhan, dan rating.

![Laravel](https://img.shields.io/badge/Laravel-11.60-red?style=flat&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue?style=flat&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-orange?style=flat&logo=mysql)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=flat&logo=tailwind-css)

## 📋 Daftar Isi

- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Requirements](#-requirements)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Menjalankan Aplikasi](#-menjalankan-aplikasi)
- [User Default](#-user-default)
- [Struktur Proyek](#-struktur-proyek)
- [Dokumentasi Tambahan](#-dokumentasi-tambahan)

## ✨ Fitur Utama

### 🔐 Autentikasi & Otorisasi
- Login dan registrasi custom (tanpa package)
- Role-based access control (Admin/Pemilik & Penyewa)
- Middleware untuk proteksi route

### 👨‍💼 Panel Admin (Pemilik Kost)
- **Dashboard** dengan statistik lengkap
- **Manajemen Kamar** (CRUD kamar, upload foto multiple, fasilitas)
- **Manajemen Fasilitas** (CRUD fasilitas kamar)
- **Manajemen Penghuni** (tambah penghuni, perpanjang kontrak, checkout)
- **Manajemen Pembayaran** (record pembayaran, konfirmasi, laporan)
- **Manajemen Booking** (approve/reject booking dari publik)
- **Manajemen Keluhan** (terima dan respon keluhan dari penghuni)
- **Rating & Review** (lihat semua rating, delete jika tidak pantas)
- **Laporan Keuangan** (filter per periode, export Excel/PDF)
- **Laporan Okupansi** (statistik hunian, export Excel/PDF)

### 👤 Panel Penyewa (Penghuni)
- **Dashboard** dengan info kamar dan tagihan
- **Pembayaran Saya** (lihat history dan tagihan)
- **Keluhan** (buat keluhan baru, lihat status)
- **Rating & Review** (beri rating untuk kamar yang dihuni)

### 🌐 Halaman Publik
- **Landing Page** dengan featured rooms
- **Daftar Kamar** dengan filter (tipe, harga)
- **Detail Kamar** dengan foto dan fasilitas
- **Booking Online** (tanpa login)
- **Form Kontak**

### 🚀 Performance & Optimization
- Database indexing untuk query cepat
- Query caching dengan auto-invalidation
- Eager loading untuk mencegah N+1 queries
- Image optimization configuration
- Slow query logging

## 🛠 Tech Stack

- **Framework**: Laravel 11.60
- **PHP**: 8.2+
- **Database**: MySQL 8.0+
- **Frontend**:
  - Tailwind CSS (via CDN)
  - Alpine.js (untuk interaktivitas)
  - Blade Templates
- **Authentication**: Custom authentication
- **File Storage**: Local storage (public disk)

## 📦 Requirements

Sebelum instalasi, pastikan sistem Anda memiliki:

- PHP >= 8.2
- Composer
- MySQL >= 8.0 atau MariaDB >= 10.3
- Apache/Nginx
- Extension PHP yang diperlukan:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath
  - Fileinfo
  - GD (untuk image processing)

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd KosProject
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Copy Environment File

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Buat Database

Buat database MySQL baru:

```sql
CREATE DATABASE kost_management;
```

### 6. Konfigurasi Database

Edit file `.env` dan sesuaikan dengan konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kost_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 7. Jalankan Migrasi dan Seeder

```bash
php artisan migrate --seed
```

Perintah ini akan:
- Membuat semua tabel database
- Menambahkan data dummy untuk testing
- Membuat user default (admin dan tenant)

### 8. Buat Storage Link

```bash
php artisan storage:link
```

Link ini diperlukan agar foto kamar dapat diakses dari browser.

### 9. Set Permissions (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
```

## ⚙️ Konfigurasi

### Cache Configuration

Edit `.env` untuk mengatur cache:

```env
CACHE_STORE=database
CACHE_PREFIX=kost_
CACHE_ENABLED=true
CACHE_DURATION=3600
```

### Image Upload Configuration

```env
MAX_IMAGE_SIZE=5120
ALLOWED_IMAGE_TYPES=jpg,jpeg,png
```

### Performance Monitoring (Optional)

```env
LOG_SLOW_QUERIES=true
SLOW_QUERY_THRESHOLD=1000
PERFORMANCE_MONITORING=false
```

### WhatsApp Integration (Optional)

Jika ingin menggunakan notifikasi WhatsApp via Fonnte:

```env
WHATSAPP_API_URL=https://api.fonnte.com/send
WHATSAPP_API_TOKEN=your_fonnte_token
```

## 🏃 Menjalankan Aplikasi

### Development Server

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

### Production Deployment

Untuk deployment production, jalankan optimisasi:

```bash
# Install dependencies (production only)
composer install --optimize-autoloader --no-dev

# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Optimize everything
php artisan optimize
```

**PENTING**: Jangan lupa set `APP_ENV=production` dan `APP_DEBUG=false` di `.env`

## 👥 User Default

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

### Admin/Pemilik Kost

```
Email: admin@kost.com
Password: password
```

**Akses**: Dashboard admin dengan fitur lengkap

### Penyewa/Tenant

```
Email: tenant@kost.com
Password: password
```

**Akses**: Dashboard tenant untuk melihat info kamar, pembayaran, dan keluhan

## 📁 Struktur Proyek

```
KosProject/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Controllers untuk admin
│   │   │   ├── Tenant/         # Controllers untuk tenant
│   │   │   └── Public/         # Controllers untuk halaman publik
│   │   └── Middleware/         # Custom middleware
│   ├── Models/                  # Eloquent models
│   ├── Observers/               # Model observers (cache invalidation)
│   └── Services/                # Business logic services
├── database/
│   ├── migrations/              # Database migrations
│   └── seeders/                 # Database seeders
├── resources/
│   └── views/
│       ├── admin/               # Views untuk admin
│       ├── tenant/              # Views untuk tenant
│       ├── public/              # Views untuk publik
│       └── layouts/             # Layout templates
├── routes/
│   └── web.php                  # Route definitions
├── public/
│   └── storage/                 # Symlink ke storage
└── storage/
    └── app/public/              # File uploads
```

## 📚 Dokumentasi Tambahan

- **[OPTIMIZATION.md](OPTIMIZATION.md)** - Panduan lengkap optimasi performa
- **Routes** - Lihat semua route dengan: `php artisan route:list`

## 🗃️ Database Schema

### Tabel Utama

- `users` - Data user (admin & tenant)
- `rooms` - Data kamar kost
- `facilities` - Fasilitas yang tersedia
- `room_facility` - Pivot table kamar-fasilitas
- `room_images` - Foto-foto kamar
- `tenants` - Data penghuni (kontrak)
- `payments` - Pembayaran penghuni
- `bookings` - Booking dari publik
- `complaints` - Keluhan dari penghuni
- `ratings` - Rating & review kamar

## 🔧 Troubleshooting

### Error: Storage link not found

```bash
php artisan storage:link
```

### Error: Permission denied

```bash
chmod -R 775 storage bootstrap/cache
```

### Error: Database connection refused

Pastikan MySQL berjalan dan kredensial di `.env` sudah benar.

### Cache tidak bekerja

Hapus cache dan restart:

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Slow queries

Enable slow query logging di `.env`:

```env
LOG_SLOW_QUERIES=true
SLOW_QUERY_THRESHOLD=1000
```

Lalu cek di `storage/logs/laravel.log`

## 🤝 Contributing

Kontribusi selalu diterima! Silakan buat pull request atau issue untuk:
- Bug reports
- Feature requests
- Documentation improvements

## 📝 License

Aplikasi ini adalah open-source software berlisensi [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Author

Dikembangkan dengan ❤️ menggunakan Laravel

## 📞 Support

Jika ada pertanyaan atau masalah, silakan buat issue di repository ini.
