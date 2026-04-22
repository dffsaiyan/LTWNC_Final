<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Slide;
use App\Models\Setting;
use App\Models\Post;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $allProducts = Product::with('category')->latest()->get();
        $flashSaleProducts = Product::where('is_flash_sale', true)
            ->where('sale_price', '>', 0)
            ->where('stock', '>', 0)
            ->withSum(['orderItems as sold_count' => function($query) {
                $query->whereHas('order', function($q) {
                    $q->where('status', 'completed');
                });
            }], 'quantity')
            ->take(8)
            ->get();
        $categories = Category::withCount('products')->get();
        $sidebarCategories = Category::whereIn('slug', ['ban-phim-co', 'chuot-gaming', 'man-hinh-do-hoa', 'laptop-gaming', 'am-thanh-loa', 'lot-chuot-gear', 'keycaps-switch', 'ghe-cong-thai-hoc'])->get();
        
        // Get Slides and Banners
        $slides = Banner::where('position', 'hero_slide')->get();
        if($slides->isEmpty()) {
            $slides = Slide::where('status', true)->orderBy('order', 'asc')->get();
        }
        $banners = Banner::all();
        
        $flashSaleEnd = Setting::where('key', 'flash_sale_end')->first()->value ?? '';
        $flashSaleLink = "#flash-sale";
        
        $posts = Post::where('is_published', true)->latest()->take(4)->get();

        return view('home', compact(
            'allProducts', 'flashSaleProducts', 'categories', 'sidebarCategories',
            'slides', 'banners', 'flashSaleEnd', 'flashSaleLink', 'posts'
        ));
    }
}
