<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CompanySetting;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CompanySetting::create([
            'company_name' => 'CV. Konveksi Seragam Sekolah',
            'company_address' => 'Jl. Contoh No. 123, Jakarta',
            'company_phone' => '021-12345678',
            'company_email' => 'info@konveksiseragam.com',
            'owner_name' => 'Nama Pemilik',
            'owner_position' => 'Owner/Pimpinan',
            'signature_path' => null,
            'stamp_path' => null,
            'logo_path' => null,
        ]);
    }
}
