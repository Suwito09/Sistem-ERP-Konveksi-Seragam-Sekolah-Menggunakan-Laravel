# Sistem ERP Konveksi Seragam Sekolah

Sistem Enterprise Resource Planning (ERP) untuk manajemen bisnis konveksi seragam sekolah yang dirancang untuk mengoptimalkan operasional bisnis dari A sampai Z.

## 📋 Daftar Isi

- [Fitur Utama](#fitur-utama)
- [Tech Stack](#tech-stack)
- [Requirement](#requirement)
- [Instalasi](#instalasi)
- [Struktur Project](#struktur-project)
- [Konfigurasi Database](#konfigurasi-database)
- [Dokumentasi Features](#dokumentasi-features)
- [Lisensi](#lisensi)

## ✨ Fitur Utama

### 1. **Manajemen Pelamar & Rekrutmen**
- Form aplikasi pelamar online
- Data pelamar terorganisir dengan baik
- Tracking status pelamar (diproses, diterima, ditolak)
- Export data pelamar ke Excel
- Dashboard statistik pelamar

### 2. **Manajemen Pegawai**
- Input data pegawai (biodata, kontak, detail pekerjaan)
- Tracking kehadiran dan cuti
- Management riwayat kegiatan pegawai
- Export data pegawai ke Excel
- Pencarian dan filter pegawai

### 3. **Sistem Gaji & Payroll**
- Perhitungan gaji otomatis
- Manajemen potongan dan tunjangan
- Pengajuan penarikan gaji dari pegawai
- Slip gaji digital (PDF format 80mm)
- Export gaji semua pegawai ke Excel
- Auto-delete order yang belum dibayar
- Payment deadline configuration

### 4. **Manajemen Pesanan & Invoice**
- Create, Read, Update, Delete pesanan
- Invoice generation otomatis
- Status pesanan tracking (pending, progress, selesai)
- Filter pesanan berdasarkan status pembayaran (belum lunas, lunas)
- Print invoice dengan format profesional
- Email invoice ke pelanggan
- Penghapusan otomatis pesanan belum bayar

### 5. **Manajemen Artikel & Blog**
- Create dan publish artikel
- Upload gambar artikel
- Edit dan delete artikel
- Tampilan artikel di landing page
- SEO-friendly URLs

### 6. **Pengaturan Perusahaan**
- Konfigurasi informasi perusahaan (nama, alamat, telepon, email)
- Informasi pimpinan/owner
- Upload logo perusahaan
- Upload tanda tangan digital
- Upload stempel perusahaan
- Preview otomatis di slip gaji

### 7. **Dashboard & Analytics**
- Dashboard overview dengan statistik real-time
- Grafik performa (Chart.js, ApexCharts)
- Laporan bulanan dan tahunan
- Data visualization yang interaktif

### 8. **User Management & Permissions**
- Role-based access control (Admin, Manager, Pegawai, Pelanggan)
- Permission management menggunakan Spatie Laravel Permission
- Audit trail untuk tracking perubahan data
- User activity logging

### 9. **Integrasi Google Calendar**
- Sinkronisasi event dengan Google Calendar
- Manajemen jadwal kegiatan team
- Reminder otomatis untuk event penting

### 10. **Export & Reporting**
- Export data ke Excel (.xlsx)
- Export laporan gaji
- Export data pelamar
- Export data pesanan
- PDF generation untuk slip gaji dan invoice

## 🛠 Tech Stack

### Backend
- **Framework**: Laravel 10.x
- **PHP**: 8.1+
- **Database**: MySQL
- **Authentication**: Laravel Jetstream + Fortify

### Frontend
- **CSS Framework**: Tailwind CSS 3.x
- **Templating**: Blade (Laravel)
- **Build Tool**: Vite
- **UI Components**: Jetstream, Livewire 2.x

### Additional Libraries
- **Charts**: Chart.js, ApexCharts, Larapex Charts
- **Excel**: Maatwebsite Excel 3.x
- **PDF**: DOMPDF 2.x
- **Permission**: Spatie Laravel Permission 5.x
- **Google Calendar**: Spatie Google Calendar 3.x
- **Column Sorting**: Kyslik Column Sortable 6.x
- **Localization**: Laraindo 1.x
- **HTTP Client**: Guzzle HTTP 7.x

## 📦 Requirement

### Minimum Requirements
- PHP 8.1 atau lebih tinggi
- Composer (dependency manager PHP)
- MySQL 5.7 atau MariaDB 10.2+
- Node.js 14.x atau lebih tinggi
- npm atau yarn

### Optional
- XAMPP / WAMP / LAMP (untuk development)
- Git

## 🚀 Instalasi

### Step 1: Clone Repository
```bash
git clone https://github.com/Suwito09/Sistem-ERP-Konveksi-Seragam-Sekolah-Menggunakan-Laravel.git
cd Sistem-ERP-Konveksi-Seragam-Sekolah-Menggunakan-Laravel
```

### Step 2: Install Dependencies PHP
```bash
composer install
```

### Step 3: Setup Environment File
```bash
# Copy .env.example ke .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 4: Konfigurasi Database
Edit file `.env` dan sesuaikan dengan database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=
```

### Step 5: Install Dependencies JavaScript
```bash
npm install
npm run build
```

### Step 6: Migrasi & Seeding Database
```bash
# Jalankan migrasi dan seeding
php artisan migrate:fresh --seed

# Atau hanya migrasi tanpa seeding
php artisan migrate
```

### Step 7: Link Storage
```bash
php artisan storage:link
```

### Step 8: Jalankan Server Development
```bash
php artisan serve
```

Akses aplikasi di: `http://localhost:8000`

## 🔐 Default Credentials

Setelah running `migrate:fresh --seed`, Anda dapat login dengan:

**Admin Account:**
- Email: lihat di `database/seeders/UserSeeder.php`
- Password: password

**Note:** Silahkan cek file `database/seeders/UserSeeder.php` untuk melihat detail kredensial default.

## 📁 Struktur Project

```
├── app/
│   ├── Actions/              # Fortify & Jetstream Actions
│   ├── Charts/               # Chart classes (Gaji, Pelamar, Pesanan, dll)
│   ├── Console/              # Console commands (DeleteExpiredUnpaidOrders)
│   ├── Exports/              # Excel export classes
│   ├── Http/
│   │   ├── Controllers/      # Application controllers
│   │   ├── Middleware/       # Middleware
│   │   └── Requests/         # Form requests
│   ├── Models/               # Eloquent models
│   ├── Policies/             # Authorization policies
│   ├── Providers/            # Service providers
│   ├── Services/             # Business logic services
│   ├── View/                 # View models/composers
│   └── helper/               # Helper functions (Helpers.php, PdfHelper.php)
├── bootstrap/                # Bootstrap application
├── config/                   # Configuration files
├── database/
│   ├── factories/            # Model factories
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── public/                   # Public assets (css, js, images)
├── resources/
│   ├── css/                  # Tailwind CSS
│   ├── js/                   # JavaScript files (Alpine.js)
│   ├── markdown/             # Markdown files
│   └── views/                # Blade templates
├── routes/                   # Route definitions
├── storage/                  # Storage (logs, uploads, cache)
├── tests/                    # PHPUnit tests
├── vendor/                   # Composer dependencies
├── .env.example              # Environment template
├── composer.json             # PHP dependencies
├── package.json              # Node.js dependencies
├── tailwind.config.js        # Tailwind configuration
├── vite.config.js            # Vite configuration
├── phpunit.xml               # PHPUnit configuration
└── artisan                   # Laravel CLI

```

## 🗄 Konfigurasi Database

### Main Tables

1. **users** - Manajemen user aplikasi
2. **company_settings** - Pengaturan perusahaan
3. **pegawai** - Data pegawai
4. **pelamar** - Data pelamar
5. **kehadiran** - Tracking kehadiran
6. **gaji** - Data gaji
7. **pesanan** - Data pesanan
8. **invoice** - Data invoice
9. **artikel** - Data artikel blog
10. **riwayat_kegiatan** - Riwayat aktivitas
11. **kriteria_pelamar** - Kriteria penerimaan pelamar

Untuk detail migration, lihat folder `database/migrations/`

## 📚 Dokumentasi Features

### 1. Fitur Pengaturan Perusahaan
Lihat file [FITUR_PENGATURAN_PERUSAHAAN.md](FITUR_PENGATURAN_PERUSAHAAN.md)

Fitur ini memungkinkan admin untuk:
- Mengatur informasi perusahaan
- Upload logo, tanda tangan digital, dan stempel
- Integrasi otomatis dengan slip gaji

### 2. Auto Delete Unpaid Orders
Sistem otomatis menghapus pesanan yang belum dibayar sesuai setting:
- Dapat dikonfigurasi jumlah hari
- Berjalan setiap hari via scheduler
- Command: `php artisan orders:delete-expired`

### 3. Payment Deadline untuk Invoice
- Invoice dapat dikonfigurasi dengan payment deadline
- Reminder otomatis untuk invoice yang mendekati deadline
- Status tracking untuk invoice (belum lunas/lunas)

## 🔧 Commands Tersedia

```bash
# Migrasi database
php artisan migrate
php artisan migrate:fresh --seed

# Menjalankan scheduler (untuk production)
php artisan schedule:work

# Delete expired unpaid orders
php artisan orders:delete-expired

# Generate sitemap (jika ada)
php artisan sitemap:generate

# Clear cache
php artisan cache:clear
php artisan config:cache
```

## 📝 Environment Variables

Penting environment variables di `.env`:

```env
APP_NAME=Sistem ERP Konveksi
APP_ENV=production
APP_DEBUG=false
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=erp_konveksi
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=your-email@gmail.com

GOOGLE_CALENDAR_ID=your-calendar-id
GOOGLE_CALENDAR_AUTH_JSON=path/to/auth.json
```

## 🚀 Deployment

### Untuk Production:

1. Setup server (Ubuntu/CentOS dengan PHP 8.1+, MySQL)
2. Install dependencies: `composer install --no-dev`
3. Setup `.env` untuk production
4. Generate key: `php artisan key:generate`
5. Run migrations: `php artisan migrate --force`
6. Setup web server (Apache/Nginx)
7. Setup SSL certificate
8. Configure storage symlink
9. Setup queue worker dan scheduler

## 🐛 Troubleshooting

### Permission Denied pada Storage
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

### CRSF Token Mismatch
Clear cache dan session:
```bash
php artisan cache:clear
php artisan session:flush
```

### Database Connection Error
Pastikan:
- MySQL service running
- Database name, username, password benar
- Host configuration sudah benar

### Composer Update Issues
```bash
composer install --no-interaction --no-progress
```

## 📄 Lisensi

MIT License - Lihat file [LICENSE](LICENSE) untuk detail

## 👥 Author

**Suwito**
- GitHub: [@Suwito09](https://github.com/Suwito09)

## 🤝 Contributing

Contributions are welcome! Silahkan:
1. Fork project ini
2. Buat feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📞 Support

Jika ada pertanyaan atau issue, silahkan buat issue di GitHub repository ini.

---

**Last Updated**: May 2026

**Versi**: 1.0.0
