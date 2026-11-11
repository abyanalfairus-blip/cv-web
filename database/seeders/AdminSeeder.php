<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Membuat akun login panel admin.
 * Email & password bisa diatur lewat .env (ADMIN_EMAIL, ADMIN_PASSWORD).
 * GANTI password default sebelum website di-hosting.
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'abyanalfairus@gmail.com')],
            [
                'name'     => 'Abyan Alfairus',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin12345')),
            ]
        );
    }
}
