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
                'nama_kategori' => 'Jalan & Infrastruktur',
                'deskripsi'    => 'Kerusakan jalan, trotoar, drainase',
                'icon'         => 'road',
                'is_active'    => true,
            ],
            [
                'nama_kategori' => 'Kebersihan & Sampah',
                'deskripsi'    => 'Pengelolaan sampah dan sampah liar',
                'icon'         => 'trash',
                'is_active'    => true,
            ],
            [
                'nama_kategori' => 'Penerangan Jalan',
                'deskripsi'    => 'Lampu jalan mati atau rusak',
                'icon'         => 'light-bulb',
                'is_active'    => true,
            ],
            [
                'nama_kategori' => 'Keamanan & Ketertiban',
                'deskripsi'    => 'Permasalahan kriminal dan ketertiban umum',
                'icon'         => 'shield-check',
                'is_active'    => true,
            ],
            [
                'nama_kategori' => 'Administrasi Kelurahan',
                'deskripsi'    => 'Pelayanan surat menyurat dan administrasi',
                'icon'         => 'document-text',
                'is_active'    => true,
            ],
            [
                'nama_kategori' => 'Kesehatan Lingkungan',
                'deskripsi'    => 'Sanitasi, air bersih, dan penyakit lingkungan',
                'icon'         => 'heart-pulse',
                'is_active'    => true,
            ],
            [
                'nama_kategori' => 'Fasilitas Umum',
                'deskripsi'    => 'Taman, lapangan, pos kamling, dan fasilitas publik',
                'icon'         => 'building-library',
                'is_active'    => true,
            ],
            [
                'nama_kategori' => 'Lainnya',
                'deskripsi'    => 'Pengaduan di luar kategori yang tersedia',
                'icon'         => 'ellipsis-horizontal',
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
