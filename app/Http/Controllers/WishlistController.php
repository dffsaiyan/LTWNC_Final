<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle($productId)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập để sử dụng tính năng này.'], 401);
        }

        $user = Auth::user();
        $wishlist = Wishlist::where('user_id', $user->id)->where('product_id', $productId)->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json(['success' => true, 'added' => false, 'message' => 'Đã xóa khỏi danh sách yêu thích.']);
        } else {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId
            ]);
            return response()->json(['success' => true, 'added' => true, 'message' => 'Đã thêm vào danh sách yêu thích!']);
        }
    }

    public function clear()
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập.'], 401);
        }

        Wishlist::where('user_id', Auth::id())->delete();
        return response()->json(['success' => true, 'message' => 'Đã xóa toàn bộ danh sách yêu thích.']);
    }
}
