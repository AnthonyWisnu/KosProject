<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Facility;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kamar Bulanan
        $room1 = Room::create([
            'room_number' => 'A01',
            'room_type' => 'bulanan',
            'capacity' => 1,
            'price' => 1500000,
            'description' => 'Kamar ukuran 3x4 meter dengan fasilitas lengkap. Cocok untuk mahasiswa atau pekerja.',
            'status' => 'terisi',
        ]);
        $room1->facilities()->attach([1, 2, 3, 4, 5, 6, 7, 8]);

        $room2 = Room::create([
            'room_number' => 'A02',
            'room_type' => 'bulanan',
            'capacity' => 1,
            'price' => 1500000,
            'description' => 'Kamar ukuran 3x4 meter dengan fasilitas lengkap.',
            'status' => 'terisi',
        ]);
        $room2->facilities()->attach([1, 2, 3, 4, 5, 6, 7, 8]);

        $room3 = Room::create([
            'room_number' => 'A03',
            'room_type' => 'bulanan',
            'capacity' => 1,
            'price' => 1200000,
            'description' => 'Kamar ukuran 3x3 meter. Hemat dan nyaman.',
            'status' => 'tersedia',
        ]);
        $room3->facilities()->attach([1, 3, 4, 5, 7, 8]);

        $room4 = Room::create([
            'room_number' => 'B01',
            'room_type' => 'bulanan',
            'capacity' => 2,
            'price' => 2000000,
            'description' => 'Kamar ukuran 4x5 meter. Cocok untuk 2 orang.',
            'status' => 'terisi',
        ]);
        $room4->facilities()->attach([1, 2, 3, 4, 5, 6, 7, 8]);

        $room5 = Room::create([
            'room_number' => 'B02',
            'room_type' => 'bulanan',
            'capacity' => 2,
            'price' => 2000000,
            'description' => 'Kamar ukuran 4x5 meter. Cocok untuk 2 orang.',
            'status' => 'tersedia',
        ]);
        $room5->facilities()->attach([1, 2, 3, 4, 5, 6, 7, 8]);

        // Kamar Harian
        $room6 = Room::create([
            'room_number' => 'C01',
            'room_type' => 'harian',
            'capacity' => 1,
            'price' => 100000,
            'description' => 'Kamar harian dengan fasilitas standard.',
            'status' => 'tersedia',
        ]);
        $room6->facilities()->attach([1, 2, 3, 6, 7]);

        $room7 = Room::create([
            'room_number' => 'C02',
            'room_type' => 'harian',
            'capacity' => 2,
            'price' => 150000,
            'description' => 'Kamar harian untuk 2 orang.',
            'status' => 'tersedia',
        ]);
        $room7->facilities()->attach([1, 2, 3, 6, 7]);

        $room8 = Room::create([
            'room_number' => 'D01',
            'room_type' => 'bulanan',
            'capacity' => 1,
            'price' => 1300000,
            'description' => 'Kamar dengan view bagus.',
            'status' => 'maintenance',
        ]);
        $room8->facilities()->attach([1, 2, 3, 4, 5, 7]);

        $this->command->info('Rooms seeded successfully!');
    }
}
