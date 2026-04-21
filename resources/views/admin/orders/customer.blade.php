@extends('layouts.admin')
@section('page-icon', 'images/icon/invoice_icon.webp')
@section('page-title', 'Danh sách Đơn hàng')

@push('styles')
<style>
    /* Premium Dropdown Elite */
    .dropdown-status-elite .btn-status {
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-size: 10px;
        padding: 8px 16px;
        border-radius: 100px;
        border: 2px solid transparent;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 160px; /* Fixed width for uniform look */
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .dropdown-status-elite .btn-status::after {
        display: none !important; /* Force hide default arrow */
    }
    .dropdown-status-elite .btn-status:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        filter: brightness(0.95);
    }
    .dropdown-status-elite {
        position: relative;
    }
    /* Đảm bảo Card chứa dropdown đang mở luôn nằm trên cùng */
    .card:has(.dropdown-toggle.show) {
        z-index: 1050 !important;
    }
    
    @media (max-width: 576px) {
        /* Hiệu ứng nền mờ (Backdrop) */
        .dropdown-status-elite:has(.dropdown-menu.show)::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.4); /* Navy dark overlay */
            backdrop-filter: blur(4px);
            z-index: 1050;
            animation: fadeIn 0.3s ease;
        }
    }

    .dropdown-status-elite .dropdown-menu {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        padding: 8px;
        z-index: 9999 !important;
        width: 100%;
        min-width: 160px;
        animation: slideDown 0.3s ease-out;
        border: 1px solid rgba(0,0,0,0.05);
    }

    /* 📱 ELITE BOTTOM SHEET FOR MOBILE */
    @media (max-width: 576px) {
        .dropdown-status-elite .dropdown-menu.show {
            position: fixed !important;
            bottom: 0 !important;
            top: auto !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            transform: none !important;
            border-radius: 25px 25px 0 0 !important;
            padding: 25px 20px !important;
            z-index: 1060 !important;
            box-shadow: 0 -10px 40px rgba(0,0,0,0.15) !important;
            animation: slideUpMobile 0.4s cubic-bezier(0, 0.55, 0.45, 1) !important;
        }

        /* Xóa bỏ backdrop cũ trên menu */
        .dropdown-status-elite .dropdown-menu.show::before {
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.5); /* Navy dark overlay */
            backdrop-filter: blur(4px);
            z-index: -1;
            pointer-events: none; /* Cho phép click xuyên qua để Bootstrap đóng menu */
        }

        .dropdown-status-elite .dropdown-item {
            padding: 15px 20px !important; /* To hơn để dễ chạm trên mobile */
            font-size: 14px !important;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .dropdown-status-elite .dropdown-item:last-child {
            border-bottom: none;
        }

        /* Thanh kéo (Handle bar) */
        .dropdown-status-elite .dropdown-menu.show::after {
            content: '';
            position: absolute;
            top: 10px;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 5px;
            background: #e2e8f0;
            border-radius: 10px;
        }
    }

    @keyframes slideUpMobile {
        from { transform: translateY(100%); }
        to { transform: translateY(0); }
    }

    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .dropdown-status-elite .dropdown-item {
        border-radius: 12px;
        padding: 10px 15px;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 10px;
        transition: all 0.2s;
        color: #475569;
        margin-bottom: 2px;
    }
    .dropdown-status-elite .dropdown-item i {
        font-size: 14px;
        width: 20px;
        text-align: center;
    }
    .dropdown-status-elite .dropdown-item:hover {
        background-color: #f8fafc;
        transform: translateX(5px);
    }
    
    /* Status Colors */
    .status-btn-pending { background: #fffbeb; color: #b45309; border-color: #fde68a !important; }
    .status-btn-processing { background: #eef2ff; color: #3730a3; border-color: #c7d2fe !important; }
    .status-btn-shipping { background: #ecfeff; color: #0891b2; border-color: #a5f3fc !important; }
    .status-btn-completed { background: #f0fdf4; color: #15803d; border-color: #bbf7d0 !important; }
    .status-btn-cancelled { background: #fef2f2; color: #b91c1c; border-color: #fecaca !important; }

    .dropdown-item.active-status {
        background: #f1f5f9;
        color: #0f172a;
        pointer-events: none;
    }
    
    .btn-status:disabled {
        opacity: 0.8;
        cursor: not-allowed;
    }

    /* Static Status Badge Elite */
    .status-badge-elite {
        width: 125px;
        padding: 8px 12px !important;
        font-size: 10px !important;
        font-weight: 700 !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-block;
        text-align: center;
        border-radius: 100px !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-0">
    <!-- Header -->
    <div class="d-flex align-items-start gap-2 gap-md-3 mb-4 animate-in">
        <a href="{{ route('admin.orders') }}" class="btn btn-white btn-sm rounded-circle shadow-sm border mt-1" style="width: 32px; height: 32px; flex-shrink: 0; display: inline-flex; align-items: center; justify-content: center;">
            <i class="fas fa-arrow-left text-muted" style="font-size: 12px;"></i>
        </a>
        <div style="min-width: 0;">
            <h5 class="fw-bold mb-1 text-wrap" style="font-size: clamp(1rem, 4vw, 1.25rem); line-height: 1.4;">Đơn hàng của {{ $customer->name }}</h5>
            <div class="d-flex flex-wrap gap-2 mt-2">
                <span class="badge bg-soft-primary text-primary border border-primary-subtle px-2 py-1-5 small">
                    <i class="fas fa-shopping-cart me-1"></i> {{ $orders->total() }} Đơn
                </span>
                <span class="badge bg-soft-success text-success border border-success-subtle px-2 py-1-5 small">
                    <i class="fas fa-wallet me-1"></i> Tổng: {{ number_format($orders->sum('total_price'), 0, ',', '.') }} đ
                </span>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4" style="overflow: visible;">
        <div class="card-header bg-white border-0 py-3 px-4">
            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-0">Lịch sử đặt hàng</h6>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <!-- 🖥️ DESKTOP TABLE VIEW -->
            <div class="table-responsive d-none d-lg-block">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Mã đơn</th>
                            <th class="text-center">Ngày đặt</th>
                            <th class="text-center">Giá trị</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-end pe-4">Cập nhật nhanh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td class="ps-4 fw-bold text-dark">#{{ $order->id }}</td>
                            <td class="text-center text-muted small">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center fw-bold text-navy">{{ number_format($order->total_price ?? 0, 0, ',', '.') }} VNĐ</td>
                            <td class="text-center">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-warning text-dark',
                                        'processing' => 'bg-primary text-white',
                                        'shipping' => 'bg-cyan text-white',
                                        'completed' => 'bg-success text-white',
                                        'cancelled' => 'bg-danger text-white'
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Chờ xác nhận',
                                        'processing' => 'Đang xử lý',
                                        'shipping' => 'Đang vận chuyển',
                                        'completed' => 'Đã nhận hàng',
                                        'cancelled' => 'Hủy'
                                    ];
                                @endphp
                                <span class="status-badge-elite {{ $statusClasses[$order->status] ?? 'bg-secondary' }}">
                                    {{ $statusLabels[$order->status] ?? $order->status }}
                                </span>
                            </td>
                            <td class="pe-4">
                                @include('admin.orders.partials.status_dropdown', ['order' => $order])
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-5 text-center text-muted">Không có đơn hàng nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 📱 MOBILE CARD VIEW -->
            <div class="d-lg-none bg-light bg-opacity-50 p-3">
                <div class="row g-3">
                    @forelse($orders as $order)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4 bg-white">
                            <div class="card-body p-3" style="overflow: visible;">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <div class="fw-bold text-dark mb-1" style="font-size: 1.1rem;">#{{ $order->id }}</div>
                                        <div class="text-muted x-small">
                                            <i class="fas fa-clock me-1"></i>{{ $order->created_at->format('H:i - d/m/Y') }}
                                        </div>
                                    </div>
                                    <span class="status-badge-elite {{ $statusClasses[$order->status] ?? 'bg-secondary' }}" style="width: auto; padding: 4px 12px !important;">
                                        {{ $statusLabels[$order->status] ?? $order->status }}
                                    </span>
                                </div>

                                <div class="bg-light rounded-3 p-3 mb-3 d-flex justify-content-between align-items-center">
                                    <div class="text-muted small fw-bold">GIÁ TRỊ ĐƠN HÀNG</div>
                                    <div class="fw-bold text-navy" style="font-size: 1rem;">{{ number_format($order->total_price ?? 0, 0, ',', '.') }} VNĐ</div>
                                </div>

                                <div class="dropdown-status-elite">
                                    <h6 class="fw-bold text-muted mb-2 text-uppercase letter-spacing-1" style="font-size: 10px;">Cập nhật trạng thái</h6>
                                    @include('admin.orders.partials.status_dropdown', ['order' => $order, 'is_mobile' => true])
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 py-5 text-center text-muted bg-white rounded-4 shadow-sm">
                        <i class="fas fa-box-open fa-3x mb-3 opacity-20"></i>
                        <p class="mb-0 fw-bold">Chưa có đơn hàng nào</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3 px-4 pagination-elite-wrapper">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
