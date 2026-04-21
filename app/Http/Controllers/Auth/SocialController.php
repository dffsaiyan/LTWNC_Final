<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class SocialController extends Controller
{
    public function redirectToProvider(Request $request, $provider)
    {
        if ($request->has('mobile')) {
            session(['is_mobile_social' => true]);
        }

        if ($provider == 'google') {
            return Socialite::driver($provider)->with(['prompt' => 'select_account'])->redirect();
        }

        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            // Sử dụng stateless() để tránh lỗi session trên localhost
            $driver = Socialite::driver($provider);
            
            // Tắt verify SSL nếu đang chạy trên localhost để tránh lỗi cURL 60
            if (method_exists($driver, 'setHttpClient')) {
                $driver->setHttpClient(new \GuzzleHttp\Client(['verify' => false]));
            }

            $socialUser = $driver->stateless()->user();
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Social Login Error ({$provider} Handshake): " . $e->getMessage());
            return redirect('/login')->with('error', "Không thể kết nối với " . ucfirst($provider) . ": " . $e->getMessage());
        }

        try {
            // Xử lý email đặc biệt cho Zalo (Zalo đôi khi ẩn email)
            $userEmail = $socialUser->email;
            if (empty($userEmail)) {
                $userEmail = $socialUser->id . '@zalo.ddh-elite.vn';
            }

            // Tìm user theo provider_id HOẶC email
            $authUser = User::where('provider_id', $socialUser->id)
                            ->orWhere('email', $userEmail)
                            ->first();

            if ($authUser) {
                // Cập nhật thông tin mới nhất từ MXH
                $authUser->update([
                    'provider_id' => $socialUser->id,
                    'provider_name' => $provider,
                    'social_avatar' => $socialUser->avatar,
                ]);
                Auth::login($authUser, true);
            } else {
                // Tạo User mới nếu chưa tồn tại
                $newUser = User::create([
                    'name' => $socialUser->name ?? $socialUser->nickname ?? 'Elite User ' . $socialUser->id,
                    'email' => $userEmail,
                    'provider_id' => $socialUser->id,
                    'provider_name' => $provider,
                    'social_avatar' => $socialUser->avatar,
                    'password' => null, // Không dùng mật khẩu cho Social Login
                ]);
                Auth::login($newUser, true);
            }

            if (session('is_mobile_social')) {
                $token = Auth::user()->createToken('mobile-app-social')->plainTextToken;
                session()->forget('is_mobile_social');
                return redirect('/mobile-social-success?token=' . rawurlencode($token) . '&user=' . rawurlencode(json_encode(Auth::user())));
            }

            return redirect('/')->with('success', 'Chào mừng thành viên Elite! Bạn đã đăng nhập thành công.');
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Social Login Error (Database/Auth): ' . $e->getMessage());
            return redirect('/login')->with('error', 'Lỗi hệ thống khi đăng nhập: ' . $e->getMessage());
        }
    }
}
