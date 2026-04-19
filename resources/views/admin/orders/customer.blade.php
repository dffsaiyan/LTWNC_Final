@extends('layouts.admin')
@section('page-icon', 'fas fa-boxes')
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
    .dropdown-status-elite .dropdown-menu {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        padding: 8px;
        margin-top: 5px !important;
        width: 100%; /* Match parent width */
        min-width: 160px;
        animation: slideDown 0.3s ease-out;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
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
    <div class="d-flex align-items-center gap-3 mb-4 animate-in">
        <a href="{{ route('admin.orders') }}" class="btn btn-white btn-sm rounded-circle shadow-sm border" style="width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center;">
            <i class="fas fa-arrow-left text-muted"></i>
        </a>
        <div>
            <h5 class="fw-bold mb-0">Đơn hàng của {{ $customer->name }}</h5>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4">
            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-0">Lịch sử đặt hàng</h6>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
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
                            <td class="text-center fw-bold">{{ number_format($order->total_price ?? 0, 0, ',', '.') }} VNĐ</td>
                            <td class="text-center">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-warning text-dark',
                                        'processing' => 'bg-primary text-white',
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
                                <div class="dropdown dropdown-status-elite d-flex justify-content-end">
                                    @php
                                        $currentStatus = $order->status;
                                        $config = [
                                            'pending' => ['label' => 'Chờ xác nhận', 'class' => 'status-btn-pending', 'icon' => 'fas fa-clock'],
                                            'processing' => ['label' => 'Đang xử lý', 'class' => 'status-btn-processing', 'icon' => 'fas fa-spinner fa-spin'],
                                            'shipping' => ['label' => 'Đang vận chuyển', 'class' => 'status-btn-shipping', 'icon' => 'fas fa-truck'],
                                            'completed' => ['label' => 'Đã nhận hàng', 'class' => 'status-btn-completed', 'icon' => 'fas fa-check-circle'],
                                            'cancelled' => ['label' => 'Hủy đơn', 'class' => 'status-btn-cancelled', 'icon' => 'fas fa-times-circle'],
                                        ];
                                        $current = $config[$currentStatus] ?? ['label' => $currentStatus, 'class' => 'btn-secondary', 'icon' => 'fas fa-question'];
                                    @endphp
                                    
                                    <button class="btn {{ $current['class'] }} btn-status dropdown-toggle" 
                                            type="button" 
                                            data-bs-toggle="dropdown" 
                                            aria-expanded="false"
                                            {{ $currentStatus == 'completed' ? 'disabled' : '' }}>
                                        <i class="{{ $current['icon'] }}"></i>
                                        {{ $current['label'] }}
                                        @if($currentStatus != 'completed')
                                            <i class="fas fa-chevron-down ms-1" style="font-size: 8px;"></i>
                                        @endif
                                    </button>
                                    
                                    @if($currentStatus != 'completed')
                                    <ul class="dropdown-menu border-0 shadow-lg">
                                        @foreach($config as $key => $item)
                                            <li>
                                                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="status" value="{{ $key }}">
                                                    <button type="submit" class="dropdown-item {{ $currentStatus == $key ? 'active-status' : '' }}">
                                                        <i class="{{ $item['icon'] }} {{ $key == 'processing' ? '' : 'text-muted' }}"></i>
                                                        {{ $item['label'] }}
                                                    </button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </div>
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
        </div>
        <div class="card-footer bg-white border-0 py-3 px-4 pagination-elite-wrapper">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    </div>
@endsection
