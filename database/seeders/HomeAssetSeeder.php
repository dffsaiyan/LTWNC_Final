<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slide;
use App\Models\Banner;

class HomeAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert Initial Slides
        for ($i = 1; $i <= 10; $i++) {
            Slide::create([
                'image' => 'images/slide' . $i . '.jpg',
                'order' => $i,
                'status' => true
            ]);
        }

        // Insert Initial Banners
        $positions = ['top', 'middle', 'bottom'];
        foreach ($positions as $index => $pos) {
            $num = $index + 1;
            Banner::create([
                'image' => 'images/banner' . $num . '.jpg',
                'position' => $pos,
                'status' => true
            ]);
        }
    }
}
