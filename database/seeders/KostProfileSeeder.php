<?php

namespace Database\Seeders;

use App\Models\KostProfile;
use Illuminate\Database\Seeder;

class KostProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        KostProfile::create([
            'name' => 'Kost Sejahtera',
            'address' => 'Jl. Sudirman No. 123, Jakarta Selatan, DKI Jakarta 12190',
            'phone' => '021-1234567',
            'whatsapp' => '081234567890',
            'email' => 'info@kostsejahtera.com',
            'description' => 'Kost Sejahtera adalah rumah kost yang nyaman, aman, dan strategis. Berlokasi di pusat kota dengan akses mudah ke berbagai fasilitas umum. Kami menyediakan kamar dengan berbagai tipe sesuai kebutuhan Anda.',
        ]);

        $this->command->info('Kost Profile seeded successfully!');
    }
}
