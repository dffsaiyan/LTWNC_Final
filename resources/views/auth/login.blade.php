@extends('layouts.app')

@section('title', 'Đăng nhập - DDH Elite')

@section('content')
    <div class="container-fluid p-0 bg-white shadow-none">
        <div class="row g-0 min-vh-100 overflow-hidden">
            <!-- Section bên trái -->
            <div class="col-md-6 d-none d-md-block position-relative border-0 p-0 overflow-hidden"
                style="view-transition-name: auth-sidebar; height: 100vh;">
                <!-- Background Mascot (Full Cover Mode - No Whitespace) -->
                <div class="h-100 w-100" style="position: absolute; top: 0; left: 0; z-index: 1;">
                    <img src="{{ asset('images/auth_mascot.png') }}" alt="Mascot Background" class="w-100 h-100"
                        style="object-fit: cover; object-position: center;">
                </div>

                <!-- Central Branding Overlay (Elite Dynamic Layout) -->
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

                    <div style="width: 100%; max-width: 540px;" class="d-flex flex-column align-items-center mb-auto mt-auto">
                        <!-- Benefits Glass Card -->
                        <div class="benefit-glass-card p-5 rounded-4 shadow-lg w-100"
                            style="background: linear-gradient(135deg, rgba(13, 33, 55, 0.9) 0%, rgba(249, 115, 22, 0.25) 100%) !important; backdrop-filter: blur(15px); color: white; border: 2px solid #f97316 !important; view-transition-name: auth-glass-card;">
                            <div class="mb-4 text-center text-uppercase">
                                <h3 class="fw-bold mb-1">ĐẶC QUYỀN <span class="text-warning">DDH-ELITE</span></h3>
                                <p class="text-white-50 small ls-1">Kỷ nguyên công nghệ số</p>
                            </div>
                            <div class="benefit-list">
                                <div class="d-flex align-items-center mb-3 gap-3">
                                    <i class="fas fa-bolt text-warning fs-5"></i>
                                    <span class="small">Giảm trực tiếp 5% cho mọi đơn hàng phụ kiện.</span>
                                </div>
                                <div class="d-flex align-items-center mb-3 gap-3">
                                    <i class="fas fa-truck-fast text-info fs-5"></i>
                                    <span class="small">Miễn phí vận chuyển toàn quốc cho đơn từ 299k.</span>
                                </div>
                                <div class="d-flex align-items-center mb-3 gap-3">
                                    <i class="fas fa-cake-candles text-danger fs-5"></i>
                                    <span class="small">Tặng Voucher 500k trong tháng sinh nhật.</span>
                                </div>
                                <div class="d-flex align-items-center mb-3 gap-3">
                                    <i class="fas fa-arrows-rotate text-success fs-5"></i>
                                    <span class="small">Trợ giá lên đời đến 1.500.000 VNĐ cho thiết bị cũ.</span>
                                </div>
                                <div class="d-flex align-items-center gap-3">
                                    <i class="fas fa-shield-heart text-white fs-5"></i>
                                    <span class="small">Đặc quyền 1 đổi 1 trong 45 ngày đầu tiên.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section bên phải -->
            <div class="col-md-6 bg-white d-flex align-items-center justify-content-center py-5 border-0 p-0"
                style="view-transition-name: auth-content;">
                <div class="p-4 p-md-5 w-100" style="max-width: 480px;">
                    <h2 class="fw-bold text-dark mb-0 text-center">Đăng Nhập</h2>
                    
                    <!-- Mobile Logo - Sandwich Position 45px -->
                    <div class="text-center mt-2 mb-3 d-md-none">
                        <a href="{{ url('/') }}" class="d-inline-block">
                            <img src="{{ asset('images/logo.jpg') }}" height="45" style="height: 45px; width: auto; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.15);" alt="DDH Elite Logo">
                        </a>
                    </div>

                    <p class="text-muted mb-4 text-center small">Chào mừng quay trở lại với kỷ nguyên số DDH</p>

                    <form method="POST" action="{{ route('login') }}" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold small text-muted">EMAIL</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i
                                        class="fas fa-envelope text-muted"></i></span>
                                <input id="email" type="email"
                                    class="form-control border-start-0 ps-0 bg-light py-2 @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="off" autofocus
                                    placeholder="nhapemail@domain.com">
                            </div>
                            @error('email')
                                <span class="text-danger small mt-2 d-flex align-items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label for="password" class="form-label fw-bold small text-muted mb-0">MẬT KHẨU</label>
                                @if (Route::has('password.request'))
                                    <a tabindex="-1" class="small text-decoration-none" href="{{ route('password.request') }}"
                                        style="color: var(--accent-orange);">Quên mật khẩu?</a>
                                @endif
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i
                                        class="fas fa-lock text-muted"></i></span>
                                <input id="password" type="password"
                                    class="form-control border-start-0 border-end-0 ps-0 bg-light py-2 @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password" placeholder="••••••••">
                                <span class="input-group-text bg-light border-start-0 px-3 cursor-pointer toggle-password"
                                    style="cursor: pointer;">
                                    <i class="fas fa-eye text-muted"></i>
                                </span>
                            </div>
                            @error('password')
                                <span class="text-danger small mt-2 d-flex align-items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4 d-flex justify-content-between align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label small" for="remember">Ghi nhớ đăng nhập</label>
                            </div>
                        </div>

                        <div class="d-grid mb-4">
                            <button type="submit" class="btn btn-orange btn-lg py-2 rounded-pill fw-bold fs-6 shadow-sm">
                                <i class="fas fa-sign-in-alt me-2"></i> ĐĂNG NHẬP
                            </button>
                        </div>

                        <!-- Social Login Section -->
                        <div class="text-center mb-4 position-relative">
                            <hr class="text-muted opacity-25">
                            <span
                                class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted divider-text">Hoặc
                                đăng nhập bằng</span>
                        </div>

                        <div class="d-flex gap-4 justify-content-center mb-4">
                            <a href="{{ route('social.login', 'google') }}" class="social-btn" title="Đăng nhập qua Google">
                                <img src="{{ asset('images/google_icon.png') }}" alt="Google" width="32" height="32">
                            </a>
                            <a href="{{ route('social.login', 'zalo') }}" class="social-btn" title="Đăng nhập qua Zalo">
                                <img src="{{ asset('images/zalo_icon.png') }}" alt="Zalo" width="32" height="32">
                            </a>
                        </div>

                        <div class="text-center">
                            <p class="small text-muted mb-0">Bạn chưa có tài khoản?
                                <a href="{{ route('register') }}"
                                    class="fw-bold text-decoration-none ms-1 text-primary">Đăng ký DDH-Elite</a>
                            </p>
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
        main {
            padding: 0 !important;
            margin: 0 !important;
        }

        .footer {
            margin-top: 0 !important;
        }

        .container-fluid {
            max-width: 100% !important;
        }

        .social-btn {
            width: 55px;
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #eee;
            border-radius: 50%;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            background: white;
            text-decoration: none;
        }

        .social-btn:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            border-color: #ddd;
        }

        .social-btn img {
            object-fit: contain;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #dee2e6;
            background-color: #ffffff !important;
        }

        /* Fix input-group focus style with eye icon */
        .input-group:focus-within .input-group-text,
        .input-group:focus-within .form-control {
            border-color: var(--primary-blue) !important;
            background-color: #ffffff !important;
        }

        .input-group:focus-within .input-group-text i {
            color: var(--primary-blue) !important;
        }

        .object-fit-contain {
            object-fit: contain;
        }

        .toggle-password:hover i {
            color: var(--primary-blue) !important;
        }

        .btn-orange,
        .btn-primary {
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
        }

        .btn-orange:hover,
        .btn-primary:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
            filter: brightness(1.1);
        }
        .divider-text {
            font-size: 0.85rem;
            white-space: nowrap;
        }
        
        @media (max-width: 575.98px) {
            .divider-text {
                font-size: 0.75rem !important;
            }
        }
    </style>
@endsection