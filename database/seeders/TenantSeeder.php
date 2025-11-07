<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tenant 1 - Budi Santoso di kamar A01
        Tenant::create([
            'user_id' => 2, // Budi Santoso
            'room_id' => 1, // A01
            'start_date' => now()->subMonths(3),
            'end_date' => null,
            'status' => 'active',
            'biodata' => [
                'ktp' => '3174011234567890',
                'pekerjaan' => 'Software Engineer',
                'alamat_asal' => 'Bandung, Jawa Barat',
                'kontak_darurat_nama' => 'Ibu Santoso',
                'kontak_darurat_telp' => '081234567800',
                'kontak_darurat_hubungan' => 'Ibu Kandung',
            ],
        ]);

        // Tenant 2 - Siti Nurhaliza di kamar A02
        Tenant::create([
            'user_id' => 3, // Siti Nurhaliza
            'room_id' => 2, // A02
            'start_date' => now()->subMonths(2),
            'end_date' => null,
            'status' => 'active',
            'biodata' => [
                'ktp' => '3174011234567891',
                'pekerjaan' => 'Marketing Executive',
                'alamat_asal' => 'Surabaya, Jawa Timur',
                'kontak_darurat_nama' => 'Bapak Nurdin',
                'kontak_darurat_telp' => '081234567801',
                'kontak_darurat_hubungan' => 'Ayah Kandung',
            ],
        ]);

        // Tenant 3 - Ahmad Wijaya di kamar B01
        Tenant::create([
            'user_id' => 4, // Ahmad Wijaya
            'room_id' => 4, // B01
            'start_date' => now()->subMonth(),
            'end_date' => null,
            'status' => 'active',
            'biodata' => [
                'ktp' => '3174011234567892',
                'pekerjaan' => 'Mahasiswa',
                'alamat_asal' => 'Jakarta, DKI Jakarta',
                'kontak_darurat_nama' => 'Ibu Wijaya',
                'kontak_darurat_telp' => '081234567802',
                'kontak_darurat_hubungan' => 'Ibu Kandung',
            ],
        ]);

        $this->command->info('Tenants seeded successfully!');
    }
}
