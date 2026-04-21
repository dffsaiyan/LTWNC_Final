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
                    'name' => str_replace('+', ' ', $socialUser->name ?? $authUser->name),
                    'provider_id' => $socialUser->id,
                    'provider_name' => $provider,
                    'social_avatar' => $socialUser->avatar,
                ]);
                Auth::login($authUser, true);
            } else {
                // Làm sạch tên trước khi lưu
                $cleanName = str_replace('+', ' ', $socialUser->name ?? $socialUser->nickname ?? 'Elite User ' . $socialUser->id);
                
                // Tạo User mới nếu chưa tồn tại
                $newUser = User::create([
                    'name' => $cleanName,
                    'email' => $userEmail,
                    'provider_id' => $socialUser->id,
                    'provider_name' => $provider,
                    'social_avatar' => $socialUser->avatar,
                    'password' => null, // Không dùng mật khẩu cho Social Login
                ]);
                Auth::login($newUser, true);
            }

            if (session('is_mobile_social')) {
                $user = Auth::user();
                $token = $user->createToken('mobile-app-social')->plainTextToken;
                session()->forget('is_mobile_social');
                
                // Chuẩn bị dữ liệu sạch
                $cleanName = str_replace('+', ' ', $user->name);
                $avatar = $user->social_avatar ?? '';
                
                $query = http_build_query([
                    'token' => $token,
                    'user_id' => $user->id,
                    'name' => $cleanName,
                    'email' => $user->email,
                    'social_avatar' => $avatar,
                    'phone' => $user->phone ?? '',
                    'address' => str_replace('+', ' ', $user->address ?? '')
                ], '', '&', PHP_QUERY_RFC3986);

                return redirect('/mobile-social-success?' . $query);
            }

            return redirect('/')->with('success', 'Chào mừng thành viên Elite! Bạn đã đăng nhập thành công.');
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Social Login Error (Database/Auth): ' . $e->getMessage());
            return redirect('/login')->with('error', 'Lỗi hệ thống khi đăng nhập: ' . $e->getMessage());
        }
    }
}
