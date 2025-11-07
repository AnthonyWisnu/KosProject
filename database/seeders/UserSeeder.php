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
        User::updateOrCreate(
            ['email' => 'admin@kost.com'],
            [
                'name' => 'Admin Kost',
                'password' => Hash::make('password'),
                'role' => 'pemilik',
                'phone' => '081234567890',
                'email_verified_at' => now(),
            ]
        );

        // Penyewa 1
        User::updateOrCreate(
            ['email' => 'budi@email.com'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'penyewa',
                'phone' => '081234567891',
                'email_verified_at' => now(),
            ]
        );

        // Penyewa 2
        User::updateOrCreate(
            ['email' => 'siti@email.com'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => Hash::make('password'),
                'role' => 'penyewa',
                'phone' => '081234567892',
                'email_verified_at' => now(),
            ]
        );

        // Penyewa 3
        User::updateOrCreate(
            ['email' => 'ahmad@email.com'],
            [
                'name' => 'Ahmad Wijaya',
                'password' => Hash::make('password'),
                'role' => 'penyewa',
                'phone' => '081234567893',
                'email_verified_at' => now(),
            ]
        );

        // Penyewa 4
        User::updateOrCreate(
            ['email' => 'rina@email.com'],
            [
                'name' => 'Rina Kusuma',
                'password' => Hash::make('password'),
                'role' => 'penyewa',
                'phone' => '081234567894',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Users seeded successfully!');
    }
}
