<?php

namespace Tests\Feature;

use App\Models\Kategori;
use App\Models\Pengaduan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PengaduanAssignmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_assign_pengaduan_to_petugas_and_update_status(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $petugas = User::factory()->create(['role' => 'petugas']);
        $kategori = Kategori::factory()->create();
        $pengaduan = Pengaduan::factory()->create([
            'kategori_id' => $kategori->id,
            'status' => 'menunggu',
            'petugas_id' => null,
        ]);

        $response = $this->actingAs($admin)->patch(route('pengaduan.updateStatus', $pengaduan), [
            'status' => 'diproses',
            'petugas_id' => $petugas->id,
            'catatan_petugas' => 'Segera ditangani',
        ]);

        $response->assertRedirect(route('pengaduan.show', $pengaduan));
        $this->assertDatabaseHas('pengaduans', [
            'id' => $pengaduan->id,
            'status' => 'diproses',
            'petugas_id' => $petugas->id,
            'catatan_petugas' => 'Segera ditangani',
        ]);
    }

    public function test_petugas_only_sees_assigned_pengaduan_in_masuk(): void
    {
        $petugas = User::factory()->create(['role' => 'petugas']);
        $kategori = Kategori::factory()->create();
        $assigned = Pengaduan::factory()->create([
            'kategori_id' => $kategori->id,
            'petugas_id' => $petugas->id,
            'status' => 'diproses',
        ]);
        Pengaduan::factory()->create([
            'kategori_id' => $kategori->id,
            'petugas_id' => null,
            'status' => 'menunggu',
        ]);

        $response = $this->actingAs($petugas)->get(route('pengaduan.masuk'));

        $response->assertOk();
        $response->assertViewHas('pengaduans', function ($pengaduans) use ($assigned) {
            return $pengaduans->contains('id', $assigned->id) && $pengaduans->doesntContain('id', null);
        });
    }
}
