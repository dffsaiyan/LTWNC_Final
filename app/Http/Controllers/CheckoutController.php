<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CheckoutController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    private function calculateDiscount($total, $cart)
    {
        $discount = 0;
        if (session()->has('coupon')) {
            $couponSession = session()->get('coupon');
            $coupon = Coupon::find($couponSession['id']);
            
            // Re-validate just in case someone stayed on checkout too long
            if ($coupon && (!$coupon->expiry_date || !(\Carbon\Carbon::parse($coupon->expiry_date)->isPast()))) {
                if (!$coupon->max_uses || $coupon->used_count < $coupon->max_uses) {
                    if ($total >= $coupon->min_order_value) {
                        if ($coupon->type == 'fixed') {
                            $discount = $coupon->value;
                        } else {
                            if ($coupon->category_id) {
                                $discountableAmount = 0;
                                foreach ($cart as $id => $details) {
                                    $product = Product::find($id);
                                    if ($product && $product->category_id == $coupon->category_id) {
                                        $discountableAmount += $details['price'] * $details['quantity'];
                                    }
                                }
                                $discount = ($discountableAmount * $coupon->value) / 100;
                            } else {
                                $discount = ($total * $coupon->value) / 100;
                            }
                        }
                    }
                }
            }
        }
        return $discount;
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        if(empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống!');
        }
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $discount = $this->calculateDiscount($total, $cart);
        $grandTotal = $total - $discount;

        return view('checkout.index', compact('cart', 'total', 'discount', 'grandTotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|min:10',
            'province' => 'required',
            'district' => 'required',
            'shipping_address' => 'required|min:5',
            'payment_method' => 'required'
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'phone.required' => 'Vui lòng nhập số điện thoại',
            'shipping_address.required' => 'Vui lòng nhập địa chỉ cụ thể',
            'province.required' => 'Vui lòng chọn Tỉnh/Thành phố',
            'district.required' => 'Vui lòng chọn Quận/Huyện',
        ]);

        $cart = session()->get('cart', []);
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Calculate Shipping Fee on server side (Hanoi code is 1)
        $shipping_fee = ($request->province == '1') ? 0 : 30000;
        
        $discount = $this->calculateDiscount($total, $cart);
        $grandTotal = $total - $discount + $shipping_fee;

        try {
            DB::beginTransaction();

            // Construct full address
            $fullAddress = "{$request->shipping_address}, {$request->district}";
            // Note: In a full-scale app, we'd append the Province name from a DB table or API.
            
            $notes = "Email khách: {$request->email}. \nĐịa chỉ gốc: {$request->shipping_address}. \n" . ($request->notes ?? '');

            $orderData = [
                'user_id' => (int) Auth::id(),
                'total_price' => $grandTotal,
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'shipping_address' => $fullAddress,
                'phone' => $request->phone,
                'notes' => $notes
            ];

            if (session()->has('coupon')) {
                $orderData['coupon_id'] = session()->get('coupon')['id'];
                $orderData['discount_amount'] = $discount;
            }

            $order = Order::create($orderData);

            if (session()->has('coupon')) {
                $coupon = Coupon::find(session()->get('coupon')['id']);
                if ($coupon) {
                    $coupon->increment('used_count');
                }
            }

            foreach($cart as $product_id => $details) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => (int) $product_id,
                    'quantity' => (int) $details['quantity'],
                    'price' => $details['price']
                ]);

                // Update stock
                $product = Product::find($product_id);
                if($product) {
                    $product->stock -= (int) $details['quantity'];
                    $product->save();
                }
            }

            DB::commit();

            session()->forget('coupon'); // Xóa coupon sau khi đặt hàng thành công

            if ($request->payment_method == 'vnpay') {
                return $this->vnpayPayment($order);
            }

            if ($request->payment_method == 'momo') {
                return $this->momoPayment($order);
            }

            session()->forget('cart');
            return view('checkout.success', compact('order'));

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Có lỗi xảy ra: ' . $e->getMessage());
        }
    }

    public function momoPayment($order)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = env('MOMO_PARTNER_CODE', 'MOMO');
        $accessKey = env('MOMO_ACCESS_KEY', 'F8BBA842ECF85');
        $secretKey = env('MOMO_SECRET_KEY', 'K951B6PE1waDMi640xX08PD3vg6EkVlz');

        $orderInfo = "Thanh toan don hang DDH Electronics";
        $amount = (string) round($order->total_price);
        $orderId = (string) $order->id . "_" . time();
        $returnUrl = route('momo.return');
        $notifyUrl = route('momo.return');
        $requestId = (string) time() . rand(100, 999);
        $requestType = "captureWallet";
        $extraData = "";

        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $notifyUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $returnUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "DDH Electronics",
            'storeId' => "DDH_Store",
            'requestId' => $requestId,
            'amount' => (int) $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $returnUrl,
            'ipnUrl' => $notifyUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature
        );

        $payload = json_encode($data);
        $ch = curl_init($endpoint);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ));
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $result = curl_exec($ch);
        curl_close($ch);
        $jsonResult = json_decode($result, true);

        if (isset($jsonResult['payUrl'])) {
            return redirect()->to($jsonResult['payUrl']);
        }
        
        return redirect()->back()->with('error', 'Lỗi MoMo: ' . ($jsonResult['message'] ?? 'Kết nối thất bại!'));
    }

    public function momoReturn(Request $request)
    {
        if ($request->resultCode == 0) {
            session()->forget('cart');
            $parts = explode("_", $request->orderId);
            $order = Order::find($parts[0]);
            return view('checkout.success', compact('order'));
        }
        return redirect()->route('cart.index')->with('error', 'Thanh toán MoMo không thành công!');
    }

    public function vnpayPayment($order)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        
        $vnp_TmnCode = env('VNP_TMN_CODE', 'WCECZUB1');
        $vnp_HashSecret = env('VNP_HASH_SECRET', 'X9MSB2OSJU39WA3OG6DXMFMLQZCYYPBN');
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return');

        $vnp_TxnRef = (string) $order->id; 
        $vnp_OrderInfo = "Thanh toan don hang DDH Electronics #" . $order->id;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = (int) round($order->total_price) * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();
        $vnp_ExpireDate = date('YmdHis', strtotime('+15 minutes'));

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate,
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
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
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect()->to($vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {
        if ($request->vnp_ResponseCode == "00") {
            session()->forget('cart');
            $order = Order::find($request->vnp_TxnRef);
            if ($order) {
                $order->status = 'completed';
                $order->save();
            }
            return view('checkout.success', compact('order'));
        }
        return redirect()->route('cart.index')->with('error', 'Thanh toán không thành công qua VNPAY hoặc giao dịch đã hủy!');
    }
}
