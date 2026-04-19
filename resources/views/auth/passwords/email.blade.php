@extends('layouts.app')

@section('title', 'Quên mật khẩu - DDH Elite')

@section('content')
<div class="row g-0 min-vh-100 bg-white" style="margin: 0; padding: 0; width: 100%;">
    <!-- Section bên trái: Sidebar (Navy Glass Elite) -->
    <div class="col-md-6 d-none d-md-block position-relative border-0 shadow-none overflow-hidden" style="height: 100vh;">
        <!-- Background Mascot -->
        <div class="h-100 w-100" style="position: absolute; top: 0; left: 0; z-index: 1;">
            <img src="{{ asset('images/auth_mascot.png') }}" alt="Mascot" class="w-100 h-100" style="object-fit: cover; object-position: center;">
        </div>
        
        <!-- Branding Overlay (Elite Dynamic Layout) -->
        <div class="position-absolute w-100 h-100 d-flex flex-column align-items-center justify-content-between py-5 px-4" style="z-index: 2; top: 0; left: 0;">
            <!-- Brand Logo (High Aligned - Flex Mode) -->
            <div class="text-center w-100 mt-2">
                <a href="{{ url('/') }}" class="hover-opacity-75 d-inline-block">
                    <img src="{{ asset('images/logo.jpg') }}" height="65"
                        style="height: 65px; width: auto; border-radius: 12px; object-fit: contain; box-shadow: 0 10px 30px rgba(0,0,0,0.3);"
                        alt="DDH Elite Logo">
                </a>
            </div>

            <div style="width: 100%; max-width: 520px;" class="d-flex flex-column align-items-center text-center mb-auto mt-auto">
                <!-- Benefits Glass Card (Navy-Orange Hybrid) -->
                <div class="benefit-glass-card p-5 rounded-4 shadow-lg w-100"
                    style="background: linear-gradient(135deg, rgba(13, 33, 55, 0.9) 0%, rgba(249, 115, 22, 0.25) 100%) !important; backdrop-filter: blur(15px); color: white; border: 2px solid #f97316 !important; view-transition-name: auth-glass-card;">
                    <div class="mb-4 text-uppercase">
                        <h3 class="fw-bold mb-1">KHÔI PHỤC <span class="text-warning">MẬT KHẨU</span></h3>
                        <p class="text-white-50 small ls-1 fw-bold">KHÔI PHỤC KỶ NGUYÊN SỐ</p>
                    </div>
                    <div class="text-start">
                        <div class="d-flex align-items-center mb-3 gap-3">
                            <i class="fas fa-envelope-open-text text-warning fs-5"></i>
                            <span class="small">Xác thực an toàn qua Email đã đăng ký.</span>
                        </div>
                        <div class="d-flex align-items-center mb-3 gap-3">
                            <i class="fas fa-shield-halved text-info fs-5"></i>
                            <span class="small">Bảo mật đa lớp, chống xâm nhập trái phép.</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-headset text-success fs-5"></i>
                            <span class="small">Hỗ trợ 24/7 từ tổng đài CSKH DDH.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section bên phải: Form -->
    <div class="col-md-6 d-flex align-items-center justify-content-center py-5 bg-white" style="height: 100vh;">
        <div class="p-4 p-md-5 w-100" style="max-width: 480px;">
            <div class="mb-4 text-center">
                <h2 class="fw-bold text-dark mb-0">Quên Mật Khẩu?</h2>

                <!-- Mobile Logo - Sandwich Position 45px -->
                <div class="text-center mt-2 mb-3 d-md-none">
                    <a href="{{ url('/') }}" class="d-inline-block">
                        <img src="{{ asset('images/logo.jpg') }}" height="45" style="height: 45px; width: auto; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.15);" alt="DDH Elite Logo">
                    </a>
                </div>

                <p class="text-muted mb-4 small">Đừng lo lắng, chúng tôi sẽ giúp bạn lấy lại quyền truy cập vào kỷ nguyên số DDH.</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4 small" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="mt-4">
                @csrf
                <div class="mb-4">
                    <label for="email" class="form-label small fw-bold text-muted text-uppercase">Địa chỉ Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                        <input id="email" type="email" class="form-control border-start-0 ps-0 bg-light py-2 @error('email') is-invalid @enderror" 
                            name="email" value="{{ old('email') }}" required autofocus
                            placeholder="nhapemail@example.com">
                    </div>
                    @error('email')
                        <span class="text-danger small mt-2 d-block"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>

                <div class="d-grid mb-4 shadow-sm">
                    <button type="submit" class="btn btn-dark fw-bold py-2 rounded-pill text-uppercase text-white shadow-sm"
                        style="background: #0f172a; border: none; transition: all 0.3s ease;">
                        GỬI LINK KHÔI PHỤC <i class="fas fa-paper-plane ms-2"></i>
                    </button>
                </div>

                <div class="text-center">
                    <p class="small text-muted mb-0">Nhớ lại mật khẩu? 
                        <a href="{{ route('login') }}" class="fw-bold text-decoration-none ms-1 text-primary">Quay lại đăng nhập</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    main { padding: 0 !important; margin: 0 !important; }
    .footer { display: none !important; }
    .form-control:focus { box-shadow: none; border-color: #dee2e6; background-color: #ffffff !important; }
    .btn-dark:hover { transform: translateY(-3px) scale(1.02); box-shadow: 0 10px 20px rgba(15, 23, 42, 0.2); }
</style>
@endsection
