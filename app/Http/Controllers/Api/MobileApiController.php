<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Post;
use App\Models\Banner;
use App\Models\Slide;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class MobileApiController extends Controller
{
    // 🏠 HOME DATA
    public function getHomeData()
    {
        try {
            $banners = Banner::where('status', 1)->get();
            $slides = Slide::where('status', 1)->get();
            $flashSaleEnd = \App\Models\Setting::where('key', 'flash_sale_end')->first()->value ?? null;
            $flashSales = Product::where('is_flash_sale', 1)
                ->where('sale_price', '>', 0)
                ->where('stock', '>', 0)
                ->with('category')
                ->withSum(['orderItems as sold_count' => function($q) {
                    $q->whereHas('order', function($o) {
                        $o->where('status', 'completed');
                    });
                }], 'quantity')
                ->limit(8)
                ->get();
            
            $newArrivals = Product::orderBy('created_at', 'desc')->with('category')->limit(8)->get();
            
            // Filter popular to avoid duplication
            $flashIds = $flashSales->pluck('id')->toArray();
            $featuredProducts = Product::where('is_active', 1)
                ->whereNotIn('id', $flashIds)
                ->with('category')
                ->withSum(['orderItems as sold_count' => function($q) {
                    $q->whereHas('order', function($o) {
                        $o->where('status', 'completed');
                    });
                }], 'quantity')
                ->limit(8)
                ->get();

            $isFlashActive = $flashSaleEnd && strtotime($flashSaleEnd) > time();

            return response()->json([
                'success' => true,
                'data' => [
                    'banners' => $banners,
                    'slides' => $slides,
                    'popular' => $featuredProducts,
                    'new_arrivals' => $newArrivals,
                    'flash_sale' => $flashSales,
                    'flash_sale_end' => $flashSaleEnd,
                    'is_flash_active' => $isFlashActive
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error in getHomeData: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    // 📦 PRODUCTS
    public function getProducts(Request $request)
    {
        $query = Product::with('category');

        if ($request->category_id && $request->category_id !== 'flash') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->flash_sale == 1 || $request->category_id === 'flash') {
            $query->where('is_flash_sale', 1)
                  ->where('sale_price', '>', 0)
                  ->where('stock', '>', 0);
        }

        if ($request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Add highly accurate real sold count (Sum of quantities from completed orders)
        $query->withSum(['orderItems as sold_count' => function($q) {
            $q->whereHas('order', function($o) {
                $o->where('status', 'completed');
            });
        }], 'quantity');

        $perPage = $request->per_page ?? 6;

        return response()->json([
            'success' => true,
            'data' => $query->paginate($perPage)
        ]);
    }

    public function getProductDetail($id)
    {
        $product = Product::with(['category', 'images', 'reviews.user', 'reviews.replies.user'])->findOrFail($id);
        
        $canReview = false;
        if (Auth::guard('sanctum')->check()) {
            $canReview = Order::where('user_id', Auth::guard('sanctum')->id())
                ->where('status', 'completed')
                ->whereHas('items', function($q) use ($id) {
                    $q->where('product_id', $id);
                })->exists();
        }

        return response()->json([
            'success' => true,
            'data' => $product,
            'can_review' => $canReview
        ]);
    }

    // 📂 CATEGORIES
    public function getCategories()
    {
        $categories = Category::all();
        $flashSaleEnd = \App\Models\Setting::where('key', 'flash_sale_end')->first()->value ?? null;
        $isFlashActive = $flashSaleEnd && strtotime($flashSaleEnd) > time();
        
        return response()->json([
            'success' => true,
            'data' => $categories,
            'is_flash_active' => $isFlashActive
        ]);
    }

    // 📰 BLOG / POSTS
    public function getPosts(Request $request)
    {
        $query = Post::where('is_published', 1)->orderBy('created_at', 'desc');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        return response()->json([
            'success' => true,
            'data' => $query->paginate(10)
        ]);
    }

    public function getPostDetail($id)
    {
        $post = Post::where('is_published', 1)->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $post
        ]);
    }

    // 👤 AUTH
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Thông tin đăng nhập không chính xác.'
            ], 401);
        }

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('mobile-app')->plainTextToken;

        return response()->json([
            'success' => true,
            'token' => $token,
            'user' => $user
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = \App\Models\User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Chúng tôi không tìm thấy người dùng nào với địa chỉ Email này.'
            ], 404);
        }

        // Send reset link using Laravel's password broker
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => true,
                'message' => 'Chúng tôi đã gửi liên kết khôi phục mật khẩu vào Email của bạn!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không thể gửi email khôi phục. Vui lòng thử lại sau.'
        ], 500);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['success' => true]);
    }

    // 🔑 SOCIAL TOKEN EXCHANGE
    public function getSocialToken(Request $request)
    {
        // This is called within the WebView after social login success
        // It uses the web session to identify the user and return a token
        if (Auth::check()) {
            $user = Auth::user();
            $token = $user->createToken('mobile-app-social')->plainTextToken;
            
            return response()->json([
                'success' => true,
                'token' => $token,
                'user' => $user
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Unauthorized or session expired.'
        ], 401);
    }

    public function getProfile(Request $request)
    {
        return response()->json([
            'success' => true,
            'user' => $request->user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();
        
        // Handle password change if requested
        if ($request->filled('password')) {
            // Social login users have null password, they can't "change" it via old_password check
            if ($user->password === null && $provider_name = $user->provider_name) {
                return response()->json([
                    'success' => false,
                    'message' => "Tài khoản đăng nhập bằng $provider_name không thể đổi mật khẩu tại đây."
                ], 422);
            }

            if (!Hash::check($request->old_password, $user->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mật khẩu hiện tại không chính xác.'
                ], 422);
            }
            
            $user->password = Hash::make($request->password);
        }

        $user->fill($request->only(['name', 'phone', 'address', 'province_id', 'district_id']));
        $user->save();

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    // 🛒 ORDERS & CHECKOUT
    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'province' => 'required',
            'district' => 'required',
            'address' => 'required',
            'items' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Thiếu thông tin giao hàng', 'errors' => $validator->errors()], 422);
        }

        try {
            return DB::transaction(function () use ($request) {
                $user = $request->user();
                
                $total = 0;
                $cartItems = [];
                foreach ($request->items as $item) {
                    $product = Product::findOrFail($item['product_id']);
                    $price = ($product->sale_price > 0) ? $product->sale_price : $product->price;
                    $total += $price * $item['quantity'];
                    $cartItems[] = [
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'price' => $price
                    ];
                }

                $discount = 0;
                $couponId = null;
                if ($request->coupon_code) {
                    $coupon = Coupon::where('code', $request->coupon_code)->first();
                    if ($coupon && $coupon->isValid($total)) {
                        $discount = $coupon->calculateDiscount($total);
                        $couponId = $coupon->id;
                    }
                }

                $shipping_fee = ($request->province == 'Thành phố Hà Nội' || $request->province == '1') ? 0 : 30000;
                $grandTotal = $total - $discount + $shipping_fee;

                $fullAddress = "{$request->address}, {$request->district}, {$request->province}";

                $order = Order::create([
                    'user_id' => $user->id,
                    'total_price' => $grandTotal,
                    'status' => 'pending',
                    'payment_method' => $request->payment_method ?? 'cod',
                    'shipping_address' => $fullAddress,
                    'phone' => $request->phone,
                    'notes' => $request->note,
                    'coupon_id' => $couponId,
                    'discount_amount' => $discount
                ]);

                foreach ($cartItems as $ci) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $ci['product']->id,
                        'quantity' => $ci['quantity'],
                        'price' => $ci['price'],
                    ]);
                    
                    // Update stock
                    $ci['product']->stock -= $ci['quantity'];
                    $ci['product']->save();
                }

                // If coupon used, increment count
                if ($couponId) {
                    Coupon::find($couponId)->increment('used_count');
                }

                // Generate payment URL if needed
                $paymentUrl = null;
                if ($order->payment_method === 'vnpay') {
                    $paymentUrl = $this->generateVnpayUrl($order);
                } elseif ($order->payment_method === 'momo') {
                    $paymentUrl = $this->generateMomoUrl($order);
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Đặt hàng thành công',
                    'order' => $order,
                    'payment_url' => $paymentUrl
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi đặt hàng: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generateVnpayUrl($order)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $vnp_TmnCode = env('VNP_TMN_CODE', 'WCECZUB1');
        $vnp_HashSecret = env('VNP_HASH_SECRET', 'X9MSB2OSJU39WA3OG6DXMFMLQZCYYPBN');
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return');

        $vnp_TxnRef = (string)$order->id;
        $vnp_OrderInfo = "Thanh toan don hang #" . $order->id;
        $vnp_Amount = (int)round($order->total_price) * 100;
        
        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => request()->ip(),
            "vnp_Locale" => 'vn',
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => 'billpayment',
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => date('YmdHis', strtotime('+15 minutes')),
        ];

        ksort($inputData);
        $hashdata = "";
        $query = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        
        return $vnp_Url;
    }

    private function generateMomoUrl($order)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = env('MOMO_PARTNER_CODE', 'MOMO');
        $accessKey = env('MOMO_ACCESS_KEY', 'F8BBA842ECF85');
        $secretKey = env('MOMO_SECRET_KEY', 'K951B6PE1waDMi640xX08PD3vg6EkVlz');

        $orderInfo = "Thanh toan don hang DDH Electronics";
        $amount = (string)round($order->total_price);
        $orderId = (string)$order->id . "_" . time();
        $returnUrl = route('momo.return');
        $notifyUrl = route('momo.return');
        $requestId = (string)time() . rand(100, 999);
        $requestType = "captureWallet";
        $extraData = "";

        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $notifyUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $returnUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "DDH Electronics",
            'storeId' => "DDH_Store",
            'requestId' => $requestId,
            'amount' => (int)$amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $returnUrl,
            'ipnUrl' => $notifyUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        ];

        $payload = json_encode($data);
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);
        $jsonResult = json_decode($result, true);

        return $jsonResult['payUrl'] ?? null;
    }

    public function getOrders(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)->with('items.product')->orderBy('created_at', 'desc')->get();
        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    public function getOrderDetail(Request $request, $id)
    {
        $order = Order::where('user_id', $request->user()->id)
            ->with(['items.product', 'user'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $order
        ]);
    }

    public function verifyCoupon(Request $request)
    {
        $coupon = Coupon::where('code', $request->code)->first();
        if (!$coupon || !$coupon->isValid($request->total)) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá không hợp lệ'], 422);
        }
        return response()->json([
            'success' => true,
            'data' => ['discount' => $coupon->calculateDiscount($request->total)]
        ]);
    }

    public function cancelOrder(Request $request, $id)
    {
        $order = Order::where('user_id', $request->user()->id)->findOrFail($id);
        if ($order->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Không thể hủy đơn hàng này'], 422);
        }
        $order->update(['status' => 'cancelled']);
        return response()->json(['success' => true]);
    }

    public function submitReview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'nullable|integer|min:1|max:5',
            'message' => 'required|string',
            'parent_id' => 'nullable|exists:reviews,id',
        ]);

        if ($request->parent_id) {
            if (!Auth::user()->is_admin) {
                return response()->json(['success' => false, 'message' => 'Chỉ quản trị viên mới có quyền phản hồi đánh giá.'], 403);
            }
        }

        $rating = $request->rating;
        if ($rating) {
            $hasBought = Order::where('user_id', Auth::id())
                ->where('status', 'completed')
                ->whereHas('items', function($q) use ($request) {
                    $q->where('product_id', $request->product_id);
                })->exists();

            if (!$hasBought) {
                $rating = null; // Downgrade to just a comment if not bought
            } else {
                // Check if already rated
                $alreadyRated = \App\Models\Review::where('user_id', Auth::id())
                    ->where('product_id', $request->product_id)
                    ->whereNotNull('rating')
                    ->exists();
                
                if ($alreadyRated) {
                    $rating = null; // Already rated, downgrade to comment
                }
            }
        }

        $review = \App\Models\Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'rating' => $rating,
            'message' => $request->message,
            'parent_id' => $request->parent_id,
            'is_visible' => 1
        ]);

        return response()->json(['success' => true, 'data' => $review]);
    }

    public function getWishlist(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user) {
                return response()->json([
                    'success' => true,
                    'data' => []
                ]);
            }

            $wishlist = Wishlist::where('user_id', $user->id)
                ->with('product.category')
                ->get()
                ->map(fn($item) => $item->product)
                ->filter()
                ->values(); // Reset keys for JSON array

            return response()->json([
                'success' => true,
                'data' => $wishlist
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi lấy danh sách yêu thích: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleWishlist(Request $request, $productId)
    {
        $user = $request->user();
        $wishlist = Wishlist::where('user_id', $user->id)->where('product_id', $productId)->first();
        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['success' => true, 'added' => false]);
        }
        Wishlist::create(['user_id' => $user->id, 'product_id' => $productId]);
        return response()->json(['success' => true, 'added' => true]);
    }

    public function clearWishlist(Request $request)
    {
        Wishlist::where('user_id', $request->user()->id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Đã xóa toàn bộ danh sách yêu thích.'
        ]);
    }

    // 🛒 CART SYNC
    public function getCart(Request $request)
    {
        $user = $request->user();
        $cartItems = \App\Models\Cart::where('user_id', $user->id)->with('product')->get()->map(fn($item) => [
            'id' => $item->product_id,
            'name' => $item->product->name,
            'price' => ($item->product->sale_price > 0) ? $item->product->sale_price : $item->product->price,
            'image' => $item->product->image,
            'quantity' => $item->quantity,
            'stock' => $item->product->stock,
            'slug' => $item->product->slug
        ]);
        return response()->json(['success' => true, 'data' => $cartItems]);
    }

    public function addToCart(Request $request)
    {
        $user = $request->user();
        $p = Product::findOrFail($request->product_id);
        if ($p->stock < $request->quantity) return response()->json(['success' => false, 'message' => 'Hết hàng'], 422);

        $item = \App\Models\Cart::where('user_id', $user->id)->where('product_id', $request->product_id)->first();
        if ($item) {
            $item->increment('quantity', $request->quantity ?? 1);
        } else {
            \App\Models\Cart::create(['user_id' => $user->id, 'product_id' => $request->product_id, 'quantity' => $request->quantity ?? 1]);
        }
        return $this->getCart($request);
    }

    public function updateCart(Request $request)
    {
        $user = $request->user();
        \App\Models\Cart::where('user_id', $user->id)->where('product_id', $request->product_id)->update(['quantity' => $request->quantity]);
        return $this->getCart($request);
    }

    public function removeFromCart(Request $request, $productId)
    {
        $user = $request->user();
        \App\Models\Cart::where('user_id', $user->id)->where('product_id', $productId)->delete();
        return $this->getCart($request);
    }

    public function clearCart(Request $request)
    {
        \App\Models\Cart::where('user_id', $request->user()->id)->delete();
        return response()->json(['success' => true, 'data' => []]);
    }
}
