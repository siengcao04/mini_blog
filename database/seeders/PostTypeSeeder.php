<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();
        $category = Category::first();

        if (!$admin || !$category) {
            $this->command->error('Vui lòng tạo user admin và category trước!');
            return;
        }

        // Tạo bài viết video
        Post::create([
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'title' => 'Hướng dẫn lập trình Laravel cơ bản',
            'slug' => 'huong-dan-lap-trinh-laravel-co-ban',
            'post_type' => 'video',
            'excerpt' => 'Video hướng dẫn chi tiết về Laravel framework cho người mới bắt đầu.',
            'content' => '<p>Trong video này, chúng ta sẽ tìm hiểu về:</p>
                <ul>
                    <li>Cài đặt Laravel</li>
                    <li>Routing cơ bản</li>
                    <li>Controller và View</li>
                    <li>Blade Template</li>
                </ul>',
            'video_url' => 'https://www.youtube.com/watch?v=MFh0Fd7BsjE',
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
            'views' => 150,
        ]);

        // Tạo bài viết text nổi bật
        Post::create([
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'title' => '10 mẹo tối ưu hiệu suất Laravel',
            'slug' => '10-meo-toi-uu-hieu-suat-laravel',
            'post_type' => 'text',
            'excerpt' => 'Khám phá các kỹ thuật giúp ứng dụng Laravel của bạn chạy nhanh hơn.',
            'content' => '<h2>1. Sử dụng Eager Loading</h2>
                <p>Tránh N+1 query bằng cách sử dụng <code>with()</code></p>
                <h2>2. Cache Query Results</h2>
                <p>Lưu kết quả truy vấn vào cache để giảm tải database.</p>
                <h2>3. Optimize Autoloader</h2>
                <p>Chạy <code>composer dump-autoload</code> ở chế độ production.</p>',
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now()->subHours(2),
            'views' => 230,
        ]);

        // Tạo bài viết image
        Post::create([
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'title' => 'Bộ sưu tập giao diện đẹp cho trang web',
            'slug' => 'bo-suu-tap-giao-dien-dep-cho-trang-web',
            'post_type' => 'image',
            'excerpt' => 'Tổng hợp các mẫu giao diện web đẹp mắt và hiện đại.',
            'content' => '<p><strong>Các xu hướng thiết kế web năm 2025:</strong></p>
                <ul>
                    <li>Minimalism (Tối giản)</li>
                    <li>Dark Mode (Chế độ tối)</li>
                    <li>Glassmorphism</li>
                    <li>3D Elements</li>
                </ul>
                <p>Hãy khám phá các mẫu thiết kế này để tạo ra website ấn tượng!</p>',
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now()->subHours(5),
            'views' => 180,
        ]);

        // Tạo thêm bài viết thường (không nổi bật)
        Post::create([
            'user_id' => $admin->id,
            'category_id' => $category->id,
            'title' => 'Tổng quan về PHP 8.3',
            'slug' => 'tong-quan-ve-php-8-3',
            'post_type' => 'text',
            'excerpt' => 'Những tính năng mới trong PHP 8.3 mà developer nên biết.',
            'content' => '<h2>Tính năng mới</h2>
                <p>PHP 8.3 mang đến nhiều cải tiến về hiệu suất và cú pháp.</p>
                <ul>
                    <li>Readonly classes</li>
                    <li>Disjunctive Normal Form (DNF) Types</li>
                    <li>Constants in Traits</li>
                </ul>',
            'status' => 'published',
            'is_featured' => false,
            'published_at' => now()->subDays(1),
            'views' => 95,
        ]);

        $this->command->info('✅ Đã tạo 4 bài viết mẫu với các loại khác nhau!');
    }
}
