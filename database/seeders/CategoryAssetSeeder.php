<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryAssetSeeder extends Seeder
{
    public function run(): void
    {
        $assets = [
            'ban-phim-co' => [
                'icon' => 'images/icon/vecteezy_ergonomic-mechanical-keyboard-with-custom-keycaps-for_60514914.png',
                'bg' => 'images/keyboard-hero.jpg',
                'order' => 1
            ],
            'chuot-gaming' => [
                'icon' => 'images/icon/gaming-mouse-3d-icon-png-download-9675855.webp',
                'bg' => 'images/mouse-hero.jpg',
                'order' => 2
            ],
            'man-hinh-do-hoa' => [
                'icon' => 'images/icon/premium-computer-parts-display-monitor-icon-3d-rendering-isolated-background_150525-4565.png',
                'bg' => 'images/monitor_hero.jpg',
                'order' => 3
            ],
            'laptop-gaming' => [
                'icon' => 'images/icon/laptop-gaming-3d-icon-png-download-11431625.webp',
                'bg' => 'images/laptop_hero.jpg',
                'order' => 4
            ],
            'am-thanh-loa' => [
                'icon' => 'images/icon/audio-icon-concept-with-3d-cartoon-style-headphone-and-blue-speaker-3d-illustration-png.png',
                'bg' => 'images/speaker_hero.jpg',
                'order' => 5
            ],
            'lot-chuot-gear' => [
                'icon' => 'images/icon/ai-gaming-mouse-pad-3d-icon-png-download-jpg-13387054.webp',
                'bg' => 'images/mousepad_hero.jpg',
                'order' => 6
            ],
            'keycaps-switch' => [
                'icon' => 'images/icon/keycap-p-3d-icon-png-download-13964981.png',
                'bg' => 'images/keycap_hero.jpg',
                'order' => 7
            ],
            'ghe-cong-thai-hoc' => [
                'icon' => 'images/icon/gaming-chair-3d-illustration-office-equipment-icon-png.png',
                'bg' => 'images/chair_hero.jpg',
                'order' => 8
            ],
        ];

        foreach ($assets as $slug => $data) {
            $category = Category::where('slug', $slug)->first();
            if ($category) {
                $category->update([
                    'icon' => $data['icon'],
                    'image' => $data['bg'],
                    'show_on_sidebar' => true,
                    'order_index' => $data['order']
                ]);
            }
        }
    }
}
