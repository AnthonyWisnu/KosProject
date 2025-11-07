<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            ['name' => 'WiFi', 'icon' => 'wifi'],
            ['name' => 'AC', 'icon' => 'snowflake'],
            ['name' => 'Kasur', 'icon' => 'bed'],
            ['name' => 'Lemari', 'icon' => 'cabinet-filing'],
            ['name' => 'Meja Belajar', 'icon' => 'desk'],
            ['name' => 'Kamar Mandi Dalam', 'icon' => 'bath'],
            ['name' => 'Jendela', 'icon' => 'window'],
            ['name' => 'Parkir Motor', 'icon' => 'motorcycle'],
            ['name' => 'Dapur Bersama', 'icon' => 'utensils'],
            ['name' => 'Laundry', 'icon' => 'washer'],
            ['name' => 'CCTV', 'icon' => 'camera'],
            ['name' => 'Keamanan 24 Jam', 'icon' => 'shield-check'],
        ];

        foreach ($facilities as $facility) {
            Facility::updateOrCreate(
                ['name' => $facility['name']],
                ['icon' => $facility['icon']]
            );
        }

        $this->command->info('Facilities seeded successfully!');
    }
}
