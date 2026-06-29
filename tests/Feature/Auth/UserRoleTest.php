<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_role_helpers_return_expected_values(): void
    {
        $warga = User::factory()->create(['role' => 'warga']);
        $petugas = User::factory()->create(['role' => 'petugas']);
        $admin = User::factory()->create(['role' => 'admin']);

        $this->assertTrue($warga->isWarga());
        $this->assertFalse($warga->isPetugas());
        $this->assertFalse($warga->isAdmin());

        $this->assertTrue($petugas->isPetugas());
        $this->assertFalse($petugas->isWarga());
        $this->assertFalse($petugas->isAdmin());

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($admin->isWarga());
        $this->assertFalse($admin->isPetugas());
    }
}
