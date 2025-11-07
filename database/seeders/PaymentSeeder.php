<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Payment untuk Budi Santoso (tenant_id: 1)
        // Bulan 1 - Verified
        Payment::create([
            'tenant_id' => 1,
            'amount' => 1500000,
            'payment_date' => now()->subMonths(3)->startOfMonth()->addDays(4),
            'status' => 'verified',
            'verified_by' => 1,
            'verified_at' => now()->subMonths(3)->startOfMonth()->addDays(5),
            'notes' => 'Pembayaran bulan pertama',
        ]);

        // Bulan 2 - Verified
        Payment::create([
            'tenant_id' => 1,
            'amount' => 1500000,
            'payment_date' => now()->subMonths(2)->startOfMonth()->addDays(4),
            'status' => 'verified',
            'verified_by' => 1,
            'verified_at' => now()->subMonths(2)->startOfMonth()->addDays(5),
        ]);

        // Bulan 3 - Verified
        Payment::create([
            'tenant_id' => 1,
            'amount' => 1500000,
            'payment_date' => now()->subMonth()->startOfMonth()->addDays(4),
            'status' => 'verified',
            'verified_by' => 1,
            'verified_at' => now()->subMonth()->startOfMonth()->addDays(5),
        ]);

        // Payment untuk Siti Nurhaliza (tenant_id: 2)
        // Bulan 1 - Verified
        Payment::create([
            'tenant_id' => 2,
            'amount' => 1500000,
            'payment_date' => now()->subMonths(2)->startOfMonth()->addDays(3),
            'status' => 'verified',
            'verified_by' => 1,
            'verified_at' => now()->subMonths(2)->startOfMonth()->addDays(4),
        ]);

        // Bulan 2 - Verified
        Payment::create([
            'tenant_id' => 2,
            'amount' => 1500000,
            'payment_date' => now()->subMonth()->startOfMonth()->addDays(3),
            'status' => 'verified',
            'verified_by' => 1,
            'verified_at' => now()->subMonth()->startOfMonth()->addDays(4),
        ]);

        // Payment untuk Ahmad Wijaya (tenant_id: 3)
        // Bulan 1 - Verified
        Payment::create([
            'tenant_id' => 3,
            'amount' => 2000000,
            'payment_date' => now()->subMonth()->startOfMonth()->addDays(5),
            'status' => 'verified',
            'verified_by' => 1,
            'verified_at' => now()->subMonth()->startOfMonth()->addDays(6),
        ]);

        // Payment Pending - Budi
        Payment::create([
            'tenant_id' => 1,
            'amount' => 1500000,
            'payment_date' => now()->startOfMonth()->addDays(4),
            'status' => 'pending',
            'notes' => 'Menunggu verifikasi',
        ]);

        // Payment Pending - Siti
        Payment::create([
            'tenant_id' => 2,
            'amount' => 1500000,
            'payment_date' => now()->startOfMonth()->addDays(3),
            'status' => 'pending',
        ]);

        $this->command->info('Payments seeded successfully!');
    }
}
