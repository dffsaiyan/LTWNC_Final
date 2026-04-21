<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Slide;
use App\Models\Banner;
use App\Models\Coupon;
use App\Models\Setting;
use App\Models\ProductImage;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AdminController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
            function ($request, $next) {
                $user = auth()->user();
                $method = $request->route()->getActionMethod();
                $writerMethods = ['posts', 'createPost', 'storePost', 'editPost', 'updatePost', 'deletePost'];

                // Nếu là Super Admin (email cứng) thì cho qua hết
                if ($user->email === 'admin@ddh.com') {
                    return $next($request);
                }

                // Nếu là Admin thì cho qua hết
                if ($user->is_admin) {
                    return $next($request);
                }

                // Nếu là Writer
                if ($user->can_write_posts && in_array($method, $writerMethods)) {
                    return $next($request);
                }

                // Các trường hợp khác: Không có quyền
                return redirect('/')->with('error', 'Bạn không có quyền truy cập khu vực này!');
            }
        ];
    }

    public function dashboard()
    {
        $total_orders = Order::where('status', '!=', 'cancelled')->count();
        $total_revenue = Order::where('status', 'completed')->sum('total_price');
        $total_products = Product::count();
        $total_users = User::count();

        // Data for Chart.js
        $orders_by_date = Order::where('status', 'completed')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total'))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        $labels = $orders_by_date->pluck('date');
        $data = $orders_by_date->pluck('total');

        $latest_orders = Order::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact('total_orders', 'total_revenue', 'total_products', 'total_users', 'labels', 'data', 'latest_orders'));
    }

    public function orders(Request $request)
    {
        if(!auth()->user() || !auth()->user()->is_admin) {
             return redirect('/')->with('error', 'Bạn không có quyền truy cập!');
        }

        $query = User::whereHas('orders');

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        // Get users with order counts and active orders (not completed/cancelled)
        $customers = $query->withCount(['orders', 'orders as active_orders_count' => function($q) {
            $q->whereNotIn('status', ['completed', 'cancelled']);
        }])->latest()->paginate(15)->withQueryString();

        // Calculate total spent for each customer
        foreach ($customers as $customer) {
            $customer->total_spent = Order::where('user_id', $customer->id)->where('status', 'completed')->sum('total_price');
        }

        if ($request->ajax()) {
            return view('admin.orders.partials.customer_list', compact('customers'))->render();
        }

        return view('admin.orders.index', compact('customers'));
    }

    public function customerOrders($id)
    {
        $customer = User::findOrFail($id);
        $orders = Order::where('user_id', $id)->with('user')->latest()->paginate(15);
        return view('admin.orders.customer', compact('customer', 'orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status === 'completed') {
            return redirect()->back()->with('error', 'Đơn hàng đã ở trạng thái "Đã nhận hàng" không thể thay đổi thêm!');
        }

        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();

        if ($oldStatus != $request->status) {
            $statusLabels = [
                'pending' => 'Chờ xác nhận',
                'processing' => 'Đang xử lý',
                'shipping' => 'Đang vận chuyển',
                'completed' => 'Đã nhận hàng',
                'cancelled' => 'Hủy'
            ];

            $newStatusLabel = $statusLabels[$request->status] ?? $request->status;

            \App\Models\Notification::create([
                'user_id' => $order->user_id,
                'title' => 'Cập nhật đơn hàng #DDH-' . $order->id,
                'message' => 'Đơn hàng của bạn đã chuyển sang trạng thái: ' . $newStatusLabel,
                'link' => route('account.order_detail', $order->id)
            ]);
        }

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái đơn hàng và gửi thông báo cho khách hàng!');
    }

    public function flashSales(Request $request)
    {
        if(!auth()->user() || !auth()->user()->is_admin) {
             return redirect('/')->with('error', 'Bạn không có quyền truy cập!');
        }
        
        $query = Product::with('category');

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->orderBy('is_flash_sale', 'desc')
                          ->latest()
                          ->paginate(15)
                          ->withQueryString();
                            
        $active_flash_sales = Product::where('is_flash_sale', true)->count();
        $categories = Category::all();
        
        $global_flash_sale_end = \App\Models\Setting::where('key', 'flash_sale_end')->first()->value ?? '';
        
        return view('admin.flash_sales', compact('products', 'active_flash_sales', 'categories', 'global_flash_sale_end'));
    }

    public function updateGlobalFlashSaleEnd(Request $request)
    {
        if(!auth()->user() || !auth()->user()->is_admin) {
             return redirect('/')->with('error', 'Bạn không có quyền thao tác!');
        }

        $request->validate([
            'flash_sale_date' => 'required|date',
            'flash_sale_time' => 'required',
        ]);

        $dateTimeStr = $request->flash_sale_date . ' ' . $request->flash_sale_time;
        $flashEnd = \Carbon\Carbon::parse($dateTimeStr);

        if ($flashEnd->isPast()) {
            return redirect()->back()->with('error', 'Thời gian kết thúc chung không được ở trong quá khứ!');
        }

        \App\Models\Setting::updateOrCreate(
            ['key' => 'flash_sale_end'],
            ['value' => $flashEnd->toDateTimeString()]
        );

        return redirect()->back()->with('success', 'Đã cập nhật thời gian Flash Sale chung cho toàn hệ thống!');
    }

    public function updateFlashSale(Request $request, $id)
    {
        if(!auth()->user() || !auth()->user()->is_admin) {
             return redirect('/')->with('error', 'Bạn không có quyền thao tác!');
        }
        
        $product = Product::findOrFail($id);

        if($request->has('toggle_status')) {
            $product->is_flash_sale = !$product->is_flash_sale;
            // If turning off flash sale, reset the sale price to 0 or null
            if(!$product->is_flash_sale) {
                 $product->sale_price = 0;
            } else {
                 if($product->sale_price <= 0) {
                     // Auto set 10% off if no sale price defined when turning on
                     $product->sale_price = $product->price * 0.9;
                 }
            }
            $product->save();
            $status = $product->is_flash_sale ? 'Đã bật' : 'Đã tắt';
            return redirect()->back()->with('success', $status . ' Flash Sale cho sản phẩm: ' . $product->name);
        }

        if($request->has('update_price')) {
            $request->validate([
                'sale_price' => 'required|numeric|min:0|lt:' . $product->price,
            ], [
                'sale_price.lt' => 'Giá Flash Sale phải nhỏ hơn giá gốc!',
            ]);

            $product->sale_price = $request->sale_price;
            $product->save();
            return redirect()->back()->with('success', 'Đã cập nhật giá Flash Sale cho sản phẩm!');
        }

        return redirect()->back();
    }

    public function stopAllFlashSales()
    {
        if(!auth()->user() || !auth()->user()->is_admin) {
             return redirect('/')->with('error', 'Bạn không có quyền thao tác!');
        }
        
        Product::where('is_flash_sale', true)->update([
            'is_flash_sale' => false,
            'sale_price' => 0
        ]);
        
        return redirect()->back()->with('success', 'Đã dừng toàn bộ chương trình Flash Sale thành công!');
    }

    // --- Product Management ---
    public function products(Request $request) {
        $query = Product::with('category');

        // Lọc theo Danh mục
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Tìm kiếm thông minh: Tên, Thương hiệu hoặc mã SKU
        if ($request->has('search') && $request->search != '') {
            $s = $request->search;
            
            // Giải mã nếu user nhập SKU (VD: DDH-KBD-0001 -> lấy số 1)
            $extractedId = null;
            if (preg_match('/DDH-.*-(\d+)/i', $s, $matches)) {
                $extractedId = (int)$matches[1];
            }

            $query->where(function($q) use ($s, $extractedId) {
                $q->where('name', 'LIKE', "%$s%")
                  ->orWhere('brand', 'LIKE', "%$s%")
                  ->orWhere('id', 'LIKE', "%$s%"); // Tìm theo ID thô
                
                if ($extractedId) {
                    $q->orWhere('id', $extractedId); // Tìm theo ID đã tách từ SKU
                }
            });
        }

        $products = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::all();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function createProduct() {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.create', compact('categories', 'brands'));
    }

    private function sanitizePrice($value) {
        if (!$value) return 0;
        // Xóa dấu phẩy, khoảng cách, và dấu chấm phân cách hàng nghìn (nếu có)
        $clean = str_replace([',', '.', ' ', 'VNĐ', 'đ'], '', $value);
        return round((float) $clean);
    }

    public function storeProduct(Request $request) {
        // Sanitize prices before validation
        $request->merge([
            'price' => $this->sanitizePrice($request->price),
            'sale_price' => $this->sanitizePrice($request->sale_price),
        ]);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'is_flash_sale' => 'nullable|boolean',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'image_file' => 'nullable|image|max:2048',
            'additional_images' => 'nullable|string',
            'specifications' => 'nullable|string',
            'faqs' => 'nullable|string',
            'layout' => 'nullable|string',
            'connection' => 'nullable|string',
            'cpu' => 'nullable|string',
            'ram' => 'nullable|string',
            'ssd' => 'nullable|string',
            'gpu' => 'nullable|string',
            'resolution' => 'nullable|string',
            'panel' => 'nullable|string',
            'weight' => 'nullable|string',
            'size' => 'nullable|string',
            'surface' => 'nullable|string',
            'material' => 'nullable|string',
            'profile' => 'nullable|string',
            'frame' => 'nullable|string'
        ]);

        $data['is_flash_sale'] = $request->has('is_flash_sale');
        if (!$data['is_flash_sale']) {
            $data['sale_price'] = 0;
        }

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/products'), $filename);
            $data['image'] = 'storage/products/' . $filename;
        }
        // Xử lý thông số kỹ thuật (Dòng 1: Giá trị 1)
        if ($request->specifications) {
            $specs = [];
            foreach (explode("\n", str_replace("\r", "", $request->specifications)) as $line) {
                if (strpos($line, ':') !== false) {
                    [$k, $v] = explode(':', $line, 2);
                    $specs[trim($k)] = trim($v);
                }
            }
            $data['specifications'] = $specs;
        }

        // Xử lý FAQ (Câu hỏi? Trả lời)
        if ($request->faqs) {
            $faqs = [];
            foreach (explode("\n", str_replace("\r", "", $request->faqs)) as $line) {
                if (strpos($line, '?') !== false) {
                    [$q, $a] = explode('?', $line, 2);
                    $faqs[trim($q) . '?'] = trim($a);
                }
            }
            $data['faqs'] = $faqs;
        }

        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();
        $product = Product::create($data);

        if ($request->additional_images) {
            $urls = explode("\n", str_replace("\r", "", $request->additional_images));
            foreach ($urls as $url) {
                $trimmed = trim($url);
                if ($trimmed) {
                    $product->images()->create(['image' => $trimmed]);
                }
            }
        }

        return redirect()->route('admin.products', ['category' => $product->category_id])->with('success', 'Đã thêm sản phẩm mới!');
    }

    public function editProduct($id) {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.products.edit', compact('product', 'categories', 'brands'));
    }

    public function updateProduct(Request $request, $id) {
        $product = Product::findOrFail($id);
        
        // Sanitize prices before validation
        $request->merge([
            'price' => $this->sanitizePrice($request->price),
            'sale_price' => $this->sanitizePrice($request->sale_price),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'required|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'is_flash_sale' => 'nullable|boolean',
            'stock' => 'required|integer|min:0',
        ]);

        $data = $request->all();
        $data['is_flash_sale'] = $request->has('is_flash_sale');
        
        // Nếu tắt flash sale từ form này, ta có thể giữ sale_price hoặc reset tùy business
        // Nhưng ở đây nếu user nhập sale_price = 0 và tắt flash sale thì chắc chắn là 0
        if (!$data['is_flash_sale']) {
            $data['sale_price'] = 0;
        }

        // CHỨC NĂNG TẢI ẢNH CHÍNH (CHUẨN NHẤT)
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            // Lưu trực tiếp vào thư mục public/storage/products
            $file->move(public_path('storage/products'), $filename);
            $data['image'] = 'storage/products/' . $filename;
        } else {
            $data['image'] = $request->image;
        }

        // Xử lý thông số kỹ thuật
        if ($request->specifications) {
            $specs = [];
            foreach (explode("\n", str_replace("\r", "", $request->specifications)) as $line) {
                if (strpos($line, ':') !== false) {
                    [$k, $v] = explode(':', $line, 2);
                    $specs[trim($k)] = trim($v);
                }
            }
            $data['specifications'] = $specs;
        } else {
            $data['specifications'] = null;
        }

        // Xử lý FAQ
        if ($request->faqs) {
            $faqs = [];
            foreach (explode("\n", str_replace("\r", "", $request->faqs)) as $line) {
                if (strpos($line, '?') !== false) {
                    [$q, $a] = explode('?', $line, 2);
                    $faqs[trim($q) . '?'] = trim($a);
                }
            }
            $data['faqs'] = $faqs;
        } else {
            $data['faqs'] = null;
        }

        $product->update($data);

        // Xử lý ảnh bổ sung từ URL
        if ($request->has('additional_images')) {
            $urls = explode("\n", str_replace("\r", "", $request->additional_images));
            foreach ($urls as $url) {
                $trimmed = trim($url);
                if ($trimmed) {
                    // Chỉ tạo nếu chưa tồn tại
                    if (!$product->images()->where('image', $trimmed)->exists()) {
                        $product->images()->create(['image' => $trimmed]);
                    }
                }
            }
        }

        // Xử lý ảnh bổ sung tải lên từ máy tính
        if ($request->hasFile('additional_images_files')) {
            foreach ($request->file('additional_images_files') as $file) {
                $path = $file->store('products/additional', 'public');
                $product->images()->create(['image' => 'storage/' . $path]);
            }
        }

        return redirect()->route('admin.products', ['category' => $product->category_id])->with('success', 'Đã cập nhật sản phẩm!');
    }

    public function deleteProduct($id) {
        $product = Product::findOrFail($id);
        
        // Delete main image file
        if ($product->image && strpos($product->image, 'storage/') !== false) {
            $path = str_replace('storage/', '', $product->image);
            \Storage::disk('public')->delete($path);
        }

        // Delete additional images files
        foreach($product->images as $img) {
            if (strpos($img->image, 'storage/') !== false) {
                $path = str_replace('storage/', '', $img->image);
                \Storage::disk('public')->delete($path);
            }
        }

        $product->delete();
        return redirect()->back()->with('success', 'Đã xóa sản phẩm!');
    }

    public function deleteAllProducts() {
        $products = Product::all();
        foreach($products as $product) {
            /** @var Product $product */
            // Delete main image file
            if ($product->image && strpos($product->image, 'storage/') !== false) {
                $path = str_replace('storage/', '', $product->image);
                \Storage::disk('public')->delete($path);
            }
            
            // Delete additional images files
            foreach($product->images as $img) {
                /** @var ProductImage $img */
                if (strpos($img->image, 'storage/') !== false) {
                    $path = str_replace('storage/', '', $img->image);
                    \Storage::disk('public')->delete($path);
                }
            }
            $product->delete();
        }
        return redirect()->back()->with('success', 'Đã xóa toàn bộ sản phẩm và làm sạch dữ liệu ảnh!');
    }

    public function deleteProductImage($id) {
        $image = ProductImage::findOrFail($id);
        // Delete physical file if exists
        if (strpos($image->image, 'storage/') !== false) {
            $path = str_replace('storage/', '', $image->image);
            \Storage::disk('public')->delete($path);
        }
        $image->delete();
        return redirect()->back()->with('success', 'Đã xóa ảnh bổ sung!');
    }

    public function deleteAllProductImages($productId) {
        $images = ProductImage::where('product_id', $productId)->get();
        foreach ($images as $image) {
            /** @var ProductImage $image */
            if (strpos($image->image, 'storage/') !== false) {
                $path = str_replace('storage/', '', $image->image);
                \Storage::disk('public')->delete($path);
            }
            $image->delete();
        }
        return redirect()->back()->with('success', 'Đã xóa toàn bộ ảnh bổ sung!');
    }

    // --- Category Management ---
    public function categories() {
        $categories = Category::withCount('products')->orderBy('order_index', 'asc')->paginate(8);
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        return view('admin.categories.index', compact('categories', 'settings'));
    }

    public function storeCategory(Request $request) {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $request->id,
            'filters' => 'nullable|array',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order_index' => 'nullable|integer'
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'filters' => $request->filters ?? [],
            'show_on_sidebar' => $request->has('show_on_sidebar'),
            'order_index' => $request->order_index ?? 0
        ];

        if ($request->id) {
            $category = Category::findOrFail($request->id);
            
            if ($request->hasFile('icon')) {
                if ($category->icon && strpos($category->icon, 'storage/categories') !== false) {
                    \Storage::disk('public')->delete(str_replace('storage/', '', $category->icon));
                }
                $data['icon'] = 'storage/' . $request->file('icon')->store('categories/icons', 'public');
            }

            if ($request->hasFile('image')) {
                if ($category->image && strpos($category->image, 'storage/categories') !== false) {
                    \Storage::disk('public')->delete(str_replace('storage/', '', $category->image));
                }
                $data['image'] = 'storage/' . $request->file('image')->store('categories/backgrounds', 'public');
            }
        } else {
            if ($request->hasFile('icon')) {
                $data['icon'] = 'storage/' . $request->file('icon')->store('categories/icons', 'public');
            }
            if ($request->hasFile('image')) {
                $data['image'] = 'storage/' . $request->file('image')->store('categories/backgrounds', 'public');
            }
        }

        Category::updateOrCreate(['id' => $request->id], $data);

        return redirect()->back()->with('success', $request->id ? 'Đã cập nhật danh mục!' : 'Đã thêm danh mục mới!');
    }

    public function deleteCategory($id) {
        $category = Category::findOrFail($id);
        if($category->products_count > 0) return redirect()->back()->with('error', 'Không thể xóa danh mục đang có sản phẩm!');
        $category->delete();
        return redirect()->back()->with('success', 'Đã xóa danh mục!');
    }

    // --- User Management ---
    public function users() {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function toggleAdmin($id) {
        $user = User::findOrFail($id);
        if($user->id === auth()->id()) return redirect()->back()->with('error', 'Bạn không thể tự hạ quyền chính mình!');
        $user->is_admin = !$user->is_admin;
        $user->save();
        return redirect()->back()->with('success', 'Đã cập nhật quyền hạn người dùng!');
    }

    public function toggleWritePermission($id) {
        $user = User::findOrFail($id);
        if($user->email === 'admin@ddh.com') return redirect()->back()->with('error', 'Tài khoản Super Admin mặc định có toàn quyền!');
        $user->can_write_posts = !$user->can_write_posts;
        $user->save();
        return redirect()->back()->with('success', 'Đã cập nhật quyền viết bài cho người dùng: ' . $user->name);
    }

    // --- Voucher Management ---
    public function coupons() {
        $coupons = Coupon::with('category')->latest()->get();
        $categories = Category::all();
        return view('admin.coupons.index', compact('coupons', 'categories'));
    }

    public function storeCoupon(Request $request) {
        $data = $request->validate([
            'code' => 'required|unique:coupons|max:50',
            'type' => 'required|in:fixed,percent',
            'value' => 'required|numeric|min:0',
            'min_order_value' => 'nullable|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'category_id' => 'nullable|exists:categories,id',
            'expiry_date' => 'nullable|date'
        ]);
        Coupon::create($data);
        return redirect()->back()->with('success', 'Đã tạo mã giảm giá mới thành công!');
    }

    public function deleteCoupon($id) {
        Coupon::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Đã xóa mã giảm giá!');
    }

    // --- Settings ---
    public function settings() {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request) {
        foreach($request->except('_token') as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return redirect()->back()->with('success', 'Đã cập nhật cài đặt hệ thống!');
    }

    // --- Reports ---
    public function reports() {
        $top_products = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderBy('total_sold', 'DESC')
            ->take(10)
            ->get()
            ->map(function($item) {
                $item->product = Product::find($item->product_id);
                return $item;
            });

        $monthly_revenue = Order::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_price) as total'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->get();

        return view('admin.reports', compact('top_products', 'monthly_revenue'));
    }

    // --- Brands Management ---
    public function brands() {
        $brands = Brand::withCount('products')->latest()->paginate(8);
        return view('admin.brands.index', compact('brands'));
    }

    public function storeBrand(Request $request) {
        $request->validate([
            'name' => 'required',
            'logo' => 'nullable|image|max:2048'
        ]);

        $data = $request->only('name');
        $data['slug'] = Str::slug($request->name);

        if($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('brands', 'public');
        }

        Brand::updateOrCreate(['id' => $request->id], $data);
        return redirect()->back()->with('success', 'Đã lưu thương hiệu thành công!');
    }

    public function deleteBrand($id) {
        $brand = Brand::findOrFail($id);
        if($brand->logo) Storage::disk('public')->delete($brand->logo);
        $brand->delete();
        return redirect()->back()->with('success', 'Đã xóa thương hiệu thành công!');
    }

    public function deleteBrandLogo($id) {
        $brand = Brand::findOrFail($id);
        if($brand->logo) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($brand->logo);
            $brand->logo = null;
            $brand->save();
        }
        return redirect()->back()->with('success', 'Đã xóa logo thương hiệu!');
    }

    public function slides()
    {
        $slides = Slide::orderBy('order')->get();
        return view('admin.slides.index', compact('slides'));
    }

    public function storeSlide(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|url',
            'order' => 'required|integer|between:1,10'
        ]);

        $imagePath = $request->file('image')->store('slides', 'public');
        Slide::create([
            'image' => 'storage/' . $imagePath,
            'link' => $request->link,
            'order' => $request->order,
            'status' => true
        ]);
        return redirect()->back()->with('success', 'Đã thêm slide mới thành công!');
    }

    public function updateSlide(Request $request, $id)
    {
        $slide = Slide::findOrFail($id);
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable|url',
            'order' => 'required|integer|between:1,10'
        ]);

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu nằm trong storage
            if (strpos($slide->image, 'storage/slides') !== false) {
                \Storage::disk('public')->delete(str_replace('storage/', '', $slide->image));
            }
            $imagePath = $request->file('image')->store('slides', 'public');
            $slide->image = 'storage/' . $imagePath;
        }

        $slide->link = $request->link;
        $slide->order = $request->order;
        $slide->save();

        return redirect()->back()->with('success', 'Đã cập nhật slide thành công!');
    }

    public function deleteSlide($id)
    {
        $slide = Slide::findOrFail($id);
        if (strpos($slide->image, 'storage/slides') !== false) {
            \Storage::disk('public')->delete(str_replace('storage/', '', $slide->image));
        }
        $slide->delete();
        return redirect()->back()->with('success', 'Đã xóa slide thành công!');
    }

    public function banners()
    {
        $banners = Banner::all();
        return view('admin.banners.index', compact('banners'));
    }

    public function updateBanner(Request $request, $id) {
        $banner = Banner::findOrFail($id);
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'link' => 'nullable',
            'position' => 'required|string'
        ]);

        if ($request->hasFile('image')) {
            if (strpos($banner->image, 'storage/banners') !== false) {
                \Storage::disk('public')->delete(str_replace('storage/', '', $banner->image));
            }
            $imagePath = $request->file('image')->store('banners', 'public');
            $banner->image = 'storage/' . $imagePath;
        }

        $banner->link = $request->link;
        $banner->position = $request->position;
        $banner->save();

        return redirect()->back()->with('success', 'Đã cập nhật banner thành công!');
    }

    // --- Post Management ---
    public function posts() {
        $posts = Post::with('user')->latest()->paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    public function createPost() {
        return view('admin.posts.create');
    }

    public function storePost(Request $request) {
        $data = $request->validate([
            'title' => 'required|max:255',
            'summary' => 'nullable|max:500',
            'content' => 'required',
            'thumbnail_file' => 'nullable|image|max:2048',
            'thumbnail_url' => 'nullable|string'
        ]);

        if ($request->hasFile('thumbnail_file')) {
            $data['thumbnail'] = 'storage/' . $request->file('thumbnail_file')->store('posts', 'public');
        } else {
            $data['thumbnail'] = $request->thumbnail_url;
        }

        $data['user_id'] = auth()->id();
        $data['is_published'] = $request->has('is_published');

        Post::create($data);

        return redirect()->route('admin.posts')->with('success', 'Đã đăng bài viết mới thành công!');
    }

    public function editPost($id) {
        $post = Post::findOrFail($id);
        // Kiểm tra quyền: Super Admin hoặc chính chủ bài viết
        if(auth()->user()->email !== 'admin@ddh.com' && $post->user_id !== auth()->id()) {
            return redirect()->route('admin.posts')->with('error', 'Bạn không có quyền chỉnh sửa bài viết này!');
        }
        return view('admin.posts.edit', compact('post'));
    }

    public function updatePost(Request $request, $id) {
        $post = Post::findOrFail($id);
        if(auth()->user()->email !== 'admin@ddh.com' && $post->user_id !== auth()->id()) {
            return redirect()->route('admin.posts')->with('error', 'Bạn không có quyền chỉnh sửa bài viết này!');
        }

        $data = $request->validate([
            'title' => 'required|max:255',
            'summary' => 'nullable|max:500',
            'content' => 'required',
            'thumbnail_file' => 'nullable|image|max:2048',
            'thumbnail_url' => 'nullable|string'
        ]);

        if ($request->hasFile('thumbnail_file')) {
            if ($post->thumbnail && strpos($post->thumbnail, 'storage/posts') !== false) {
                \Storage::disk('public')->delete(str_replace('storage/', '', $post->thumbnail));
            }
            $data['thumbnail'] = 'storage/' . $request->file('thumbnail_file')->store('posts', 'public');
        } else {
            $data['thumbnail'] = $request->thumbnail_url ?? $post->thumbnail;
        }

        $data['is_published'] = $request->has('is_published');
        $post->update($data);

        return redirect()->route('admin.posts')->with('success', 'Đã cập nhật bài viết thành công!');
    }

    public function deletePost($id) {
        $post = Post::findOrFail($id);
        if(auth()->user()->email !== 'admin@ddh.com' && $post->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa bài viết này!');
        }

        if ($post->thumbnail && strpos($post->thumbnail, 'storage/posts') !== false) {
            \Storage::disk('public')->delete(str_replace('storage/', '', $post->thumbnail));
        }

        $post->delete();
        return redirect()->route('admin.posts')->with('success', 'Đã xóa bài viết thành công!');
    }

    // --- Subscriber Management ---
    public function subscribers() {
        $subscribers = \App\Models\Subscriber::latest()->paginate(20);
        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function deleteSubscriber($id) {
        $subscriber = \App\Models\Subscriber::findOrFail($id);
        $subscriber->delete();
        return redirect()->back()->with('success', 'Đã xóa người đăng ký thành công!');
    }
}
