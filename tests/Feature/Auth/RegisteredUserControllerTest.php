<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisteredUserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_requires_complete_and_valid_data(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Budi Warga',
            'email' => 'budi@example.com',
            'nik' => '3201010101010001',
            'no_hp' => '081234567890',
            'alamat' => 'Kelurahan Konoha',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', ['email' => 'budi@example.com']);
    }

    public function test_registration_rejects_duplicate_email_and_nik_and_mismatched_password(): void
    {
        User::factory()->create([
            'email' => 'existing@example.com',
            'nik' => '3201010101010002',
        ]);

        $response = $this->from('/register')->post('/register', [
            'name' => 'Test User',
            'email' => 'existing@example.com',
            'nik' => '3201010101010002',
            'no_hp' => '081234567891',
            'alamat' => 'Kelurahan Konoha',
            'password' => 'password123',
            'password_confirmation' => 'different',
        ]);

        $response->assertSessionHasErrors(['email', 'nik', 'password']);
    }
}
