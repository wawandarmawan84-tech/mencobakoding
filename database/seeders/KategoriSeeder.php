<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Pengaduan',
                'deskripsi'    => 'Kategori untuk pengaduan masyarakat',
                'icon'         => 'exclamation-circle',
                'is_active'    => true,
            ],
            [
                'nama_kategori' => 'Aspirasi',
                'deskripsi'    => 'Kategori untuk aspirasi masyarakat',
                'icon'         => 'chat-alt',
                'is_active'    => true,
            ],
            [
                'nama_kategori' => 'Permintaan Informasi',
                'deskripsi'    => 'Kategori untuk permintaan informasi',
                'icon'         => 'information-circle',
                'is_active'    => true,
            ],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::updateOrCreate([
                'nama_kategori' => $kategori['nama_kategori'],
            ], $kategori);
        }
    }
}
