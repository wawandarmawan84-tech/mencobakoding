<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_remember_me(): void
    {
        $user = User::factory()->create([
            'email' => 'warga@example.com',
            'password' => 'password123',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
            'remember' => 'on',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_user_is_throttled_after_many_failed_attempts(): void
    {
        for ($i = 0; $i < 6; $i++) {
            $this->post('/login', [
                'email' => 'wrong@example.com',
                'password' => 'wrong-password',
            ]);
        }

        $response = $this->post('/login', [
            'email' => 'wrong@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(429);
    }
}
