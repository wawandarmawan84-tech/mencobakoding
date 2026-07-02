<?php

namespace Database\Factories;

use App\Models\Kategori;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pengaduan>
 */
class PengaduanFactory extends Factory
{
    protected $model = Pengaduan::class;

    public function definition(): array
    {
        return [
            'nomor_aduan' => Pengaduan::generateNomor(),
            'user_id' => User::factory(),
            'kategori_id' => Kategori::factory(),
            'judul' => fake()->sentence(4),
            'isi_pengaduan' => fake()->paragraph(),
            'lokasi' => fake()->address(),
            'status' => 'menunggu',
            'prioritas' => 'normal',
            'petugas_id' => null,
            'tanggal_selesai' => null,
            'catatan_petugas' => null,
        ];
    }
}
