<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AccountController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth'),
        ];
    }

    public function orders(Request $request)
    {
        $query = Order::where('user_id', Auth::id());

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);
        return view('account.orders', compact('orders'));
    }

    public function showOrder($id)
    {
        $order = Order::with('items.product')->where('user_id', Auth::id())->findOrFail($id);
        return view('account.order_detail', compact('order'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('account.profile', compact('user'));
    }

    public function wishlist()
    {
        $user = Auth::user();
        $wishlist = \App\Models\Wishlist::with('product')->where('user_id', $user->id)->latest()->get();
        return view('account.wishlist', compact('user', 'wishlist'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::find(Auth::id());
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'province_id' => 'nullable|string',
            'district_id' => 'nullable|string',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = urldecode($request->name);
        $user->phone = $request->phone;
        $user->province_id = $request->province_id;
        $user->district_id = $request->district_id;
        $user->address = urldecode($request->address);

        if ($request->hasFile('avatar')) {
            $imageName = time().'.'.$request->avatar->extension();  
            $request->avatar->move(public_path('images/avatars'), $imageName);
            $user->avatar = 'images/avatars/'.$imageName;
        }

        if ($request->new_password) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->with('error', 'Mật khẩu hiện tại không chính xác!');
            }
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    public function cancelOrder($id)
    {
        $order = Order::where('user_id', Auth::id())->findOrFail($id);

        if ($order->status !== 'pending') {
            return back()->with('error', 'Bạn chỉ có thể hủy đơn hàng khi đơn hàng đang ở trạng thái chờ xác nhận!');
        }

        $order->status = 'cancelled';
        $order->save();

        // Notify user
        \App\Models\Notification::create([
            'user_id' => Auth::id(),
            'title' => 'Hủy đơn hàng thành công',
            'message' => "Đơn hàng #{$order->id} của bạn đã được hủy thành công.",
            'link' => route('account.order_detail', $order->id),
            'is_read' => false
        ]);

        return back()->with('success', 'Đơn hàng của bạn đã được hủy thành công!');
    }
}
