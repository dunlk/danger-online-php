<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'maria@dangerweb.com'],
            [
                'name' => 'Maria',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'rodrigo@gmail.com'],
            [
                'name' => 'rodrigo',
                'password' => Hash::make('hola123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );
    }
}
