<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Budi Warga',
                'email' => 'warga@test.com',
                'nik' => '3201010101010001',
                'no_hp' => '081234567890',
                'alamat' => 'Kelurahan Konoha, RT 01 RW 02',
                'role' => 'warga',
                'password' => 'password',
            ],
            [
                'name' => 'Siti Petugas',
                'email' => 'petugas@test.com',
                'nik' => '3201010101010002',
                'no_hp' => '081234567891',
                'alamat' => 'Kelurahan Konoha, RT 01 RW 03',
                'role' => 'petugas',
                'password' => 'password',
            ],
            [
                'name' => 'Admin Konoha',
                'email' => 'admin@test.com',
                'nik' => '3201010101010003',
                'no_hp' => '081234567892',
                'alamat' => 'Kelurahan Konoha, RT 02 RW 01',
                'role' => 'admin',
                'password' => 'password',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'nik' => $userData['nik'],
                    'no_hp' => $userData['no_hp'],
                    'alamat' => $userData['alamat'],
                    'role' => $userData['role'],
                    'password' => Hash::make($userData['password']),
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
