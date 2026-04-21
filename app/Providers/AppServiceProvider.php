<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Ép buộc HTTPS nếu APP_URL cấu hình là https (để fix lỗi Mixed Content trên Ngrok)
        if (str_contains(config('app.url'), 'https://')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        Paginator::useBootstrapFive();
        // Việt hóa Email khôi phục mật khẩu
        ResetPassword::toMailUsing(function ($notifiable, $token) {
            return (new MailMessage)
                ->subject('KHÔI PHỤC MẬT KHẨU - DDH ELECTRONICS')
                ->greeting('Xin chào ' . ($notifiable->name ?? 'Quý khách') . '!')
                ->line('Chúng tôi đã nhận được yêu cầu khôi phục mật khẩu cho tài khoản của bạn tại hệ thống DDH Electronics.')
                ->action('ĐẶT LẠI MẬT KHẨU', url(route('password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
                ->line('Liên kết khôi phục mật khẩu này sẽ hết hạn sau ' . config('auth.passwords.'.config('auth.defaults.passwords').'.expire') . ' phút.')
                ->line('Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email này để đảm bảo an toàn cho tài khoản.')
                ->salutation('Trân trọng, Đội ngũ DDH Electronics');
        });

        // --- ZALO SOCIALITE REGISTRATION ---
        \Illuminate\Support\Facades\Event::listen(
            \SocialiteProviders\Manager\SocialiteWasCalled::class,
            \SocialiteProviders\Zalo\ZaloExtendSocialite::class
        );
    }
}
