@extends('layouts.app')

@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container py-4 py-md-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            <div class="card border-0 shadow-lg rounded-5 p-4 p-md-5 bg-white">
                <div class="mb-3 mb-md-4">
                    <div class="icon-success-elite text-success animate__animated animate__zoomIn">
                        <i class="fas fa-check-circle"></i>
                    </div>
                </div>
                <h1 class="fw-bold mb-3 text-dark text-uppercase success-title-elite">Đặt hàng thành công!</h1>
                <div class="mb-4">
                    <p class="text-muted success-subtitle-elite mb-2">Cảm ơn bạn đã tin tưởng <b>DDH Electronics</b>.</p>
                    <div class="d-inline-flex align-items-center gap-2 bg-primary bg-opacity-10 px-4 py-2 rounded-pill border border-primary border-opacity-10">
                        <span class="text-dark small fw-bold">Mã đơn hàng:</span>
                        <span class="text-primary fw-black fs-5" id="orderNumber">#DDH-{{ $order->id }}</span>
                        <button class="btn btn-link p-0 text-primary ms-1 opacity-75 hover-scale" onclick="copyOrderNumber('#DDH-{{ $order->id }}')" title="Sao chép mã">
                            <i class="far fa-copy"></i>
                        </button>
                    </div>
                </div>

                
                <div class="alert alert-light rounded-4 p-3 p-md-4 text-start mb-4 mb-md-5 border border-primary-subtle shadow-sm bg-body">
                    <p class="mb-2 fs-6 fw-bold text-primary"><i class="fas fa-info-circle me-2"></i> Thông tin giao hàng của quý khách:</p>
                    <div class="ms-1 ms-md-4">
                        <p class="mb-1 text-dark small">Người nhận hàng: <strong>{{ Auth::user()->name }}</strong></p>
                        <p class="mb-1 text-dark small">Số điện thoại: <strong>{{ $order->phone }}</strong></p>
                        <p class="mb-1 text-dark small">Địa chỉ giao: <strong>{{ $order->shipping_address }}</strong></p>
                        <p class="mb-0 text-danger small fw-bold mt-2">Tổng tiền: {{ number_format($order->total_price, 0, ',', '.') }} VNĐ</p>
                    </div>
                </div>

                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="/" class="btn btn-orange px-4 px-md-5 py-3 rounded-pill fw-bold text-uppercase shadow-sm">MUA SẮM TIẾP <i class="fas fa-store ms-2"></i></a>
                    <a href="{{ route('account.orders') }}" class="btn btn-outline-primary px-4 px-md-5 py-3 rounded-pill fw-bold text-uppercase">XEM ĐƠN HÀNG <i class="fas fa-box-open ms-2"></i></a>
                </div>
                
                <div class="mt-4 mt-md-5">
                    <p class="text-muted small opacity-75">Mọi thắc mắc xin liên hệ với chúng tôi tại hotline <a href="tel:0337654252" class="text-dark fw-bold text-decoration-none">0337.654.252</a>.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .icon-success-elite {
        font-size: 5rem;
    }
    .success-title-elite {
        font-size: 2rem;
        letter-spacing: 1px;
    }
    .success-subtitle-elite {
        font-size: 1.1rem;
    }
    .fw-black { font-weight: 900 !important; }
    .hover-scale { transition: transform 0.2s ease; }
    .hover-scale:hover { transform: scale(1.2); }
    
    @media (max-width: 767px) {
        .card.rounded-5 { padding: 1.5rem !important; }
        .icon-success-elite { font-size: 3rem; }
        .success-title-elite { font-size: 1.4rem; letter-spacing: 0px; }
        .success-subtitle-elite { font-size: 13px; }
        .d-inline-flex.align-items-center.gap-2 { padding: 8px 15px !important; }
        #orderNumber { font-size: 1rem !important; }
        .btn-orange, .btn-outline-primary { font-size: 11px; padding: 12px 20px !important; }
        .alert.rounded-4 { padding: 1.25rem !important; margin-bottom: 1.5rem !important; }
        .alert.rounded-4 .fs-6 { font-size: 13px !important; }
        .alert.rounded-4 .small { font-size: 11px !important; }
        .ms-md-4 { margin-left: 0.5rem !important; }
        .mt-4.mt-md-5 { margin-top: 1.5rem !important; }
    }
</style>

<script>
    function copyOrderNumber(text) {
        navigator.clipboard.writeText(text).then(() => {
            if(typeof showEliteToast === 'function') {
                showEliteToast('Đã sao chép mã đơn hàng!');
            } else {
                alert('Đã sao chép mã đơn hàng: ' + text);
            }
        }).catch(err => {
            console.error('Không thể sao chép: ', err);
        });
    }

</script>
@endsection


