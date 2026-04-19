@extends('layouts.app')

@section('title', 'Thanh toán đơn hàng - DDH Electronics')

@push('styles')
    <style>
        :root {
            --elite-orange: #fbbf24;
            --elite-dark: #0f172a;
            --elite-bg: #f8fafc;
        }

        .checkout-stepper {
            position: relative;
            display: flex;
            justify-content: center;
            max-width: 700px;
            margin: 0 auto 3.5rem;
            padding: 0;
        }

        .step-item {
            position: relative;
            z-index: 2;
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .step-icon {
            width: 42px;
            height: 42px;
            background: #fff;
            border: 2px solid #e2e8f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            font-weight: 700;
            font-size: 14px;
            color: #94a3b8;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 2;
        }

        .step-item.active .step-icon {
            background: var(--elite-dark);
            color: var(--elite-orange);
            border-color: var(--elite-dark);
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.15);
            transform: scale(1.1);
        }

        .step-item.completed .step-icon {
            background: #10b981;
            color: white;
            border-color: #10b981;
        }

        .step-label {
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #94a3b8;
            white-space: nowrap;
        }

        .step-item.active .step-label {
            color: var(--elite-dark);
        }

        .step-line {
            position: absolute;
            top: 21px; /* Center of 42px icon */
            left: 15%;
            right: 15%;
            height: 2px;
            background: #e2e8f0;
            z-index: 1;
        }

        .elite-card {
            background: #fff;
            border-radius: 24px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        }

        .elite-card-header {
            background: var(--elite-dark);
            color: #fff;
            padding: 20px 25px;
            position: relative;
        }

        .elite-card-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--elite-orange);
        }

        .form-section-title {
            font-weight: 700;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
            color: var(--elite-dark);
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
        }

        .form-section-title i {
            color: var(--elite-orange);
        }

        .elite-input-wrapper {
            margin-bottom: 20px;
        }

        .elite-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            margin-bottom: 8px;
            display: block;
        }

        .elite-input {
            background: #f1f5f9;
            border: 2px solid transparent;
            border-radius: 14px;
            padding: 12px 18px;
            font-weight: 600;
            font-size: 14px;
            color: var(--elite-dark);
            transition: all 0.3s ease;
        }

        .elite-input:focus {
            background: #fff;
            border-color: var(--elite-orange);
            box-shadow: 0 8px 20px rgba(15, 23, 42, 0.05);
            outline: none;
        }

        .payment-option {
            border: 2px solid #f1f5f9;
            border-radius: 18px;
            padding: 18px;
            cursor: pointer;
            transition: all 0.3s;
            margin-bottom: 12px;
            position: relative;
        }

        .payment-option.active {
            border-color: var(--elite-dark);
            background: #f8fafc;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .payment-radio {
            display: none;
        }

        .custom-check {
            width: 20px;
            height: 20px;
            border: 2px solid #cbd5e1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }

        .payment-option.active .custom-check {
            border-color: var(--elite-orange);
            background: var(--elite-dark);
        }

        .check-inner {
            width: 8px;
            height: 8px;
            background: var(--elite-orange);
            border-radius: 50%;
            transform: scale(0);
            transition: all 0.3s;
        }

        .payment-option.active .check-inner {
            transform: scale(1);
        }

        .summary-card {
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 130px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        }

        .btn-submit-order {
            background: #0f172a;
            color: #fff;
            border: none;
            border-radius: 16px;
            padding: 18px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.2);
            text-decoration: none;
        }

        .btn-submit-order:hover {
            background: #1e293b;
            color: #fbbf24;
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(15, 23, 42, 0.3);
        }

        .product-box {
            background: #f8fafc;
            border-radius: 16px;
            padding: 12px;
            margin-bottom: 12px;
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        /* RESPONSIVE CHECKOUT */
        @media (max-width: 991.98px) {
            .summary-card { position: static; margin-top: 30px; }
            .checkout-stepper { margin-bottom: 2rem; padding: 0 10px; }
        }

        @media (max-width: 768px) {
            .elite-card { border-radius: 20px; }
            .p-4, .p-md-5 { padding: 1.25rem !important; }
            .h1 { font-size: 1.5rem; }
            .h2 { font-size: 1.3rem; }
            .form-section-title { font-size: 13px !important; margin-bottom: 15px !important; letter-spacing: 0.5px !important; }
            .form-section-title i { width: 26px; height: 26px; font-size: 11px; }
            
            .elite-review-item { gap: 12px !important; padding: 12px !important; border-radius: 12px !important; }
            .elite-review-item .product-img-wrapper { width: 55px !important; height: 55px !important; }
            .elite-review-item .h6 { font-size: 12px !important; }
            .elite-review-item .h5 { font-size: 14px !important; }
            
            .payment-option { padding: 12px !important; border-radius: 14px !important; }
            .payment-option .fw-bold.small { font-size: 12px !important; }
            .payment-option .small.text-muted { font-size: 10px !important; }
            .payment-option i.fs-2 { font-size: 1.2rem !important; }
            .payment-option img { height: 18px !important; }

            .grand-total-display { font-size: 1.8rem !important; }
            .final-summary-box { padding: 25px 15px !important; }
            .btn-submit-order { padding: 14px !important; font-size: 14px !important; }
            #shippingFeeText { font-size: 11px !important; }
        }

        @media (max-width: 576px) {
            .elite-card { border-radius: 16px; }
            .p-4, .p-md-5 { padding: 1rem !important; }
            .elite-review-item .flex-grow-1 { min-width: 0; width: 100%; }
            .elite-review-item .d-flex.justify-content-between { 
                flex-direction: column !important; 
                align-items: flex-start !important; 
                gap: 2px !important; 
            }
            .elite-review-item .h6 { 
                font-size: 11px !important;
                line-height: 1.3;
                margin-bottom: 1px !important;
            }
            .elite-review-item .h5 { font-size: 13px !important; margin-top: 1px; }
            .grand-total-display { font-size: 1.5rem !important; }
            .btn-submit-order { font-size: 13px !important; padding: 12px !important; }
            .form-section-title { font-size: 12px !important; }
        }

        @media (max-width: 480px) {
            .step-label { display: none; }
            .checkout-stepper { max-width: 280px; margin-bottom: 1.5rem; }
            .step-line { top: 17px; left: 20%; right: 20%; }
            .step-icon { width: 34px; height: 34px; font-size: 12px; }
            .step-line { top: 17px; }
        }
        /* Custom Tom Select Styling */
        .ts-control {
            border: 2px solid rgba(0,0,0,0.05) !important;
            border-radius: 12px !important;
            padding: 12px 15px !important;
            font-size: 0.875rem !important;
            background-color: #fff !important;
            transition: all 0.3s ease !important;
            box-shadow: none !important;
            height: auto !important;
            min-height: 50px !important;
            display: flex !important;
            align-items: center !important;
        }
        .ts-wrapper.focus .ts-control {
            border-color: #ffc107 !important;
            box-shadow: 0 0 0 4px rgba(255, 193, 7, 0.1) !important;
        }
        .ts-dropdown {
            border-radius: 12px !important;
            border: 1px solid rgba(0,0,0,0.1) !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
            padding: 5px !important;
            margin-top: 5px !important;
        }
        .ts-dropdown .active {
            background-color: #fff9e6 !important;
            color: #856404 !important;
            border-radius: 8px !important;
        }
        .ts-control .item {
            font-weight: 500 !important;
            color: #333 !important;
        }
        .ts-wrapper.disabled .ts-control {
            background-color: #f8f9fa !important;
            opacity: 0.7 !important;
        }
    </style>
    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="container py-5 mt-4">
        <!-- PROGRESS STEPPER -->
        <div class="checkout-stepper animate-fade-in">
            <div class="step-line"></div>
            <div class="step-item completed">
                <div class="step-icon"><i class="fas fa-check"></i></div>
                <div class="step-label">Giỏ hàng</div>
            </div>
            <div class="step-item active">
                <div class="step-icon">2</div>
                <div class="step-label">Thông tin</div>
            </div>
            <div class="step-item">
                <div class="step-icon">3</div>
                <div class="step-label">Thanh toán</div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-center gap-3 mb-5 animate-fade-in">
            <div class="bg-warning rounded-pill" style="width: 8px; height: 40px;"></div>
            <div>
                <h1 class="fw-semibold mb-0 text-uppercase h2" style="letter-spacing: -1px;">Thanh toán đơn hàng</h1>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-4 p-3 mb-4 animate-fade-in" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="fas fa-exclamation-circle text-danger fs-4"></i>
                    <span class="fw-semibold">{{ session('error') }}</span>
                </div>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    
                    <!-- BƯỚC 2: THÔNG TIN NHẬN HÀNG -->
                    <div id="step2_content" class="animate-fade-in">
                        <div class="elite-card border-0 shadow-lg p-4 p-md-5 mb-5">
                            <div class="form-section-title mb-4">
                                <i class="fas fa-id-card"></i> 1. Thông tin nhận hàng
                            </div>
                            <div class="row g-3">
                                <div class="col-md-6 elite-input-wrapper">
                                    <label class="elite-label">Họ tên người nhận <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control elite-input" 
                                        placeholder="Nguyễn Văn A" value="{{ old('name', Auth::user()->name) }}" required>
                                </div>
                                <div class="col-md-6 elite-input-wrapper">
                                    <label class="elite-label">Số điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" name="phone" id="phone" class="form-control elite-input" 
                                        placeholder="09xx xxx xxx" value="{{ old('phone', Auth::user()->phone) }}" required>
                                </div>
                                <div class="col-12 elite-input-wrapper">
                                    <label class="elite-label">Email xác nhận <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control elite-input" 
                                        placeholder="email@example.com" value="{{ old('email', Auth::user()->email) }}" required>
                                </div>
                                <div class="col-md-6 elite-input-wrapper">
                                    <label class="elite-label">Tỉnh / Thành phố <span class="text-danger">*</span></label>
                                    <select name="province" id="province" class="form-select elite-input" required>
                                        <option value="">Chọn Tỉnh/Thành phố</option>
                                    </select>
                                </div>
                                <div class="col-md-6 elite-input-wrapper">
                                    <label class="elite-label">Xã / Phường / Thị trấn <span class="text-danger">*</span></label>
                                    <select name="district" id="district" class="form-select elite-input" required>
                                        <option value="">Chọn Xã/Phường</option>
                                    </select>
                                </div>
                                <div class="col-12 elite-input-wrapper">
                                    <label class="elite-label">Địa chỉ cụ thể <span class="text-danger">*</span></label>
                                    <textarea name="shipping_address" id="shipping_address" class="form-control elite-input" rows="2" placeholder="Số nhà, tên đường..." required>{{ old('shipping_address', Auth::user()->address) }}</textarea>
                                </div>
                            </div>

                            <!-- Validation Error Message -->
                            <div id="validation-error-banner" class="mt-4 d-none animate-fade-in">
                                <div class="alert alert-danger border-0 shadow-sm rounded-4 p-3 d-flex align-items-center gap-3">
                                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow-sm flex-shrink-0" style="width: 32px; height: 32px;">
                                        <i class="fas fa-exclamation-triangle text-danger"></i>
                                    </div>
                                    <span class="small fw-bold text-nowrap">Vui lòng điền đầy đủ thông tin có dấu <span class="text-danger">*</span></span>
                                </div>
                            </div>

                            <!-- MỚI: BẢNG TÍNH TIỀN NGAY DƯỚI FORM -->
                            <div class="mt-5">
                                <div class="p-4 rounded-4 bg-light border shadow-sm">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted fw-bold small text-uppercase">Tạm tính:</span>
                                        <span class="fw-bold text-dark">1.400.000 VNĐ</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-3">
                                        <span class="text-muted fw-bold small text-uppercase">Phí ship:</span>
                                        <span class="fw-bold text-uppercase text-info" id="shippingFeeText">Vui lòng chọn Tỉnh</span>
                                        <input type="hidden" id="shippingFeeValue" value="0">
                                    </div>
                                    <hr class="my-4 opacity-10">
                                    <div class="mb-3 text-center">
                                        <div class="fw-bold text-dark text-uppercase small mb-2">Tổng tiền thanh toán:</div>
                                        <div class="h2 fw-bold text-warning mb-0" id="grandTotalText">1.400.000 VNĐ</div>
                                        <input type="hidden" id="rawTotal" value="1400000">
                                    </div>
                                    
                                    <button type="button" onclick="validateAndGoToStep3()" class="btn-submit-order w-100 py-3 shadow-lg d-inline-flex align-items-center justify-content-center gap-2 text-decoration-none" style="font-size: 16px; letter-spacing: 1px;">
                                        <span class="fw-bold text-uppercase">Tiếp tục đến thanh toán</span>
                                        <i class="fas fa-chevron-right ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BƯỚC 3: THANH TOÁN & XÁC NHẬN -->
                    <div id="step3_content" class="animate-fade-in d-none">
                        <div class="elite-card border-0 shadow-lg mb-5 overflow-hidden">
                            <!-- 2. KIỂM TRA ĐƠN HÀNG -->
                            <div class="p-4 p-md-5" style="background-color: #fafafa;">
                                <div class="row g-3 justify-content-center">
                                    <div class="col-12 col-xl-10">
                                        <div class="form-section-title mb-4">
                                            <i class="fas fa-shopping-basket me-2"></i> 2. Kiểm tra đơn hàng
                                        </div>
                                    </div>

                                    @foreach($cart as $id => $details)
                                        <div class="col-12 col-xl-10">
                                            <div class="elite-review-item d-flex align-items-center gap-4 p-3 bg-white rounded-4 shadow-sm transition hover-lift">
                                                <div class="position-relative flex-shrink-0">
                                                    <div class="product-img-wrapper rounded-3 overflow-hidden" style="width: 70px; height: 70px; background: #f8f8f8;">
                                                        <img src="{{ $details['image'] }}" class="w-100 h-100 object-fit-cover">
                                                    </div>
                                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-dark text-white shadow-sm fw-bold" 
                                                          style="width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; font-size: 11px; z-index: 2; border: 2px solid #fff;">
                                                        {{ $details['quantity'] }}
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1 min-width-0">
                                                    <div class="d-flex justify-content-between align-items-center gap-3">
                                                        <div class="fw-bold text-dark h6 mb-0" style="letter-spacing: -0.3px;">{{ $details['name'] }}</div>
                                                        <div class="fw-black text-warning h5 mb-0 flex-shrink-0">
                                                            {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }} VNĐ
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div style="height: 1px; background: linear-gradient(to right, transparent, rgba(0,0,0,0.05), transparent);"></div>

                            <div class="p-4 p-md-5">
                                <div class="row g-4 justify-content-center">
                                    <div class="col-12 col-xl-10">
                                        <div class="row g-4">
                                            <div class="col-12">
                                                <div class="form-section-title mb-4">
                                                    <i class="fas fa-wallet"></i> 3. Chọn phương thức thanh toán
                                                </div>
                                                
                                                <div class="row g-3">
                                                    <div class="col-12">
                                                        <div class="payment-option active" onclick="selectPayment('cod')">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="custom-check flex-shrink-0"><div class="check-inner"></div></div>
                                                                    <input type="radio" name="payment_method" value="cod" id="pay_cod" class="payment-radio" checked>
                                                                    <div>
                                                                        <div class="fw-bold text-dark small">Thanh toán (COD)</div>
                                                                        <div class="small text-muted fw-semibold">Trả tiền khi nhận hàng</div>
                                                                    </div>
                                                                </div>
                                                                <i class="fas fa-hand-holding-dollar fs-2 text-warning opacity-25"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="payment-option" onclick="selectPayment('vnpay')">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="custom-check flex-shrink-0"><div class="check-inner"></div></div>
                                                                    <input type="radio" name="payment_method" value="vnpay" id="pay_vnpay" class="payment-radio">
                                                                    <div>
                                                                        <div class="fw-bold text-dark small">VNPay</div>
                                                                        <div class="small text-muted fw-semibold">Cổng thanh toán thẻ nội địa, Quốc tế, QR Code</div>
                                                                    </div>
                                                                </div>
                                                                <img src="{{ asset('images/vnpay-logo.png') }}" style="height: 25px; width: auto;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="payment-option" onclick="selectPayment('momo')">
                                                            <div class="d-flex align-items-center justify-content-between">
                                                                <div class="d-flex align-items-center gap-3">
                                                                    <div class="custom-check flex-shrink-0"><div class="check-inner"></div></div>
                                                                    <input type="radio" name="payment_method" value="momo" id="pay_momo" class="payment-radio">
                                                                    <div>
                                                                        <div class="fw-bold text-dark small">Ví MoMo</div>
                                                                        <div class="small text-muted fw-semibold">Thanh toán nhanh qua ứng dụng MoMo</div>
                                                                    </div>
                                                                </div>
                                                                <img src="{{ asset('images/MOMO-Logo-App.png') }}" class="rounded shadow-sm" style="height: 35px; width: auto;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-4">
                                                <!-- TÓM TẮT THANH TOÁN CUỐI CÙNG (DÀN HÀNG DỌC) -->
                                                <div class="final-summary-box p-4 p-md-5 rounded-4 bg-light border shadow-sm text-center">
                                                    <div class="mb-3 mb-md-4">
                                                        <div class="fw-bold text-dark text-uppercase x-small mb-2 opacity-75">SỐ TIỀN CẦN THANH TOÁN CUỐI CÙNG:</div>
                                                        <div class="h1 fw-bold text-warning mb-0 grand-total-display">0 VNĐ</div>
                                                    </div>
                                                    
                                                    <div class="mx-auto" style="max-width: 500px;">
                                                        <button type="submit" class="btn-submit-order w-100 py-3 shadow-lg border-0 h-100 d-inline-flex align-items-center justify-content-center gap-2 text-decoration-none" style="font-size: 16px; letter-spacing: 1px;">
                                                            <i class="fas fa-check-circle"></i> 
                                                            <span class="fw-bold text-uppercase">XÁC NHẬN ĐẶT HÀNG</span>
                                                        </button>
                                                        
                                                        <button type="button" onclick="backToStep2()" class="btn btn-link text-decoration-none xx-small text-muted fw-bold text-uppercase mt-4 hover-orange w-100" style="letter-spacing: 0.5px;">
                                                            <i class="fas fa-undo me-1"></i> Quay lại sửa thông tin
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <!-- Tom Select JS -->
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        <script>
            function initCheckoutScripts() {
                // Ensure form and components exist
                const checkoutForm = document.getElementById('checkoutForm');
                if (!checkoutForm) return;

                console.log('⚡ Initializing Checkout Scripts...');

                // Dữ liệu từ trang cá nhân
                const userProfile = {
                    name: @json(Auth::user()->name),
                    phone: @json(Auth::user()->phone),
                    email: @json(Auth::user()->email),
                    province_id: @json(Auth::user()->province_id),
                    district_id: @json(Auth::user()->district_id),
                    address: @json(Auth::user()->address)
                };

                const stepItems = document.querySelectorAll('.step-item');
                const step2Content = document.getElementById('step2_content');
                const step3Content = document.getElementById('step3_content');

                // Clear session data on success
                checkoutForm.addEventListener('submit', function() {
                    sessionStorage.removeItem('elite_checkout_data');
                });

                // --- TOM SELECT INITIALIZATION ---
                // Destroy existing instances if they exist to prevent duplicates
                if (window.provinceTS) window.provinceTS.destroy();
                if (window.districtTS) window.districtTS.destroy();

                window.provinceTS = new TomSelect('#province', {
                    valueField: 'value',
                    labelField: 'text',
                    searchField: 'text',
                    create: false,
                    placeholder: 'Tìm kiếm Tỉnh/Thành...',
                    allowEmptyOption: false,
                });

                window.districtTS = new TomSelect('#district', {
                    valueField: 'value',
                    labelField: 'text',
                    searchField: 'text',
                    create: false,
                    placeholder: 'Tìm kiếm Xã/Phường/Thị trấn...',
                    allowEmptyOption: false,
                    openOnFocus: true,
                    maxOptions: 500,
                });

                // --- PERSISTENCE LOGIC ---
                const STORAGE_KEY = 'elite_checkout_data';
                
                function saveFormData() {
                    const data = {
                        name: document.getElementById('name').value,
                        phone: document.getElementById('phone').value,
                        email: document.getElementById('email').value,
                        province: window.provinceTS.getValue(),
                        district: window.districtTS.getValue(),
                        address: document.getElementById('shipping_address').value,
                        payment: document.querySelector('input[name="payment_method"]:checked')?.value || 'cod'
                    };
                    sessionStorage.setItem(STORAGE_KEY, JSON.stringify(data));
                }

                // Listen for changes
                document.querySelectorAll('.elite-input').forEach(input => {
                    input.addEventListener('input', saveFormData);
                    input.addEventListener('change', saveFormData);
                });
                window.provinceTS.on('change', saveFormData);
                window.districtTS.on('change', saveFormData);

                function loadFormData() {
                    const saved = sessionStorage.getItem(STORAGE_KEY);
                    let data = {};
                    
                    if (saved) {
                        data = JSON.parse(saved);
                    } else {
                        data = {
                            name: userProfile.name,
                            phone: userProfile.phone,
                            email: userProfile.email,
                            province: userProfile.province_id,
                            district: userProfile.district_id,
                            address: userProfile.address,
                            payment: 'cod'
                        };
                    }
                    
                    if (data.name) document.getElementById('name').value = data.name;
                    if (data.phone) document.getElementById('phone').value = data.phone;
                    if (data.email) document.getElementById('email').value = data.email;
                    if (data.address) document.getElementById('shipping_address').value = data.address;
                    
                    if (data.province) {
                        window.provinceTS.setValue(data.province);
                        setTimeout(() => {
                            if (data.district) window.districtTS.setValue(data.district);
                        }, 800); 
                    }
                    
                    if (data.payment) selectPayment(data.payment);
                }

                // Attach functions to window for global access (since they are in a function scope now)
                window.validateAndGoToStep3 = function() {
                    const fields = ['name', 'phone', 'email', 'province', 'district', 'shipping_address'];
                    let isValid = true;
                    const errorBanner = document.getElementById('validation-error-banner');
                    
                    document.querySelectorAll('.elite-input, .ts-control').forEach(el => {
                        el.style.borderColor = '';
                    });

                    fields.forEach(f => {
                        const el = document.getElementById(f);
                        let val = '';
                        let targetEl = el;

                        if (f === 'province') {
                            val = window.provinceTS.getValue();
                            targetEl = document.querySelector('#province').nextElementSibling.querySelector('.ts-control');
                        } else if (f === 'district') {
                            val = window.districtTS.getValue();
                            targetEl = document.querySelector('#district').nextElementSibling.querySelector('.ts-control');
                        } else {
                            val = el.value.trim();
                        }

                        if (!val) {
                            isValid = false;
                            if (targetEl) {
                                targetEl.style.borderColor = '#dc3545';
                                targetEl.classList.add('animate-shake');
                                setTimeout(() => targetEl.classList.remove('animate-shake'), 500);
                            }
                        }
                    });

                    if(!isValid) {
                        errorBanner.classList.remove('d-none');
                        errorBanner.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        return;
                    } else {
                        errorBanner.classList.add('d-none');
                    }

                    step2Content.classList.add('d-none');
                    step3Content.classList.remove('d-none');
                    stepItems[1].classList.remove('active');
                    stepItems[1].classList.add('completed');
                    stepItems[1].querySelector('.step-icon').innerHTML = '<i class="fas fa-check"></i>';
                    stepItems[2].classList.add('active');
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                };

                window.backToStep2 = function() {
                    step2Content.classList.remove('d-none');
                    step3Content.classList.add('d-none');
                    stepItems[1].classList.add('active');
                    stepItems[1].classList.remove('completed');
                    stepItems[1].querySelector('.step-icon').innerHTML = '2';
                    stepItems[2].classList.remove('active');
                };

                window.selectPayment = function(id) {
                    document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('active'));
                    const option = document.getElementById('pay_' + id).closest('.payment-option');
                    if (option) option.classList.add('active');
                    document.getElementById('pay_' + id).checked = true;
                };

                // --- PROVINCE API HANDLER ---
                const shippingFeeText = document.getElementById('shippingFeeText');
                const grandTotalText = document.getElementById('grandTotalText');
                const rawTotalInput = document.getElementById('rawTotal');
                const rawTotal = rawTotalInput ? parseInt(rawTotalInput.value) : 0;

                window.provinceTS.on('change', function(pCode) {
                    window.districtTS.clear();
                    window.districtTS.clearOptions();
                    
                    if(!pCode) {
                        window.districtTS.disable();
                        updateShippingFee(0, "Đang tính...");
                        return;
                    }

                    window.districtTS.enable();
                    const pItem = window.provinceTS.getItem(pCode);
                    const pName = pItem ? pItem.innerText : "";
                    
                    if(pName.includes("Hà Nội") || pCode == "1") { 
                        updateShippingFee(0, "Miễn phí (Hà Nội)"); 
                    } else { 
                        updateShippingFee(30000, "30.000 VNĐ"); 
                    }

                    fetch(`https://provinces.open-api.vn/api/v2/w/?province=${pCode}`)
                        .then(res => res.json())
                        .then(data => {
                            const subdivisions = Array.isArray(data) ? data : (data.wards || []);
                            subdivisions.forEach(d => {
                                window.districtTS.addOption({value: d.name, text: d.name});
                            });
                            window.districtTS.refreshOptions(false);
                            
                            const saved = sessionStorage.getItem(STORAGE_KEY);
                            if (saved) {
                                const data = JSON.parse(saved);
                                if (data.district) window.districtTS.setValue(data.district);
                            }
                        });
                });

                function updateShippingFee(fee, text) {
                    if (shippingFeeText) shippingFeeText.innerText = text;
                    const total = rawTotal + fee;
                    const formatted = new Intl.NumberFormat('vi-VN').format(total) + ' VNĐ';
                    
                    if (grandTotalText) grandTotalText.innerText = formatted;
                    document.querySelectorAll('.grand-total-display').forEach(el => {
                        el.innerText = formatted;
                    });
                }

                // --- INITIAL FETCH ---
                fetch('https://provinces.open-api.vn/api/v2/p/')
                    .then(res => res.json())
                    .then(provinces => {
                        provinces.forEach(p => {
                            window.provinceTS.addOption({value: p.code, text: p.name});
                        });
                        loadFormData();
                    });

                updateShippingFee(0, "Vui lòng chọn Tỉnh");
            }

            // --- EXECUTION ---
            document.addEventListener('DOMContentLoaded', initCheckoutScripts);
        </script>

    @endpush
@endsection