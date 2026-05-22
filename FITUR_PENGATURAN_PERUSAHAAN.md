# Fitur Pengaturan Perusahaan

## Deskripsi
Fitur ini memungkinkan admin untuk mengatur informasi perusahaan yang akan ditampilkan pada slip gaji, termasuk:
- Nama perusahaan
- Alamat, telepon, dan email perusahaan
- Nama dan jabatan pimpinan/owner
- Upload tanda tangan digital
- Upload stempel perusahaan
- Upload logo perusahaan

## Cara Menggunakan

### 1. Akses Menu Pengaturan Perusahaan
- Login sebagai admin
- Dari menu utama, klik icon **"Pengaturan"** (icon gedung) di bagian **USERS**
- Atau akses langsung via URL: `/company-settings`

### 2. Mengisi Informasi Perusahaan
- **Nama Perusahaan**: Nama lengkap perusahaan
- **Alamat**: Alamat lengkap perusahaan
- **Nomor Telepon**: Nomor telepon yang dapat dihubungi
- **Email**: Email perusahaan

### 3. Mengisi Informasi Pimpinan
- **Nama Pimpinan/Owner**: Nama lengkap pimpinan
- **Jabatan**: Jabatan pimpinan (contoh: Owner/Pimpinan, Direktur, CEO)

### 4. Upload File
**Format yang didukung**: PNG, JPG, JPEG (maksimal 2MB)

- **Logo Perusahaan**: 
  - Akan ditampilkan di header slip gaji
  - Ukuran rekomendasi: 200x200 px
  
- **Tanda Tangan Digital**: 
  - Akan ditampilkan di bagian tanda tangan slip gaji
  - Background transparan direkomendasikan
  - Ukuran rekomendasi: 300x150 px

- **Stempel Perusahaan**: 
  - Akan ditampilkan di bagian tanda tangan slip gaji
  - Background transparan direkomendasikan
  - Ukuran rekomendasi: 200x200 px

### 5. Preview
- Setelah upload, akan muncul preview bagian tanda tangan dan stempel
- Preview menunjukkan bagaimana tampilan di slip gaji

### 6. Menghapus File
- Klik tombol "Hapus" pada file yang ingin dihapus
- Konfirmasi penghapusan

## Integrasi dengan Slip Gaji

Pengaturan ini akan otomatis diterapkan pada:
1. **Download Slip Gaji** (PDF 80mm) - dari menu "Gaji Semua Pegawai"
2. **Export Slip Gaji** (PDF 80mm) - dari menu "Pengajuan Penarikan Gaji"
3. **Print Slip Gaji** (Preview Print) - dari menu "Pengajuan Penarikan Gaji"

## Struktur Database

### Tabel: `company_settings`
```sql
- id (primary key)
- company_name (varchar)
- company_address (text)
- company_phone (varchar)
- company_email (varchar)
- owner_name (varchar)
- owner_position (varchar)
- signature_path (varchar, nullable)
- stamp_path (varchar, nullable)
- logo_path (varchar, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

**Note**: Hanya ada 1 record di tabel ini (Singleton Pattern)

## File Storage

File disimpan di: `storage/app/public/company/`
- `company/signatures/` - Tanda tangan
- `company/stamps/` - Stempel
- `company/logos/` - Logo

Akses public melalui: `public/storage/company/`

## Permissions
Fitur ini menggunakan permission yang sama dengan menu Admin:
- **View**: `list admin`
- **Edit**: `update admin`

Jika ingin permission khusus, dapat ditambahkan permission baru:
```php
'manage company settings'
```

## Tips & Best Practices

1. **Tanda Tangan**:
   - Gunakan file PNG dengan background transparan
   - Scan tanda tangan asli dengan resolusi tinggi
   - Crop image agar hanya menampilkan tanda tangan

2. **Stempel**:
   - Scan stempel asli dengan resolusi tinggi
   - Gunakan background transparan
   - Pastikan stempel terlihat jelas

3. **Logo**:
   - Gunakan logo dengan resolusi tinggi
   - Format square (persegi) lebih baik
   - Pastikan logo terlihat jelas di ukuran kecil

4. **Update Data**:
   - Data dapat diupdate kapan saja
   - Perubahan akan langsung terlihat di slip gaji berikutnya
   - Slip gaji yang sudah di-download tetap menggunakan data lama

## Troubleshooting

### File tidak muncul di slip gaji
- Pastikan file sudah ter-upload (cek di form pengaturan)
- Pastikan file ada di storage (check `storage/app/public/company/`)
- Pastikan symbolic link sudah dibuat: `php artisan storage:link`

### Error saat upload file
- Pastikan ukuran file < 2MB
- Pastikan format file: PNG, JPG, atau JPEG
- Pastikan folder `storage/app/public/company` writable

### Preview tidak muncul
- Clear cache browser
- Pastikan file path benar di database
- Check permission folder storage

## Kode yang Terlibat

### Model
- `app/Models/CompanySetting.php`

### Controller
- `app/Http/Controllers/CompanySettingController.php`
- `app/Http/Controllers/GajiSemuaPegawaiController.php` (updated)
- `app/Http/Controllers/PengajuanPenarikanGajiController.php` (updated)

### Views
- `resources/views/settings/company/index.blade.php`
- `resources/views/PDF/slip_gaji.blade.php` (updated)
- `resources/views/print/slip_gaji.blade.php` (updated)

### Routes
- `GET /company-settings` - Form pengaturan
- `POST /company-settings` - Update pengaturan
- `DELETE /company-settings/signature` - Hapus tanda tangan
- `DELETE /company-settings/stamp` - Hapus stempel
- `DELETE /company-settings/logo` - Hapus logo

### Migration
- `database/migrations/2025_12_24_201735_create_company_settings_table.php`

### Seeder
- `database/seeders/CompanySettingSeeder.php`
