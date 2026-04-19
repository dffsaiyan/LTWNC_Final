<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandSyncSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Lấy tất cả tên brand duy nhất từ bảng products
        $brandNames = Product::whereNotNull('brand')->distinct()->pluck('brand');

        foreach ($brandNames as $name) {
            // 2. Tạo brand trong bảng brands nếu chưa có
            $brand = Brand::firstOrCreate(
                ['name' => $name],
                ['slug' => Str::slug($name)]
            );

            // 3. Cập nhật brand_id cho tất cả sản phẩm có tên hãng này
            Product::where('brand', $name)->update(['brand_id' => $brand->id]);
        }
    }
}
