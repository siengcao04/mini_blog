<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Tạo Author
        User::create([
            'name' => 'Tác giả 1',
            'email' => 'author@example.com',
            'password' => Hash::make('password'),
            'role' => 'author',
            'is_active' => true,
        ]);

        // Tạo User thường
        User::create([
            'name' => 'Người dùng 1',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'is_active' => true,
        ]);
    }
}
