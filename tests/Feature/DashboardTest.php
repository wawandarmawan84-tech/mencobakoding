<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_uses_real_pengaduan_data(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'user@example.com',
            'password' => 'password123',
            'role' => 'warga',
        ]);

        $kategori = Kategori::create([
            'nama_kategori' => 'Kebersihan',
            'deskripsi' => 'Layanan kebersihan',
            'icon' => 'sparkles',
            'is_active' => true,
        ]);

        Pengaduan::create([
            'nomor_aduan' => 'ADU-2025-001',
            'user_id' => $user->id,
            'kategori_id' => $kategori->id,
            'judul' => 'Sampah menumpuk',
            'isi_pengaduan' => 'Sampah menumpuk di depan rumah.',
            'status' => 'menunggu',
        ]);

        Pengaduan::create([
            'nomor_aduan' => 'ADU-2025-002',
            'user_id' => $user->id,
            'kategori_id' => $kategori->id,
            'judul' => 'Lampu jalan mati',
            'isi_pengaduan' => 'Lampu jalan mati di dekat pos ronda.',
            'status' => 'diproses',
        ]);

        Pengaduan::create([
            'nomor_aduan' => 'ADU-2025-003',
            'user_id' => $user->id,
            'kategori_id' => $kategori->id,
            'judul' => 'Jalan berlubang',
            'isi_pengaduan' => 'Jalan berlubang di dekat sekolah.',
            'status' => 'selesai',
        ]);

        $response = $this->get('/dashboard');

        $response->assertOk();
        $response->assertViewHas('totalPengaduan', 3);
        $response->assertViewHas('menunggu', 1);
        $response->assertViewHas('diproses', 1);
        $response->assertViewHas('selesai', 1);

        $latestPengaduan = $response->viewData('latestPengaduan');
        $this->assertCount(3, $latestPengaduan);
        $this->assertSame('ADU-2025-003', $latestPengaduan[0]['nomor']);
    }
}
