<?php

namespace Database\Seeders;

use App\Models\Complaint;
use Illuminate\Database\Seeder;

class ComplaintSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Complaint 1 - Resolved
        Complaint::create([
            'user_id' => 2, // Budi Santoso
            'room_id' => 1, // A01
            'title' => 'AC Tidak Dingin',
            'description' => 'AC di kamar saya tidak dingin sejak 2 hari yang lalu. Mohon untuk diperbaiki.',
            'status' => 'resolved',
            'response' => 'Terima kasih atas laporannya. AC sudah kami perbaiki dan sudah normal kembali.',
            'created_at' => now()->subDays(5),
            'updated_at' => now()->subDays(3),
        ]);

        // Complaint 2 - In Progress
        Complaint::create([
            'user_id' => 3, // Siti Nurhaliza
            'room_id' => 2, // A02
            'title' => 'Wastafel Mampet',
            'description' => 'Wastafel di kamar mandi mampet, air tidak bisa turun.',
            'status' => 'in_progress',
            'response' => 'Sedang kami proses. Tukang ledeng akan datang besok pagi.',
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDay(),
        ]);

        // Complaint 3 - Pending
        Complaint::create([
            'user_id' => 4, // Ahmad Wijaya
            'room_id' => 4, // B01
            'title' => 'WiFi Lambat',
            'description' => 'Koneksi WiFi di kamar sangat lambat, terutama malam hari.',
            'status' => 'pending',
            'created_at' => now()->subDay(),
        ]);

        // Complaint 4 - Pending
        Complaint::create([
            'user_id' => 2, // Budi Santoso
            'room_id' => 1, // A01
            'title' => 'Lampu Kamar Mandi Mati',
            'description' => 'Lampu kamar mandi mati total, mohon segera diperbaiki.',
            'status' => 'pending',
            'created_at' => now(),
        ]);

        $this->command->info('Complaints seeded successfully!');
    }
}
