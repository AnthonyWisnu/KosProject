<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KostProfileSeeder::class,
            UserSeeder::class,
            FacilitySeeder::class,
            HouseRuleSeeder::class,
            RoomSeeder::class,
            TenantSeeder::class,
            PaymentSeeder::class,
            ComplaintSeeder::class,
        ]);

        $this->command->info('Database seeding completed successfully!');
    }
}
