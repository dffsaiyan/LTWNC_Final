<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Slide;
use App\Models\Banner;
use App\Models\Post;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $flashSaleProducts = Product::where('is_flash_sale', true)
                                    ->with('category')
                                    ->withSum(['orderItems as sold_count' => function($query) {
                                        $query->whereHas('order', function($q) {
                                            $q->where('status', 'completed');
                                        });
                                    }], 'quantity')
                                    ->get();
        $allProducts = $query->with('category')->get();
        $categories = Category::all();
        $sidebarCategories = Category::where('show_on_sidebar', true)
                                    ->orderBy('order_index', 'asc')
                                    ->take(9)
                                    ->get();

        $flashSaleLink = \App\Models\Setting::where('key', 'flash_sale_sidebar_link')->value('value') ?? '#';

        // Get Slides and Banners
        $slides = Slide::where('status', true)->orderBy('order', 'asc')->get();
        $banners = Banner::where('status', true)->get();

        $flashSaleEnd = \App\Models\Setting::where('key', 'flash_sale_end')->first()->value ?? '';

        $posts = Post::where('is_published', true)->latest()->take(4)->get();

        return view('home', compact('flashSaleProducts', 'allProducts', 'categories', 'sidebarCategories', 'slides', 'banners', 'flashSaleLink', 'flashSaleEnd', 'posts'));
    }

    public function show($slug)
    {
        $product = Product::with(['reviews' => function($q) {
            $q->whereNull('parent_id')->with('replies.user', 'user')->latest();
        }])->where('slug', $slug)->firstOrFail();
        
        $canReview = false;
        if (\Illuminate\Support\Facades\Auth::check()) {
            $canReview = \App\Models\Order::where('user_id', \Illuminate\Support\Facades\Auth::id())
                ->where('status', 'completed')
                ->whereHas('items', function($q) use ($product) {
                    $q->where('product_id', $product->id);
                })->exists();
        }

        // Random number of products between 2 and 8
        $randomLimit = rand(2, 8);
        $relatedProducts = Product::where('id', '!=', $product->id)
                                  ->inRandomOrder()
                                  ->limit($randomLimit)
                                  ->get();

        return view('products.show', compact('product', 'relatedProducts', 'canReview'));
    }

    public function category(Request $request, $slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $query = Product::where('category_id', $category->id);

        // --- LẤY DỮ LIỆU BỘ LỌC ĐỘNG (Dựa trên những gì thực sự có trong kho) ---
        // Lấy tất cả sản phẩm của danh mục này (không phân trang) để thống kê bộ lọc
        $baseProducts = Product::where('category_id', $category->id)->get();
        
        $availableBrands = \App\Models\Brand::whereIn('id', $baseProducts->pluck('brand_id')->filter()->unique())->get();
        $availableLayouts = $baseProducts->pluck('layout')->filter()->unique()->values();
        $availableCPUs = $baseProducts->pluck('cpu')->filter()->unique()->values();
        $availableRAMs = $baseProducts->pluck('ram')->filter()->unique()->values();
        $availableSSDs = $baseProducts->pluck('ssd')->filter()->unique()->values();
        $availableConnections = $baseProducts->pluck('connection')->filter()->unique()->values();

        // --- ÁP DỤNG BỘ LỌC TỪ REQUEST ---
        // Filter by Price Range
        if ($request->has('price')) {
            $query->where(function($q) use ($request) {
                foreach($request->price as $range) {
                    if ($range == 'under_1m') $q->orWhere('sale_price', '<', 1000000);
                    if ($range == '1_3m') $q->orWhereBetween('sale_price', [1000000, 3000000]);
                    if ($range == '3_5m') $q->orWhereBetween('sale_price', [3000000, 5000000]);
                    if ($range == 'over_5m') $q->orWhere('sale_price', '>', 5000000);
                }
            });
        }

        // Filter by Brand (Sửa sang brand_id cho chuẩn)
        if ($request->has('brand')) {
            $query->whereIn('brand_id', $request->brand);
        }

        // Filter by dynamic columns
        $dynamicFilters = [
            'layout', 'connection', 'cpu', 'gpu', 'ram', 'ssd', 'size', 
            'surface', 'material', 'profile', 'frame', 'resolution', 'panel'
        ];
        
        foreach($dynamicFilters as $filter) {
            if ($request->has($filter)) {
                $query->whereIn($filter, $request->$filter);
            }
        }

        // Status filter
        if ($request->has('availability')) {
            foreach($request->availability as $status) {
                if ($status == 'in_stock') $query->where('stock', '>', 0);
                if ($status == 'out_of_stock') $query->where('stock', '<=', 0);
            }
        }

        // Sorting
        $sort = $request->get('sort', 'default');
        switch ($sort) {
            case 'price_asc': $query->orderBy('sale_price', 'asc'); break;
            case 'price_desc': $query->orderBy('sale_price', 'desc'); break;
            case 'newest': $query->orderBy('created_at', 'desc'); break;
            default: $query->orderBy('id', 'desc'); break;
        }

        $products = $query->paginate(12)->withQueryString();
        
        return view('products.category', compact(
            'category', 'products', 'sort', 
            'availableBrands', 'availableLayouts', 'availableCPUs', 
            'availableRAMs', 'availableSSDs', 'availableConnections'
        ));
    }
}
