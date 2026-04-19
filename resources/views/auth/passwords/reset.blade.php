@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu - DDH Elite')

@section('content')
<div class="container-fluid p-0 bg-white shadow-none" style="overflow-x: hidden;">
    <div class="row g-0 min-vh-100">
        <!-- SECTION TRÁI: Branding Sidebar (Navy Glass Elite) -->
        <div class="col-md-6 d-none d-md-block position-relative border-0 p-0 overflow-hidden" style="height: 100vh;">
            <!-- Background Mascot -->
            <div style="position: absolute; top:0; left:0; width:100%; height:100%; z-index:1;">
                <img src="{{ asset('images/auth_mascot.png') }}" alt="Mascot" class="w-100 h-100" style="object-fit: cover; object-position: center;">
            </div>
            
            <!-- Branding Overlay (Elite Dynamic Layout) -->
            <div class="position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-between py-5 px-4"
                style="z-index: 2; top: 0; left: 0;">
                <!-- Brand Logo (High Aligned - Flex Mode) -->
                <div class="text-center w-100 mt-2">
                    <a href="{{ url('/') }}" class="hover-opacity-75 d-inline-block">
                        <img src="{{ asset('images/logo.jpg') }}" height="65"
                            style="height: 65px; width: auto; border-radius: 12px; object-fit: contain; box-shadow: 0 10px 30px rgba(0,0,0,0.3);"
                            alt="DDH Elite Logo">
                    </a>
                </div>

                <div style="width: 100%; max-width: 540px;" class="d-flex flex-column align-items-center text-center mb-auto mt-auto">
                    <!-- Elite Glass Card (Navy-Orange Hybrid) -->
                    <div class="benefit-glass-card p-5 rounded-4 shadow-lg w-100 text-white" 
                         style="background: linear-gradient(135deg, rgba(13, 33, 55, 0.9) 0%, rgba(249, 115, 22, 0.25) 100%) !important; backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px); border: 2px solid #f97316 !important;">
                        <div class="mb-4 text-center text-uppercase">
                            <h3 class="fw-bold mb-1">MẬT KHẨU <span class="text-warning">MỚI</span></h3>
                            <p class="text-white-50 small ls-1 fw-bold">BẢO VỆ TƯƠNG LAI CỦA BẠN</p>
                        </div>
                        <div class="text-start">
                            <div class="d-flex align-items-center mb-3 gap-3">
                                <i class="fas fa-shield-cat text-info fs-5"></i>
                                <span class="small">Kết hợp chữ cái, chữ số và ký tự để bảo vệ tài khoản.</span>
                            </div>
                            <div class="d-flex align-items-center mb-0 gap-3">
                                <i class="fas fa-lock text-white fs-5"></i>
                                <span class="small">Tuyệt đối không chia sẻ mật khẩu mới cho bất kỳ ai.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION PHẢI: Reset Password Form -->
        <div class="col-md-6 bg-white d-flex align-items-center justify-content-center py-5 border-0 p-0" style="height: 100vh;">
            <div class="p-4 p-md-5 w-100" style="max-width: 480px;">
                <div class="mb-4 text-center">
                    <h2 class="fw-bold text-dark mb-0">Đặt Lại Mật Khẩu</h2>

                    <!-- Mobile Logo - Sandwich Position 45px -->
                    <div class="text-center mt-2 mb-3 d-md-none">
                        <a href="{{ url('/') }}" class="d-inline-block">
                            <img src="{{ asset('images/logo.jpg') }}" height="45" style="height: 45px; width: auto; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.15);" alt="DDH Elite Logo">
                        </a>
                    </div>

                    <p class="text-muted mb-4 small">Vui lòng thiết lập mật khẩu mới cho tài khoản DDH Elite của bạn.</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-dark text-uppercase ls-1">Email Tài Khoản</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" class="form-control bg-light border-start-0 ps-0 @error('email') is-invalid @enderror" 
                                   name="email" value="{{ $email ?? old('email') }}" required readonly>
                        </div>
                        @error('email')
                            <span class="text-danger small"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="mb-3 text-start">
                        <label for="password" class="form-label small fw-bold text-muted text-uppercase">Mật khẩu mới</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                            <input id="password" type="password" class="form-control border-start-0 border-end-0 ps-0 bg-light py-2 @error('password') is-invalid @enderror" 
                                name="password" required autocomplete="new-password" placeholder="••••••••">
                            <span class="input-group-text bg-light border-start-0 px-3 toggle-password" style="cursor: pointer;">
                                <i class="fas fa-eye text-muted"></i>
                            </span>
                        </div>
                        @error('password')
                            <span class="text-danger small mt-2 d-block"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-4 text-start">
                        <label for="password-confirm" class="form-label small fw-bold text-muted text-uppercase">Xác nhận lại</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="fas fa-check-double text-muted"></i></span>
                            <input id="password-confirm" type="password" class="form-control border-start-0 border-end-0 ps-0 bg-light py-2" 
                                name="password_confirmation" required autocomplete="new-password" placeholder="••••••••">
                            <span class="input-group-text bg-light border-start-0 px-3 toggle-password" style="cursor: pointer;">
                                <i class="fas fa-eye text-muted"></i>
                            </span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid shadow-sm">
                        <button type="submit" class="btn btn-warning fw-bold py-3 shadow-sm rounded-pill text-uppercase text-white"
                            style="background: #f97316; border: none; transition: all 0.3s ease;">
                            CẬP NHẬT MẬT KHẨU <i class="fas fa-sync-alt ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                const input = this.parentElement.querySelector('input');
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });
    </script>

<style>
    /* Reset Layout Defaults */
    main { padding: 0 !important; margin: 0 !important; }
    .footer { margin-top: 0 !important; }
    .container-fluid { max-width: 100% !important; padding: 0 !important; }
    .row { --bs-gutter-x: 0; }

    /* Form Styles */
    .form-control:focus { box-shadow: none; border-color: #dee2e6; background-color: #ffffff !important; }
    .input-group:focus-within .input-group-text, .input-group:focus-within .form-control {
        border-color: #0f172a !important; background-color: #ffffff !important;
    }
    .btn-warning:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important; }
</style>
@endsection
