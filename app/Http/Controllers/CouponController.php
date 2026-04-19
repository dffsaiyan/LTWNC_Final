<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function apply(Request $request)
    {
        $code = $request->code;
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json(['status' => 'error', 'message' => 'Mã giảm giá không tồn tại!']);
        }

        // Check expiry
        if ($coupon->expiry_date && Carbon::parse($coupon->expiry_date)->isPast()) {
            return response()->json(['status' => 'error', 'message' => 'Mã giảm giá đã hết hạn!']);
        }

        // Check usage limit
        if ($coupon->max_uses && $coupon->used_count >= $coupon->max_uses) {
            return response()->json(['status' => 'error', 'message' => 'Mã giảm giá đã hết lượt sử dụng!']);
        }

        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Check min order value
        if ($total < $coupon->min_order_value) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Đơn hàng tối thiểu ' . number_format($coupon->min_order_value, 0, ',', '.') . 'đ để dùng mã này!'
            ]);
        }

        // Check category restriction if applicable
        if ($coupon->category_id) {
            $hasValidProduct = false;
            foreach ($cart as $id => $item) {
                $product = Product::find($id);
                if ($product && $product->category_id == $coupon->category_id) {
                    $hasValidProduct = true;
                    break;
                }
            }

            if (!$hasValidProduct) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Mã này chỉ áp dụng cho sản phẩm thuộc danh mục: ' . ($coupon->category ? $coupon->category->name : 'đã chọn')
                ]);
            }
        }

        // Store in session
        session()->put('coupon', [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'category_id' => $coupon->category_id
        ]);

        return response()->json(['status' => 'success', 'message' => 'Áp dụng mã giảm giá thành công!']);
    }

    public function remove()
    {
        session()->forget('coupon');
        return redirect()->back()->with('success', 'Đã hủy áp dụng mã giảm giá!');
    }
}
