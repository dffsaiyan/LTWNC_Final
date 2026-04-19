<?php

use Livewire\Volt\Component;
use App\Models\Product;

new class extends Component
{
    public $cart = [];
    public $total = 0;
    public $discount = 0;
    public $grandTotal = 0;

    public function mount()
    {
        $this->refreshCart();
    }

    public function refreshCart()
    {
        $this->cart = session()->get('cart', []);
        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $this->total = 0;
        foreach ($this->cart as $item) {
            $this->total += $item['price'] * $item['quantity'];
        }

        $this->discount = 0;
        if (session()->has('coupon')) {
            $coupon = session()->get('coupon');
            if ($coupon['type'] == 'fixed') {
                $this->discount = $coupon['value'];
            } else {
                if (isset($coupon['category_id']) && $coupon['category_id']) {
                    $discountableAmount = 0;
                    foreach ($this->cart as $id => $details) {
                        $product = Product::find($id);
                        if ($product && $product->category_id == $coupon['category_id']) {
                            $discountableAmount += $details['price'] * $details['quantity'];
                        }
                    }
                    $this->discount = ($discountableAmount * $coupon['value']) / 100;
                } else {
                    $this->discount = ($this->total * $coupon['value']) / 100;
                }
            }
        }

        $this->grandTotal = $this->total - $this->discount;
    }

    public function updateQuantity($id, $quantity)
    {
        $product = Product::find($id);
        $newQty = max(1, (int)$quantity);

        if ($product && $newQty > $product->stock) {
            $this->dispatch('swal:alert', [
                'type' => 'warning',
                'title' => 'Giới hạn kho hàng',
                'text' => 'Rất tiếc, chỉ còn ' . $product->stock . ' sản phẩm trong kho!',
            ]);
            $newQty = $product->stock;
        }

        $this->cart[$id]['quantity'] = $newQty;
        session()->put('cart', $this->cart);
        $this->calculateTotals();
        
        $this->dispatch('cartUpdated');
    }

    public function removeItem($id)
    {
        if (isset($this->cart[$id])) {
            unset($this->cart[$id]);
            session()->put('cart', $this->cart);
            $this->calculateTotals();
            $this->dispatch('cartUpdated');
            
            $this->dispatch('swal:alert', [
                'type' => 'success',
                'title' => 'Đã xóa',
                'text' => 'Sản phẩm đã được gỡ khỏi giỏ hàng.',
            ]);
        }
    }

    public function clearCart()
    {
        session()->forget('cart');
        $this->cart = [];
        $this->total = 0;
        $this->discount = 0;
        $this->grandTotal = 0;
        $this->dispatch('cartUpdated');
        
        $this->dispatch('swal:alert', [
            'type' => 'info',
            'title' => 'Đã làm trống',
            'text' => 'Toàn bộ giỏ hàng đã được xóa sạch.',
        ]);
    }
};
?>

<div>
    <style>
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
            <a href="{{ url('/') }}" class="text-decoration-none text-muted fw-bold text-uppercase hover-orange transition-all d-flex align-items-center gap-2 responsive-header-text" style="letter-spacing: 0.8px;" wire:navigate>
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

    @if(count($cart) > 0)
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
                            <span class="text-dark">{{ count($cart) }}</span> siêu phẩm
                        </span>
                        <a href="javascript:void(0)" wire:click="clearCart" class="text-decoration-none text-muted fw-bold text-uppercase hover-text-danger transition-all d-flex align-items-center gap-2 opacity-75 responsive-action-text" style="letter-spacing: 0.8px; font-size: 13px;">
                            <i class="fas fa-trash-alt text-danger" style="font-size: 13px;"></i> Làm trống
                        </a>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <tbody>
                            @foreach($cart as $id => $details)
                            <tr class="cart-item-row" wire:key="cart-{{ $id }}">
                                <td class="ps-4 py-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="position-relative">
                                            <a href="{{ route('products.show', $details['slug'] ?? '#') }}" wire:navigate>
                                                <img src="{{ $details['image'] }}" class="product-thumb-elite" alt="{{ $details['name'] }}">
                                            </a>
                                            <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-dark shadow-sm" style="font-size: 9px; font-weight: 700;">ELITE</span>
                                        </div>
                                        <div class="d-flex flex-column text-start">
                                            <a href="{{ route('products.show', $details['slug'] ?? '#') }}" class="text-decoration-none" wire:navigate>
                                                <span class="fw-semibold text-dark mb-1 responsive-title d-block hover-text-warning transition-all">{{ $details['name'] }}</span>
                                            </a>
                                            <span class="text-muted xx-small fw-semibold text-uppercase opacity-75 d-none d-md-inline" style="letter-spacing: 1px;">Sản phẩm chính hãng</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 text-center">
                                    <span class="td-label d-md-none">Số lượng:</span>
                                    <div class="qty-control scale-mobile">
                                        <button class="qty-btn" wire:click="updateQuantity({{ $id }}, {{ $details['quantity'] - 1 }})" {{ $details['quantity'] <= 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <span class="qty-value fw-bold text-dark">{{ $details['quantity'] }}</span>
                                        <button class="qty-btn" wire:click="updateQuantity({{ $id }}, {{ $details['quantity'] + 1 }})">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </td>
                                <td class="py-4 text-center">
                                    <span class="td-label d-md-none">Thành tiền:</span>
                                    <span class="fw-semibold text-warning h5 mb-0" style="letter-spacing: -0.5px;">{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }} VNĐ</span>
                                </td>
                                <td class="py-4 pe-4 text-end align-middle">
                                    <button wire:click="removeItem({{ $id }})" class="btn btn-link text-muted p-2 hover-text-danger transition-all border-0 bg-transparent">
                                        <i class="fas fa-trash-alt" style="font-size: clamp(14px, 4vw, 16px);"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-4 p-md-5 bg-white border-top" wire:loading.class="opacity-50">
                    <div class="row g-5">
                        <div class="col-12 text-center">
                            <div class="bg-light rounded-4 p-3 p-md-5 border shadow-sm mx-auto cart-summary-box" style="max-width: 800px;">
                                <div class="form-section-title mb-3 mb-md-4 justify-content-center border-0 p-0 responsive-coupon-title" style="font-size: 18px;">
                                    <i class="fas fa-ticket-alt text-warning"></i> Mã ưu đãi
                                </div>
                                
                                <div class="mx-auto" style="max-width: 500px;">
                                    <div class="elite-input-wrapper text-start mb-2 mb-md-3">
                                        <label class="elite-label">Nhập mã giảm giá của bạn</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control elite-input py-2 py-md-3" style="border-radius: 12px 0 0 12px !important; font-size: 13px;">
                                            <button class="btn btn-dark px-3 px-md-5 fw-bold text-uppercase x-small" type="button" style="border-radius: 0 12px 12px 0 !important;">Áp dụng</button>
                                        </div>
                                    </div>
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
                                        <span class="text-dark">{{ number_format($total, 0, ',', '.') }} VNĐ</span>
                                    </div>
                                    @if($discount > 0)
                                    <div class="d-flex justify-content-between mb-3 text-uppercase x-small fw-bold text-muted">
                                        <span>Giảm giá:</span>
                                        <span class="text-success">-{{ number_format($discount, 0, ',', '.') }} VNĐ</span>
                                    </div>
                                    @endif
                                    
                                    <div class="mt-4 pt-4 border-top text-center">
                                        <div class="mb-4">
                                            <div class="text-dark fw-bold text-uppercase x-small mb-2 opacity-75">SỐ TIỀN CẦN THANH TOÁN:</div>
                                            <div class="text-warning fw-bold responsive-grand-total mb-1" style="font-size: 2.2rem; line-height: 1;">
                                                {{ number_format($grandTotal, 0, ',', '.') }} VNĐ
                                            </div>
                                        </div>
                                        
                                        <div class="mt-5">
                                            <a href="{{ route('checkout.index') }}" class="btn-submit-order w-100 py-3 rounded-4 shadow-lg d-inline-flex align-items-center justify-content-center gap-2 text-decoration-none responsive-checkout-btn" style="letter-spacing: 1px;" wire:navigate>
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
        <a href="{{ url('/') }}" class="btn btn-dark px-4 px-md-5 py-2 py-md-3 rounded-pill fw-bold shadow-lg text-uppercase transition-all hover-scale" style="letter-spacing: 1px; font-size: 0.8rem;" wire:navigate>
            KHÁM PHÁ CỬA HÀNG <i class="fas fa-arrow-right ms-2 text-warning"></i>
        </a>
    </div>
    @endif

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('swal:alert', (data) => {
                const eventData = Array.isArray(data) ? data[0] : data;
                Swal.fire({
                    title: eventData.title,
                    text: eventData.text,
                    icon: eventData.type,
                    confirmButtonColor: '#0f172a',
                    borderRadius: '24px',
                });
            });
        });
    </script>
</div>