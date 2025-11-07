<?php

namespace Database\Seeders;

use App\Models\HouseRule;
use Illuminate\Database\Seeder;

class HouseRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rules = [
            [
                'title' => 'Jam Malam',
                'description' => 'Pintu gerbang ditutup pukul 23.00 WIB. Penghuni yang pulang lewat jam tersebut harus koordinasi dengan penjaga.',
                'order' => 1,
            ],
            [
                'title' => 'Tamu',
                'description' => 'Tamu diperbolehkan berkunjung dari pukul 08.00 - 21.00 WIB. Tamu wajib melapor ke penjaga dan meninggalkan identitas.',
                'order' => 2,
            ],
            [
                'title' => 'Kebersihan',
                'description' => 'Setiap penghuni wajib menjaga kebersihan kamar dan area bersama. Buang sampah pada tempatnya.',
                'order' => 3,
            ],
            [
                'title' => 'Kebisingan',
                'description' => 'Harap menjaga ketenangan terutama pada malam hari (setelah pukul 22.00 WIB). Tidak diperkenankan membuat keributan.',
                'order' => 4,
            ],
            [
                'title' => 'Dilarang Membawa Hewan Peliharaan',
                'description' => 'Untuk kenyamanan bersama, penghuni tidak diperbolehkan membawa hewan peliharaan ke dalam kost.',
                'order' => 5,
            ],
            [
                'title' => 'Pembayaran',
                'description' => 'Pembayaran sewa kamar dilakukan setiap tanggal 5 setiap bulannya. Keterlambatan pembayaran akan dikenakan denda.',
                'order' => 6,
            ],
            [
                'title' => 'Dilarang Merokok di Dalam Kamar',
                'description' => 'Merokok hanya diperbolehkan di area yang telah ditentukan. Dilarang keras merokok di dalam kamar.',
                'order' => 7,
            ],
            [
                'title' => 'Keamanan',
                'description' => 'Jaga barang berharga Anda. Pastikan pintu dan jendela terkunci saat meninggalkan kamar. Laporkan segera jika ada hal mencurigakan.',
                'order' => 8,
            ],
        ];

        foreach ($rules as $rule) {
            HouseRule::updateOrCreate(
                ['title' => $rule['title']],
                [
                    'description' => $rule['description'],
                    'order' => $rule['order'],
                ]
            );
        }

        $this->command->info('House Rules seeded successfully!');
    }
}
