@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')

@push('styles')

<style>
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    @media (max-width: 991px) {

        .container { padding-top: 2rem !important; }
        .h5, h5 { font-size: 1.1rem; }
    }
    @media (max-width: 767px) {
        .card { padding: 20px !important; }
        .product-img-detail { width: 50px !important; height: 50px !important; margin-right: 15px !important; }
        .product-title-detail { font-size: 13px !important; }
        .product-price-detail { font-size: 15px !important; }
        .total-box-detail { flex-direction: column; text-align: center; gap: 10px; }
        .total-box-detail .h5 { font-size: 14px; }
        .total-box-detail .h4 { font-size: 20px; }
    }
</style>
@endpush

@section('content')
<div class="container py-4 py-md-5">
    <nav class="mb-4">
        <a href="{{ route('account.orders') }}" class="text-decoration-none small text-muted px-3 py-2 bg-white rounded-pill shadow-sm border border-secondary-subtle">
            <i class="fas fa-arrow-left me-1"></i> Quay lại
        </a>
    </nav>

    <div class="row g-4">
        <!-- Cột trái: Thông tin đơn hàng tóm tắt -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4 border-top border-primary border-5">
                <h5 class="fw-bold mb-4 border-bottom pb-3 text-dark text-uppercase"><i class="fas fa-info-circle me-2 text-primary"></i>Hồ sơ đơn hàng</h5>
                <div class="text-dark small">
                    <p class="mb-3 d-flex justify-content-between border-bottom pb-2"><span>Mã đơn:</span> <strong class="text-primary">#DDH-{{ $order->id }}</strong></p>
                    <p class="mb-3 d-flex justify-content-between border-bottom pb-2"><span>Thời gian:</span> <strong>{{ $order->created_at->format('d/m/Y H:i') }}</strong></p>
                    <p class="mb-3 d-flex justify-content-between border-bottom pb-2"><span>Hình thức:</span> <strong class="text-uppercase">{{ $order->payment_method }}</strong></p>
                    <div class="mb-3 border-bottom pb-3">
                        <p class="mb-1 fw-bold"><i class="fas fa-map-marker-alt me-1 text-danger"></i> Địa chỉ nhận hàng:</p>
                        <p class="mb-0 text-muted ms-3">{{ $order->shipping_address }}</p>
                    </div>
                    <p class="mb-0 d-flex justify-content-between"><span>SĐT người nhận:</span> <strong>{{ $order->phone }}</strong></p>
                </div>
                
                @if($order->status === 'pending')
                    <div class="mt-4 pt-3 border-top">
                        <form action="{{ route('account.orders.cancel', $order->id) }}" method="POST" id="cancelOrderFormDetail">
                            @csrf
                            <button type="button" class="btn btn-outline-danger w-100 rounded-pill fw-bold" onclick="confirmCancelOrder()">
                                <i class="fas fa-times-circle me-1"></i> Hủy đơn hàng này
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            @if($order->notes)
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-light bg-opacity-75 border-start border-warning border-5">
                 <p class="fw-bold mb-1 small text-dark"><i class="fas fa-sticky-note me-1"></i> Ghi chú:</p>
                 <p class="mb-0 small text-muted italic">"{{ $order->notes }}"</p>
            </div>
            @endif
        </div>

        <!-- Cột phải: Bảng kê sản phẩm -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white h-100">
                <h5 class="fw-bold mb-4 border-bottom pb-3 text-dark text-uppercase"><i class="fas fa-list me-2 text-primary"></i>Chi tiết sản phẩm</h5>
                <div class="px-md-2">
                    @foreach($order->items as $item)
                    <div class="d-flex align-items-start align-items-md-center mb-4 border-bottom pb-4">
                        <div class="position-relative">
                            <img src="{{ $item->product->image }}" class="rounded-4 shadow-sm me-3 me-md-4 border bg-light product-img-detail" style="width: 80px; height: 80px; object-fit: cover;">
                            <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-dark d-md-none" style="font-size: 9px; padding: 4px 7px;">x{{ $item->quantity }}</span>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <h6 class="fw-bold mb-1 text-dark text-truncate-2 product-title-detail" style="font-size: 15px; line-height: 1.4;">{{ $item->product->name }}</h6>
                            <p class="text-muted small mb-0 d-none d-md-block">{{ $item->quantity }} x {{ number_format($item->price, 0, ',', '.') }} VNĐ</p>
                            <p class="text-muted xx-small mb-0 d-md-none">Đơn giá: {{ number_format($item->price, 0, ',', '.') }} VNĐ</p>
                        </div>
                        <div class="text-end ms-3">
                            <span class="fw-bold text-danger fs-5 product-price-detail">{{ number_format($item->price * $item->quantity, 0, ',', '.') }} VNĐ</span>
                        </div>
                    </div>
                    @endforeach

                </div>
                
                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 p-3 bg-light rounded-4 border total-box-detail">
                    <span class="h5 fw-bold text-dark text-uppercase mb-0">Tổng tất toán:</span>
                    <span class="h4 fw-bold text-danger mb-0">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmCancelOrder() {
        Swal.fire({
            title: 'Xác nhận hủy đơn?',
            text: 'Bạn có chắc chắn muốn hủy đơn hàng này không? Hành động này không thể hoàn tác.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Có, hủy đơn ngay',
            cancelButtonText: 'Quay lại',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-4 shadow-lg border-0',
                confirmButton: 'rounded-pill px-4 fw-bold',
                cancelButton: 'rounded-pill px-4 fw-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('cancelOrderFormDetail').submit();
            }
        });
    }
</script>
@endpush

