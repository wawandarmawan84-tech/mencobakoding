<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_with_valid_nik_and_phone_number(): void
    {
        $response = $this->post('/register', [
            'name' => 'Budi Warga',
            'email' => 'budi@example.com',
            'nik' => '3201010101010001',
            'no_hp' => '081234567890',
            'alamat' => 'Kelurahan Konoha',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertDatabaseHas('users', [
            'email' => 'budi@example.com',
            'nik' => '3201010101010001',
            'no_hp' => '081234567890',
            'role' => 'warga',
        ]);
    }

    public function test_registration_rejects_invalid_nik_and_phone_number(): void
    {
        $response = $this->from('/register')->post('/register', [
            'name' => 'Budi Warga',
            'email' => 'budi2@example.com',
            'nik' => '123',
            'no_hp' => 'abc',
            'alamat' => 'Kelurahan Konoha',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['nik', 'no_hp']);
        $this->assertDatabaseMissing('users', [
            'email' => 'budi2@example.com',
        ]);
    }
}
