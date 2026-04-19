<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerAssetSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing banners
        Banner::truncate();

        // 3 Banners on the Right
        Banner::create([
            'image' => 'images/banner1.jpg',
            'position' => 'right_1',
            'status' => true
        ]);
        Banner::create([
            'image' => 'images/banner2.jpg',
            'position' => 'right_2',
            'status' => true
        ]);
        Banner::create([
            'image' => 'images/banner3.jpg',
            'position' => 'right_3',
            'status' => true
        ]);

        // Horizontal Banner in the Middle
        Banner::create([
            'image' => 'images/banner_ngang1.jpg',
            'position' => 'horizontal_middle',
            'status' => true
        ]);
    }
}
