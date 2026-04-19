<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        $discount = 0;
        $changed = false;

        $updatedCart = $cart;

        if($cart) {
            foreach($cart as $id => $details) {
                $product = Product::find($id);
                if ($product) {
                    // Sync current info from DB
                    $currentPrice = ($product->sale_price > 0) ? $product->sale_price : $product->price;
                    $currentImage = $product->image ?? 'https://via.placeholder.com/100x100?text=' . urlencode($product->name);
                    
                    if ($updatedCart[$id]['price'] != $currentPrice || 
                        $updatedCart[$id]['name'] != $product->name || 
                        $updatedCart[$id]['image'] != $currentImage || 
                        ($updatedCart[$id]['slug'] ?? '') != $product->slug) {
                        
                        $updatedCart[$id]['price'] = $currentPrice;
                        $updatedCart[$id]['name'] = $product->name;
                        $updatedCart[$id]['image'] = $currentImage;
                        $updatedCart[$id]['slug'] = $product->slug;
                        $changed = true;
                    }
                    $total += $updatedCart[$id]['price'] * $updatedCart[$id]['quantity'];
                } else {
                    // Product deleted from DB, remove from cart
                    unset($updatedCart[$id]);
                    $changed = true;
                }
            }
        }

        if ($changed) {
            session()->put('cart', $updatedCart);
            $cart = $updatedCart;
        }

        if(session()->has('coupon')) {
            $coupon = session()->get('coupon');
            if($coupon['type'] == 'fixed') {
                $discount = $coupon['value'];
            } else {
                if ($coupon['category_id']) {
                    $discountableAmount = 0;
                    foreach ($cart as $id => $details) {
                        $product = Product::find($id);
                        if ($product && $product->category_id == $coupon['category_id']) {
                            $discountableAmount += $details['price'] * $details['quantity'];
                        }
                    }
                    $discount = ($discountableAmount * $coupon['value']) / 100;
                } else {
                    $discount = ($total * $coupon['value']) / 100;
                }
            }
        }

        $grandTotal = $total - $discount;
        return view('cart.index', compact('cart', 'total', 'discount', 'grandTotal'));
    }

    public function add($id)
    {
        $product = Product::findOrFail($id);
        
        if($product->stock <= 0) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Rất tiếc, sản phẩm này hiện đã hết hàng!'
                ], 422);
            }
            return redirect()->back()->with('error', 'Sản phẩm này hiện đã hết hàng!');
        }

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            if($cart[$id]['quantity'] + 1 > $product->stock) {
                if (request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bạn đã có ' . $cart[$id]['quantity'] . ' sản phẩm này trong giỏ, không thể thêm nữa vì kho chỉ còn ' . $product->stock . ' sản phẩm!'
                    ], 422);
                }
                return redirect()->back()->with('error', 'Không thể thêm quá số lượng trong kho!');
            }
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $product->name,
                "quantity" => 1,
                "price" => ($product->sale_price > 0) ? $product->sale_price : $product->price,
                "image" => $product->image ?? 'https://via.placeholder.com/100x100?text=' . urlencode($product->name),
                "slug" => $product->slug
            ];
        }

        session()->put('cart', $cart);

        if (request()->ajax()) {
            $totalQuantity = array_sum(array_column($cart, 'quantity'));
            return response()->json([
                'success' => true,
                'cart_count' => $totalQuantity,
                'message' => 'Đã thêm ' . $product->name . ' vào giỏ hàng!'
            ]);
        }

        return redirect()->back()->with('success', 'Đã thêm ' . $product->name . ' vào giỏ hàng!');
    }

    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
        }
    }

    public function update(Request $request)
    {
        if($request->id && $request->quantity)
        {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                $product = Product::find($request->id);
                $newQty = max(1, (int)$request->quantity);

                if($product && $newQty > $product->stock) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Rất tiếc, chỉ còn ' . $product->stock . ' sản phẩm trong kho!',
                        'availableStock' => $product->stock
                    ], 422);
                }

                $cart[$request->id]["quantity"] = $newQty;
                session()->put('cart', $cart);
                
                if($request->ajax()) {
                    // Recalculate totals for real-time response
                    $total = 0;
                    foreach($cart as $id => $details) {
                        $total += $details['price'] * $details['quantity'];
                    }
                    
                    $discount = 0;
                    if(session()->has('coupon')) {
                        $coupon = session()->get('coupon');
                        if($coupon['type'] == 'fixed') {
                            $discount = $coupon['value'];
                        } else {
                            if ($coupon['category_id']) {
                                $discountableAmount = 0;
                                foreach ($cart as $id => $details) {
                                    $p = Product::find($id);
                                    if ($p && $p->category_id == $coupon['category_id']) {
                                        $discountableAmount += $details['price'] * $details['quantity'];
                                    }
                                }
                                $discount = ($discountableAmount * $coupon['value']) / 100;
                            } else {
                                $discount = ($total * $coupon['value']) / 100;
                            }
                        }
                    }
                    
                    $grandTotal = $total - $discount;
                    $itemSubtotal = $cart[$request->id]['price'] * $cart[$request->id]['quantity'];

                    return response()->json([
                        'success' => true,
                        'itemSubtotal' => number_format($itemSubtotal, 0, ',', '.') . ' VNĐ',
                        'total' => number_format($total, 0, ',', '.') . ' VNĐ',
                        'discount' => number_format($discount, 0, ',', '.') . ' VNĐ',
                        'grandTotal' => number_format($grandTotal, 0, ',', '.') . ' VNĐ',
                        'cartCount' => array_sum(array_column($cart, 'quantity'))
                    ]);
                }
            }
        }
        return redirect()->back();
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Đã làm trống giỏ hàng!');
    }
}
