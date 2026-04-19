<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\Category::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
        
        \App\Models\Category::create(['name' => 'Bàn phím cơ', 'slug' => 'ban-phim-co']);
        \App\Models\Category::create(['name' => 'Chuột Gaming', 'slug' => 'chuot-gaming']);
        \App\Models\Category::create(['name' => 'Màn hình đồ họa', 'slug' => 'man-hinh-do-hoa']);
        \App\Models\Category::create(['name' => 'Laptop Gaming', 'slug' => 'laptop-gaming']);
        \App\Models\Category::create(['name' => 'Âm thanh & Loa', 'slug' => 'am-thanh-loa']);
        \App\Models\Category::create(['name' => 'Lót chuột Gear', 'slug' => 'lot-chuot-gear']);
        \App\Models\Category::create(['name' => 'Keycaps & Switch', 'slug' => 'keycaps-switch']);
        \App\Models\Category::create(['name' => 'Ghế công thái học', 'slug' => 'ghe-cong-thai-hoc']);
        \App\Models\Category::create(['name' => 'Sạc dự phòng', 'slug' => 'sac-du-phong']);
        \App\Models\Category::create(['name' => 'Phụ kiện khác', 'slug' => 'phu-kien-khac']);
    }
}
