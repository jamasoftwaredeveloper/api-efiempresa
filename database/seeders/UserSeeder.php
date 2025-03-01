<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'jama_developer@outlook.com',
            'password' => Hash::make('123456789'), // Hashea la contraseña
        ]);

        User::create([
            'name' => 'Customer',
            'email' => 'jama_customer@outlook.com',
            'password' => Hash::make('123456789'), // Hashea la contraseña
        ]);
    }
}
