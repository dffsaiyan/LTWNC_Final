<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\Product::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
        
        $brands = ['Akko', 'Keychron', 'Razer', 'Corsair', 'Leopold', 'Filco', 'Ducky', 'SteelSeries', 'Logitech', 'Asus'];
        $layouts = ['Fullsize', 'TKL', '75%', '65%', '60%'];
        $connections = ['Có dây', 'Wireless 2.4GHz', 'Bluetooth'];
        $weights = ['ultralight', 'light', 'heavy'];
        $switches = ['Blue', 'Red', 'Brown', 'Silent'];

        // Category 1: Keyboards
        for ($i = 1; $i <= 5; $i++) {
            $brand = $brands[array_rand($brands)];
            $layout = $layouts[array_rand($layouts)];
            $name = "Bàn phím cơ " . $brand . " Model Series " . $i;
            
            \App\Models\Product::create([
                'category_id' => 1,
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name . '-' . $i),
                'brand' => $brand,
                'layout' => $layout,
                'description' => "Dòng sản phẩm phím cơ cao cấp $name với switch $switches[0] gõ cực thích.",
                'price' => rand(10, 80) * 100000,
                'sale_price' => rand(9, 70) * 100000,
                'stock' => rand(0, 50),
                'is_flash_sale' => ($i <= 5),
                'image' => 'https://via.placeholder.com/400x400?text=' . urlencode($brand)
            ]);
        }

        // Category 2: Gaming Mice
        $mouseBrands = ['Akko', 'Razer', 'Corsair', 'Keychron', 'Logitech', 'Asus'];
        for ($i = 1; $i <= 5; $i++) {
            $brand = $mouseBrands[array_rand($mouseBrands)];
            $connection = $connections[array_rand($connections)];
            $weight = $weights[array_rand($weights)];
            $name = "Chuột Gaming " . $brand . " Pro Model " . $i;
            
            \App\Models\Product::create([
                'category_id' => 2,
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name . '-' . $i),
                'brand' => $brand,
                'connection' => $connection,
                'weight' => $weight,
                'description' => "Chuột gaming chuyên nghiệp $name với độ nhạy cao và thiết kế công thái học.",
                'price' => rand(5, 40) * 100000,
                'sale_price' => rand(4, 35) * 100000,
                'stock' => rand(5, 100),
                'is_flash_sale' => ($i <= 3),
                'image' => 'https://via.placeholder.com/400x400?text=' . urlencode($brand . ' Mouse')
            ]);
        }

        // Category 3: Graphics Monitors (man-hinh-do-hoa)
        $monitorBrands = ['Dell', 'LG', 'ASUS', 'Samsung', 'ViewSonic', 'Gigabyte'];
        $resolutions = ['4K (3840 x 2160)', '2K (2560 x 1440)', 'Full HD (1920 x 1080)'];
        $panels = ['IPS', 'OLED', 'Nano IPS', 'VA'];
        
        for ($i = 1; $i <= 5; $i++) {
            $brand = $monitorBrands[array_rand($monitorBrands)];
            $res = $resolutions[array_rand($resolutions)];
            $panel = $panels[array_rand($panels)];
            $name = "Màn hình $brand Elite Series $i - $res";
            
            \App\Models\Product::create([
                'category_id' => 3, // Slug 'man-hinh-do-hoa' will be ID 3
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name . '-' . $i . '-mon'),
                'brand' => $brand,
                'resolution' => $res,
                'panel' => $panel,
                'description' => "Màn hình đồ họa chuyên nghiệp $name với tấm nền $panel độ chuẩn màu cao sRGB 100%.",
                'price' => rand(30, 250) * 100000,
                'sale_price' => rand(25, 220) * 100000,
                'stock' => rand(5, 30),
                'is_flash_sale' => ($i <= 2),
                'image' => 'https://via.placeholder.com/600x600?text=' . urlencode($brand . ' Monitor')
            ]);
        }

        // Category 4: Laptop Gaming (laptop-gaming)
        $laptopBrands = ['ASUS ROG', 'MSI', 'Acer Predator', 'Dell Alienware', 'Lenovo Legion', 'HP Victus', 'Razer'];
        $cpus = ['Intel Core i9-13980HX', 'Intel Core i7-13700H', 'AMD Ryzen 9 7945HX', 'AMD Ryzen 7 7840HS'];
        $gpus = ['NVIDIA RTX 4090 16GB', 'NVIDIA RTX 4080 12GB', 'NVIDIA RTX 4070 8GB', 'NVIDIA RTX 4060 8GB'];
        $rams = ['64GB DDR5', '32GB DDR5', '16GB DDR5'];
        $ssds = ['2TB NVMe Gen4', '1TB NVMe Gen4', '512GB NVMe Gen4'];
        
        for ($i = 1; $i <= 5; $i++) {
            $brand = $laptopBrands[array_rand($laptopBrands)];
            $cpu = $cpus[array_rand($cpus)];
            $gpu = $gpus[array_rand($gpus)];
            $ram = $rams[array_rand($rams)];
            $ssd = $ssds[array_rand($ssds)];
            $name = "Laptop Gaming " . $brand . " Edition " . $i;
            
            \App\Models\Product::create([
                'category_id' => 4, // Slug 'laptop-gaming' will be ID 4
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name . '-' . $i . '-lp'),
                'brand' => $brand,
                'cpu' => $cpu,
                'gpu' => $gpu,
                'ram' => $ram,
                'ssd' => $ssd,
                'description' => "Siêu phẩm $name trang bị $cpu, card đồ họa $gpu, bộ nhớ $ram và ổ cứng $ssd. Trình diễn hiệu năng đỉnh cao.",
                'price' => rand(25, 120) * 1000000,
                'sale_price' => rand(22, 110) * 1000000,
                'stock' => rand(2, 15),
                'is_flash_sale' => ($i <= 3),
                'image' => 'https://via.placeholder.com/800x800?text=' . urlencode($brand . ' Gaming Laptop')
            ]);
        }

        // Category 5: Audio & Speakers (am-thanh-loa)
        $audioBrands = ['Sony', 'Marshall', 'Bose', 'JBL', 'Sennheiser', 'Harman Kardon'];
        $audioTypes = ['Tai nghe chống ồn', 'Loa Bluetooth', 'Tai nghe In-ear', 'Loa Soundbar'];
        
        for ($i = 1; $i <= 5; $i++) {
            $brand = $audioBrands[array_rand($audioBrands)];
            $type = $audioTypes[array_rand($audioTypes)];
            $name = $type . " " . $brand . " Series " . $i;
            
            \App\Models\Product::create([
                'category_id' => 5, // Slug 'am-thanh-loa' will be ID 5
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name . '-' . $i . '-au'),
                'brand' => $brand,
                'description' => "Trải nghiệm âm thanh đỉnh cao với $name. Công nghệ lọc âm thế hệ mới, bass sâu, dải mid trong trẻo.",
                'price' => rand(2, 45) * 1000000,
                'sale_price' => rand(1, 40) * 1000000,
                'stock' => rand(5, 50),
                'is_flash_sale' => ($i <= 2),
                'image' => 'https://via.placeholder.com/600x600?text=' . urlencode($brand . ' Audio')
            ]);
        }

        // Category 6: Mousepads (lot-chuot-gear)
        $padBrands = ['SteelSeries', 'Razer', 'Corsair', 'Akko', 'Logitech', 'Zowie'];
        $sizes = ['Extended (900x400)', 'XL (450x400)', 'L (320x270)', 'M (250x210)'];
        $surfaces = ['Speed', 'Control', 'Hybrid'];
        
        for ($i = 1; $i <= 5; $i++) {
            $brand = $padBrands[array_rand($padBrands)];
            $size = $sizes[array_rand($sizes)];
            $surface = $surfaces[array_rand($surfaces)];
            $name = "Lót chuột " . $brand . " Model " . $i . " - " . $surface;
            
            \App\Models\Product::create([
                'category_id' => 6, // Slug 'lot-chuot-gear' will be ID 6
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name . '-' . $i . '-pad'),
                'brand' => $brand,
                'size' => $size,
                'surface' => $surface,
                'description' => "Lót chuột cao cấp $name với bề mặt $surface giúp di chuột mượt mà, kích thước $size tối ưu không gian.",
                'price' => rand(2, 12) * 100000,
                'sale_price' => rand(1, 10) * 100000,
                'stock' => rand(20, 100),
                'is_flash_sale' => ($i <= 2),
                'image' => 'https://via.placeholder.com/600x600?text=' . urlencode($brand . ' Mousepad')
            ]);
        }

        // Category 7: Keycaps & Switch (keycaps-switch)
        $kbBrands = ['Akko', 'Ducky', 'GMK', 'Keychron', 'Glorious'];
        $materials = ['PBT Double-shot', 'ABS Laser-etched', 'PBT Dye-sub'];
        $profiles = ['Cherry Profile', 'OEM Profile', 'XDA Profile', 'ASA Profile'];
        
        for ($i = 1; $i <= 5; $i++) {
            $brand = $kbBrands[array_rand($kbBrands)];
            $material = $materials[array_rand($materials)];
            $profile = $profiles[array_rand($profiles)];
            $name = "Bộ Keycap " . $brand . " Collection " . $i;
            
            \App\Models\Product::create([
                'category_id' => 7,
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name . '-' . $i . '-kc'),
                'brand' => $brand,
                'material' => $material,
                'profile' => $profile,
                'description' => "Bộ Keycap $name cao cấp sử dụng chất liệu $material, chuẩn $profile cho cảm giác gõ tuyệt vời.",
                'price' => rand(5, 35) * 100000,
                'sale_price' => rand(4, 30) * 100000,
                'stock' => rand(10, 40),
                'image' => 'https://via.placeholder.com/600x600?text=' . urlencode($brand . ' Keycaps')
            ]);
        }

        // Category 8: Ergonomic Chairs (ghe-cong-thai-hoc)
        $chairBrands = ['Sihoo', 'Herman Miller', 'Mansory', 'Warrior', 'Epione'];
        $frames = ['Hợp kim nhôm', 'Thép cường lực', 'Nhựa ABS chịu lực'];
        
        for ($i = 1; $i <= 5; $i++) {
            $brand = $chairBrands[array_rand($chairBrands)];
            $frame = $frames[array_rand($frames)];
            $name = "Ghế công thái học " . $brand . " Series " . $i;
            
            \App\Models\Product::create([
                'category_id' => 8,
                'name' => $name,
                'slug' => \Illuminate\Support\Str::slug($name . '-' . $i . '-ch'),
                'brand' => $brand,
                'frame' => $frame,
                'description' => "Dòng ghế $name thiết kế chuẩn Ergonomic, khung $frame bền bỉ, hỗ trợ cột sống tối đa.",
                'price' => rand(3, 45) * 1000000,
                'sale_price' => rand(2, 40) * 1000000,
                'stock' => rand(5, 20),
                'image' => 'https://via.placeholder.com/800x800?text=' . urlencode($brand . ' Chair')
            ]);
        }

        \App\Models\Product::create([
            'category_id' => 9,
            'name' => 'Sạc dự phòng Anker 737 Power Bank',
            'slug' => 'sac-du-phong-anker-737',
            'description' => 'Sạc 140W cực nhanh cho Laptop & Phone.',
            'price' => 3500000,
            'stock' => 10
        ]);
    }
}
