@extends('layouts.app')

@section('title', 'Giỏ hàng của bạn')

@push('styles')
<style>
    :root {
        --elite-orange: #fbbf24;
        --elite-dark: #0f172a;
        --elite-bg: #f8fafc;
    }

    .cart-stepper {
        position: relative;
        display: flex;
        justify-content: space-between;
        max-width: 600px;
        margin: 0 auto 3rem;
    }

    .step-item {
        position: relative;
        z-index: 2;
        text-align: center;
        flex: 1;
    }

    .step-icon {
        width: 45px;
        height: 45px;
        background: #fff;
        border: 2px solid #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-weight: 600;
        color: #94a3b8;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .step-item.active .step-icon {
        background: var(--elite-dark);
        color: var(--elite-orange);
        border-color: var(--elite-dark);
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.2);
        transform: translateY(-5px);
    }

    .step-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #94a3b8;
    }

    .step-item.active .step-label {
        color: var(--elite-dark);
    }

    .step-line {
        position: absolute;
        top: 22px;
        left: 10%;
        right: 10%;
        height: 2px;
        background: #e2e8f0;
        z-index: 1;
    }

    .cart-item-row {
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(0,0,0,0.03) !important;
    }

    .cart-item-row:hover {
        background-color: #fcfcfc;
    }

    .qty-control {
        display: flex;
        align-items: center;
        background: #f1f5f9;
        border-radius: 50px;
        padding: 4px;
        width: fit-content;
        margin: 0 auto;
    }

    .qty-btn {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: none;
        background: #fff;
        color: var(--elite-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        transition: all 0.2s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }

    .qty-btn:hover:not(:disabled) {
        background: var(--elite-dark);
        color: #fff;
    }

    .qty-value {
        width: 40px;
        display: inline-block;
        text-align: center;
        font-weight: 700;
        font-size: 15px;
        color: var(--elite-dark);
        border: none;
        background: transparent;
        outline: none;
    }
    .qty-value::-webkit-inner-spin-button,
    .qty-value::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .qty-value {
        -moz-appearance: textfield;
    }

    .btn-submit-order {
        background: #0f172a;
        color: #fff;
        border: none;
        padding: 18px 40px;
        font-weight: 700;
        letter-spacing: 1px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(15, 23, 42, 0.2);
    }

    .btn-submit-order:hover {
        background: #1e293b;
        color: #fbbf24;
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(15, 23, 42, 0.3);
    }

    .product-thumb-elite { 
        width: 100px; 
        height: 100px; 
        object-fit: contain; 
        border-radius: 12px;
        transition: transform 0.3s ease;
        padding: 5px;
    }
    
    .elite-input-wrapper { position: relative; }
    .elite-label { font-size: 11px; font-weight: 700; text-transform: uppercase; color: #64748b; letter-spacing: 0.5px; margin-bottom: 8px; display: block; }
    .elite-input { border-radius: 12px; border: 1px solid #e2e8f0; background: #fff; padding: 12px 18px; font-weight: 500; color: #1e293b; transition: all 0.3s ease; }
    .elite-input:focus { border-color: #fbbf24; box-shadow: 0 0 0 4px rgba(251, 191, 36, 0.1); outline: none; }
    
    .form-section-title { font-size: 18px; font-weight: 800; text-transform: uppercase; color: #0f172a; display: flex; align-items: center; gap: 12px; letter-spacing: -0.5px; }
    .form-section-title i { color: #fbbf24; width: 32px; height: 32px; background: #fff; border-radius: 8px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }

    .responsive-grand-total { font-size: 2.2rem; font-weight: 700; letter-spacing: -2px; line-height: 1; }

    .grid-header {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        align-items: center;
    }

    .responsive-header-text {
        transition: all 0.3s ease;
    }
    h1.responsive-header-text {
        font-size: 1.75rem;
    }
    a.responsive-header-text {
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .product-thumb-elite { width: 60px !important; height: 60px !important; }
        .responsive-grand-total { font-size: 1.8rem !important; }
        .grid-header {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 2rem !important;
            text-align: center;
        }
        h1.responsive-header-text {
            font-size: 1.5rem !important;
            letter-spacing: -0.5px !important;
        }
        a.responsive-header-text {
            font-size: 0.85rem !important;
            justify-content: center;
        }
        .responsive-title {
            font-size: 13px !important;
        }
        .cart-item-row { 
            display: block !important;
            padding: 1.25rem !important; 
            margin-bottom: 1.5rem; 
            background: #fff; 
            border-radius: 28px !important;
            border: 1px solid #f1f5f9 !important;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            position: relative;
        }
        .cart-item-row td {
            display: block !important;
            width: 100% !important;
            padding: 0 !important;
            border: none !important;
            text-align: left !important;
        }
        .cart-item-row td:first-child {
            margin-bottom: 12px;
        }
        .cart-item-row td:last-child {
            position: absolute;
            top: 1.5rem;
            right: 1.25rem;
            width: auto !important;
        }
        .qty-control {
            margin: 0 !important;
        }
        .td-label {
            display: inline-block !important;
            font-size: 10px !important;
            font-weight: 800;
            text-transform: uppercase;
            color: #94a3b8;
            letter-spacing: 0.5px;
        }
        .cart-item-row td:nth-child(2),
        .cart-item-row td:nth-child(3) {
            margin-left: 0 !important;
            width: 100% !important;
            display: flex !important;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        .cart-item-row td:nth-child(3) {
            border-top: 1px dashed #f1f5f9 !important;
            padding-top: 10px !important;
            margin-top: 5px;
        }
        .cart-summary-box, .summary-wrapper {
            padding: 1.25rem !important;
            border-radius: 24px !important;
        }
        .form-section-title {
            font-size: 16px !important;
            gap: 8px !important;
        }
        .form-section-title i {
            width: 28px !important;
            height: 28px !important;
            font-size: 14px;
        }
        .responsive-grand-total {
            font-size: 1.6rem !important;
        }
        .btn-submit-order {
            padding: 12px 20px !important;
            border-radius: 15px !important;
        }
        .btn-submit-order span {
            font-size: 13px;
        }
    }
</style>
@endpush

@section('content')
<div class="container py-5 mt-4">
    <!-- PROGRESS STEPPER -->
    <div class="cart-stepper animate-fade-in">
        <div class="step-line"></div>
        <div class="step-item active">
            <div class="step-icon">1</div>
            <div class="step-label">Giỏ hàng</div>
        </div>
        <div class="step-item">
            <div class="step-icon">2</div>
            <div class="step-label">Thông tin</div>
        </div>
        <div class="step-item">
            <div class="step-icon">3</div>
            <div class="step-label">Thanh toán</div>
        </div>
    </div>

    <div class="grid-header mb-4 mb-md-5 animate-fade-in">
        <div class="header-left">
            <a href="{{ url('/') }}" class="text-decoration-none text-muted fw-bold text-uppercase hover-orange transition-all d-flex align-items-center gap-2 responsive-header-text" style="letter-spacing: 0.8px;">
                <i class="fas fa-chevron-left mt-px" style="font-size: 0.8em;"></i> <span>Tiếp tục mua sắm</span>
            </a>
        </div>
        <div class="header-center">
            <div class="d-flex align-items-center gap-2 gap-md-3">
                <div class="bg-warning rounded-pill d-none d-md-block" style="width: 4px; height: 1.2em;"></div>
                <h1 class="fw-bold mb-0 text-uppercase responsive-header-text" style="letter-spacing: -0.2px;">Giỏ hàng của bạn</h1>
            </div>
        </div>
        <div class="header-right d-none d-md-block"></div>
    </div>

    @if(count($cart ?? []) > 0)
    <div class="row">
        <div class="col-12">
            <div class="bg-white rounded-5 shadow-lg border-0 overflow-hidden animate-slide-in-up">
                <div class="px-3 px-md-4 py-4 bg-light border-bottom d-flex justify-content-between align-items-center">
                    <div class="text-muted d-flex align-items-center">
                        <i class="fas fa-shopping-basket text-warning" style="font-size: 18px;"></i>
                        <span class="ms-3 fw-bold text-dark text-uppercase responsive-action-text" style="letter-spacing: 1px; font-size: 14px;">Giỏ hàng của bạn</span>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <span class="x-small fw-bold text-muted text-uppercase d-none d-md-inline" style="letter-spacing: 0.5px;">
                            <span class="text-dark" id="cartTotalItemsCount">{{ count($cart) }}</span> siêu phẩm
                        </span>
                        <a href="{{ route('cart.clear') }}" class="text-decoration-none text-muted fw-bold text-uppercase hover-text-danger transition-all d-flex align-items-center gap-2 opacity-75 responsive-action-text confirm-clear-cart" style="letter-spacing: 0.8px; font-size: 13px;">
                            <i class="fas fa-trash-alt text-danger" style="font-size: 13px;"></i> Làm trống
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <tbody>
                            @foreach($cart as $id => $details)
                            <tr class="cart-item-row" id="cart-item-row-{{ $id }}">
                                <td class="ps-4 py-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="position-relative">
                                            <a href="{{ route('products.show', $details['slug'] ?? '#') }}">
                                                <img src="{{ $details['image'] }}" class="product-thumb-elite" alt="{{ $details['name'] }}">
                                            </a>
                                            <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-dark shadow-sm" style="font-size: 9px; font-weight: 700;">ELITE</span>
                                        </div>
                                        <div class="d-flex flex-column text-start">
                                            <a href="{{ route('products.show', $details['slug'] ?? '#') }}" class="text-decoration-none">
                                                <span class="fw-semibold text-dark mb-1 responsive-title d-block hover-text-warning transition-all">{{ $details['name'] }}</span>
                                            </a>
                                            <span class="text-muted xx-small fw-semibold text-uppercase opacity-75 d-none d-md-inline" style="letter-spacing: 1px;">Sản phẩm chính hãng</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 text-center">
                                    <span class="td-label d-md-none">Số lượng:</span>
                                    <div class="qty-control scale-mobile">
                                        <button class="qty-btn update-cart" data-id="{{ $id }}" data-change="-1">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" value="{{ $details['quantity'] }}" class="qty-value quantity-val-{{ $id }}" readonly min="1" max="100">
                                        <button class="qty-btn update-cart" data-id="{{ $id }}" data-change="1">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="py-4 text-center">
                                    <span class="td-label d-md-none">Thành tiền:</span>
                                    <span class="fw-semibold text-warning h5 mb-0 item-subtotal-{{ $id }}" style="letter-spacing: -0.5px;">{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }} VNĐ</span>
                                </td>
                                <td class="py-4 pe-4 text-end align-middle">
                                    <form action="{{ route('cart.remove') }}" method="POST" class="d-inline-block">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <button type="submit" class="btn btn-link text-muted p-2 hover-text-danger transition-all border-0 bg-transparent">
                                            <i class="fas fa-trash-alt" style="font-size: clamp(14px, 4vw, 16px);"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 p-md-5 bg-white border-top">
                    <div class="row g-5">
                        <div class="col-12 text-center">
                            <div class="bg-light rounded-4 p-3 p-md-5 border shadow-sm mx-auto cart-summary-box" style="max-width: 800px;">
                                <div class="form-section-title mb-3 mb-md-4 justify-content-center border-0 p-0 responsive-coupon-title" style="font-size: 18px;">
                                    <i class="fas fa-ticket-alt text-warning"></i> Mã ưu đãi
                                </div>
                                
                                <div class="mx-auto" style="max-width: 500px;">
                                    <form action="{{ route('coupon.apply') }}" method="POST" class="elite-input-wrapper text-start mb-2 mb-md-3">
                                        @csrf
                                        <label class="elite-label">Nhập mã giảm giá của bạn</label>
                                        <div class="input-group">
                                            <input type="text" name="coupon_code" class="form-control elite-input py-2 py-md-3" style="border-radius: 12px 0 0 12px !important; font-size: 13px;" required>
                                            <button type="submit" class="btn btn-dark px-3 px-md-5 fw-bold text-uppercase x-small" style="border-radius: 0 12px 12px 0 !important;">Áp dụng</button>
                                        </div>
                                    </form>
                                    @if(session('coupon'))
                                        <div class="mt-2 d-flex justify-content-center align-items-center gap-2">
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success p-2 small">Đang dùng mã: {{ session('coupon')['code'] }}</span>
                                            <a href="{{ route('coupon.remove') }}" class="text-danger small fw-bold text-decoration-none">Gỡ bỏ</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="summary-wrapper mx-auto bg-light rounded-4 p-4 p-md-5 border shadow-sm" style="max-width: 800px;">
                                <div class="form-section-title mb-4 justify-content-center border-0 p-0" style="font-size: 18px;">
                                    <i class="fas fa-receipt text-warning"></i> Chi tiết thanh toán
                                </div>

                                <div class="px-md-4">
                                    <div class="d-flex justify-content-between mb-3 text-uppercase x-small fw-bold text-muted">
                                        <span>Tổng giá trị hàng:</span>
                                        <span class="text-dark" id="cartTotal">{{ number_format($total ?? 0, 0, ',', '.') }} VNĐ</span>
                                    </div>
                                    @if($discount > 0)
                                    <div class="d-flex justify-content-between mb-3 text-uppercase x-small fw-bold text-muted">
                                        <span>Giảm giá:</span>
                                        <span class="text-success" id="cartDiscount">-{{ number_format($discount, 0, ',', '.') }} VNĐ</span>
                                    </div>
                                    @endif
                                    
                                    <div class="mt-4 pt-4 border-top text-center">
                                        <div class="mb-4">
                                            <div class="text-dark fw-bold text-uppercase x-small mb-2 opacity-75">SỐ TIỀN CẦN THANH TOÁN:</div>
                                            <div class="text-warning fw-bold responsive-grand-total mb-1 showGrandTotal" style="font-size: 2.2rem; line-height: 1;">
                                                {{ number_format($grandTotal ?? 0, 0, ',', '.') }} VNĐ
                                            </div>
                                        </div>
                                        
                                        <div class="mt-5">
                                            <a href="{{ route('checkout.index') }}" class="btn-submit-order w-100 py-3 rounded-4 shadow-lg d-inline-flex align-items-center justify-content-center gap-2 text-decoration-none responsive-checkout-btn" style="letter-spacing: 1px;">
                                                <span class="fw-bold text-uppercase">Tiến hành thanh toán</span>
                                                <i class="fas fa-chevron-right ms-2"></i>
                                            </a>
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
    @else
    <div class="text-center py-4 py-md-5 bg-white rounded-5 shadow-sm border border-light animate-fade-in-up mx-2 mx-md-0">
        <div class="mb-4 mb-md-5 position-relative d-inline-block">
            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center animate-pulse" style="width: 100px; height: 100px; width: clamp(100px, 30vw, 150px); height: clamp(100px, 30vw, 150px);">
                <i class="fas fa-shopping-cart text-muted opacity-25" style="font-size: clamp(40px, 15vw, 70px);"></i>
            </div>
            <div class="position-absolute bottom-0 end-0 bg-warning rounded-circle p-2 p-md-3 shadow-lg">
                <i class="fas fa-search text-dark fs-6 fs-md-4"></i>
            </div>
        </div>
        <h2 class="fw-bold text-dark text-uppercase px-3" style="letter-spacing: -0.5px; font-size: clamp(18px, 5vw, 28px);">Giỏ hàng đang trống!</h2>
        <p class="text-muted mb-4 mb-md-5 mx-auto px-4" style="max-width: 450px; font-size: clamp(13px, 3.5vw, 16px); line-height: 1.5;">
            Có vẻ như bạn chưa chọn được "vũ khí" nào cho trạm chiến đấu của mình. Hãy quay lại cửa hàng để khám phá ngay.
        </p>
        <a href="{{ url('/') }}" class="btn btn-orange px-4 px-md-5 py-2 py-md-3 rounded-pill fw-bold shadow-lg text-uppercase transition-all hover-scale" style="letter-spacing: 1px; font-size: 0.8rem;">
            KHÁM PHÁ CỬA HÀNG <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
    @endif
</div>

@push('scripts')
<script>
    document.querySelectorAll('.update-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.id;
            const change = parseInt(this.dataset.change);
            const input = document.querySelector(`.quantity-val-${id}`);
            let qty = parseInt(input.value) + change;
            
            if (qty < 1) return;
            
            input.value = qty; // Optimistic update

            fetch('{{ route('cart.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    id: id,
                    quantity: qty
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`.item-subtotal-${id}`).innerText = data.itemSubtotal;
                    document.getElementById('cartTotal').innerText = data.total;
                    if(document.getElementById('cartDiscount')) {
                        document.getElementById('cartDiscount').innerText = "-" + data.discount;
                    }
                    document.querySelectorAll('.showGrandTotal').forEach(el => {
                        el.innerText = data.grandTotal;
                    });
                    
                    const badge = document.getElementById('cartBadgeCount');
                    if (badge && data.cartCount !== undefined) badge.innerText = data.cartCount;
                    
                    if (typeof showEliteToast === 'function') {
                        showEliteToast('Cập nhật giỏ hàng thành công', 'success');
                    }
                } else {
                    if (typeof showEliteToast === 'function') {
                        showEliteToast(data.message, 'error');
                    }
                    input.value = data.availableStock || qty - change; // Revert
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>
@endpush
@endsection
