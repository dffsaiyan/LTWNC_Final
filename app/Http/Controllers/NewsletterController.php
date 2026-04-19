<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Mail\WelcomeNewsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:subscribers,email'
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'email.unique' => 'Email này đã đăng ký nhận tin rồi nhé!'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);
        }

        try {
            // Lưu vào database
            $subscriber = Subscriber::create([
                'email' => $request->email
            ]);

            // Gửi email chào mừng bằng tài khoản cấu hình trong .env (ninja4bom)
            Mail::to($request->email)->send(new WelcomeNewsletter());

            return response()->json([
                'status' => 'success',
                'message' => 'Đăng ký thành công! Hãy kiểm tra hộp thư của bạn.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đã có lỗi xảy ra, vui lòng thử lại sau.'
            ]);
        }
    }
}
