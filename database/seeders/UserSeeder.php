<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin/Pemilik Kost
        User::create([
            'name' => 'Admin Kost',
            'email' => 'admin@kost.com',
            'password' => Hash::make('password'),
            'role' => 'pemilik',
            'phone' => '081234567890',
            'email_verified_at' => now(),
        ]);

        // Penyewa 1
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@email.com',
            'password' => Hash::make('password'),
            'role' => 'penyewa',
            'phone' => '081234567891',
            'email_verified_at' => now(),
        ]);

        // Penyewa 2
        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@email.com',
            'password' => Hash::make('password'),
            'role' => 'penyewa',
            'phone' => '081234567892',
            'email_verified_at' => now(),
        ]);

        // Penyewa 3
        User::create([
            'name' => 'Ahmad Wijaya',
            'email' => 'ahmad@email.com',
            'password' => Hash::make('password'),
            'role' => 'penyewa',
            'phone' => '081234567893',
            'email_verified_at' => now(),
        ]);

        // Penyewa 4
        User::create([
            'name' => 'Rina Kusuma',
            'email' => 'rina@email.com',
            'password' => Hash::make('password'),
            'role' => 'penyewa',
            'phone' => '081234567894',
            'email_verified_at' => now(),
        ]);

        $this->command->info('Users seeded successfully!');
    }
}
