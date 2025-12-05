<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kiểm tra xem đã có admin chưa
        $admin = User::where('email', 'admin@miniblog.com')->first();
        
        if (!$admin) {
            // Tạo user admin mới
            $admin = User::create([
                'name' => 'Administrator',
                'email' => 'admin@miniblog.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
            ]);
            
            $this->command->info('✅ Đã tạo user admin:');
            $this->command->info('   Email: admin@miniblog.com');
            $this->command->info('   Password: admin123');
        } else {
            // Cập nhật role admin nếu đã tồn tại
            $admin->role = 'admin';
            $admin->is_active = true;
            $admin->save();
            
            $this->command->info('✅ Đã cập nhật user ' . $admin->email . ' thành admin');
        }
        
        // Cập nhật user đầu tiên (nếu có) thành admin
        $firstUser = User::first();
        if ($firstUser && $firstUser->id !== $admin->id) {
            $firstUser->role = 'admin';
            $firstUser->is_active = true;
            $firstUser->save();
            
            $this->command->info('✅ User ' . $firstUser->email . ' đã được set role admin');
        }
    }
}
