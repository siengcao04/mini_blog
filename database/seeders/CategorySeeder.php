<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Công nghệ',
                'slug' => Str::slug('Công nghệ'),
                'description' => 'Tin tức và bài viết về công nghệ, lập trình, phần mềm'
            ],
            [
                'name' => 'Du lịch',
                'slug' => Str::slug('Du lịch'),
                'description' => 'Chia sẻ kinh nghiệm du lịch, địa điểm tham quan'
            ],
            [
                'name' => 'Ẩm thực',
                'slug' => Str::slug('Ẩm thực'),
                'description' => 'Món ăn ngon, công thức nấu ăn, nhà hàng'
            ],
            [
                'name' => 'Thể thao',
                'slug' => Str::slug('Thể thao'),
                'description' => 'Tin tức thể thao, bóng đá, thể thao điện tử'
            ],
            [
                'name' => 'Giải trí',
                'slug' => Str::slug('Giải trí'),
                'description' => 'Phim ảnh, âm nhạc, nghệ thuật'
            ],
            [
                'name' => 'Kinh doanh',
                'slug' => Str::slug('Kinh doanh'),
                'description' => 'Khởi nghiệp, quản trị, marketing'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
