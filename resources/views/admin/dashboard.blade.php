@extends('layouts.admin')

@section('page-icon', 'images/icon/dashboard.png')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    /* Ultra-High Specificity Responsive Rules */
    @media (max-width: 1199.98px) {
        body .stat-value { font-size: 1.8rem !important; }
        body .stat-label { font-size: 0.9rem !important; }
        body .welcome-title { font-size: 1.6rem !important; }
        body .welcome-subtitle { font-size: 1rem !important; }
        body .recent-order-id { font-size: 1.1rem !important; }
        body .recent-order-info { font-size: 0.95rem !important; }
        body .recent-order-status { font-size: 0.95rem !important; }
        body .stat-icon { width: 60px !important; height: 60px !important; font-size: 1.5rem !important; }
        body .card-body { padding: 1.5rem !important; }
        body .admin-container { padding: 0 15px !important; }
    }
    
    @media (max-width: 767.98px) {
        body .welcome-title { font-size: 1.4rem !important; }
        body .stat-value { font-size: 1.5rem !important; }
        body .stat-icon { width: 50px !important; height: 50px !important; font-size: 1.3rem !important; }
        body .card-body { padding: 1.25rem !important; }
    }

    @media (max-width: 575.98px) {
        body .stat-value { font-size: 1.15rem !important; }
        body .stat-label { font-size: 0.75rem !important; }
        body .stat-card { padding: 10px !important; min-height: 80px; }
        body .stat-icon { width: 40px !important; height: 40px !important; font-size: 1.1rem !important; }
        body .stat-icon img { width: 24px !important; height: 24px !important; }
        body .admin-container { padding: 0 8px !important; }
        body .welcome-banner { border-radius: 10px !important; }
        body .card { border-radius: 10px !important; }
        body .welcome-title { font-size: 1.1rem !important; }
        body .welcome-subtitle { font-size: 0.8rem !important; }
        body .card-body { padding: 0.85rem !important; }
        body .recent-order-id { font-size: 0.9rem !important; }
        body .recent-order-info { font-size: 0.72rem !important; }
        body .recent-order-status { font-size: 0.72rem !important; }
        body .list-group-item { padding-top: 0.5rem !important; padding-bottom: 0.5rem !important; }
        body h6.fw-bold { font-size: 0.95rem !important; }
        body .badge-outline { font-size: 0.7rem !important; padding: 2px 6px !important; }
    }
    
    @media (max-width: 360px) {
        body .welcome-title { font-size: 1.2rem !important; }
        body .topbar-title span { display: none; }
    }
    
    .welcome-subtitle { font-size: 0.95rem; opacity: 0.9; }
    .recent-order-id { font-size: 0.9rem; font-weight: 700; }
    .recent-order-info { font-size: 0.8rem; color: var(--ddh-muted); }
    .recent-order-status { font-size: 0.8rem; font-weight: 700; }
</style>
@endpush

@section('content')
    <!-- Welcome Banner -->
    <div class="card mb-4 animate-in border-0 welcome-banner" style="background: linear-gradient(135deg, var(--ddh-navy) 0%, var(--ddh-blue) 60%, var(--ddh-navy-mid) 100%); color: #fff; border-radius: 20px;">
        <div class="card-body p-4 p-md-5 d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div>
                <h3 class="fw-bold mb-2 welcome-title">Xin chào, {{ Auth::user()->name }}! 👋</h3>
                <p class="mb-0 welcome-subtitle">Dưới đây là tổng quan hoạt động kinh doanh DDH Electronics hôm nay.</p>
            </div>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="row g-3 g-md-4 mb-4">
        <div class="col-6 col-xl-3 col-md-6 animate-in delay-1">
            <div class="stat-card bg-white" style="--icon-color: var(--ddh-blue);">
                <div class="stat-icon" style="background: rgba(0,86,150,.08); color: var(--ddh-blue);">
                    <img src="{{ asset('images/icon/invoice_icon.webp') }}" style="width: 32px; height: 32px; object-fit: contain;">
                </div>
                <div class="stat-label">Tổng đơn hàng</div>
                <div class="stat-value">{{ number_format($total_orders) }}</div>
            </div>
        </div>
        <div class="col-6 col-xl-3 col-md-6 animate-in delay-2">
            <div class="stat-card bg-white" style="--icon-color: var(--ddh-success);">
                <div class="stat-icon" style="background: rgba(16,185,129,.08); color: var(--ddh-success);">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-label">Doanh thu</div>
                <div class="stat-value">{{ number_format($total_revenue, 0, ',', '.') }} <small class="opacity-50" style="font-size: 0.6em;">VNĐ</small></div>
            </div>
        </div>
        <div class="col-6 col-xl-3 col-md-6 animate-in delay-3">
            <div class="stat-card bg-white" style="--icon-color: var(--ddh-orange);">
                <div class="stat-icon" style="background: rgba(247,148,30,.08); color: var(--ddh-orange);">
                    <i class="fas fa-cube"></i>
                </div>
                <div class="stat-label">Sản phẩm</div>
                <div class="stat-value">{{ number_format($total_products) }}</div>
            </div>
        </div>
        <div class="col-6 col-xl-3 col-md-6 animate-in delay-4">
            <div class="stat-card bg-white" style="--icon-color: var(--ddh-info);">
                <div class="stat-icon" style="background: rgba(59,130,246,.08); color: var(--ddh-info);">
                    <i class="fas fa-user-group"></i>
                </div>
                <div class="stat-label">Khách hàng</div>
                <div class="stat-value">{{ number_format($total_users) }}</div>
            </div>
        </div>
    </div>

    <!-- Chart + Recent Orders -->
    <div class="row g-3 g-md-4">
        <div class="col-lg-8 col-md-12 animate-in delay-2">
            <div class="card h-100">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="fw-bold mb-0"><i class="fas fa-chart-area me-2" style="color: var(--ddh-blue);"></i>Biểu đồ doanh thu</h6>
                        <span class="badge-outline" style="border-color: var(--ddh-blue); color: var(--ddh-blue);">VNĐ</span>
                    </div>
                    <div style="height: 320px; position: relative;">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-12 animate-in delay-3">
            <div class="card h-100">
                <div class="card-body p-3 p-md-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold mb-0"><i class="fas fa-clock-rotate-left me-2" style="color: var(--ddh-orange);"></i>Đơn mới nhất</h6>
                        <a href="{{ route('admin.orders') }}" class="text-decoration-none fw-bold" style="font-size: .8rem; color: var(--ddh-blue);">
                            Xem tất cả <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="list-group list-group-flush">
                        @foreach($latest_orders as $order)
                        <div class="list-group-item px-0 py-3 border-bottom bg-transparent d-flex justify-content-between align-items-center">
                            <div>
                                <div class="recent-order-id">#DDH-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</div>
                                <div class="recent-order-info">{{ $order->user->name }} · {{ $order->created_at->diffForHumans() }}</div>
                            </div>
                            @php
                                $statusMap = [
                                    'pending' => ['Chờ xác nhận', 'var(--ddh-warning)', 'fas fa-clock'],
                                    'processing' => ['Đang xử lý', 'var(--ddh-info)', 'fas fa-spinner fa-spin'],
                                    'shipping' => ['Đang vận chuyển', 'var(--ddh-blue)', 'fas fa-truck'],
                                    'completed' => ['Đã nhận hàng', 'var(--ddh-success)', 'fas fa-check'],
                                    'cancelled' => ['Hủy', 'var(--ddh-danger)', 'fas fa-xmark'],
                                ];
                                $s = $statusMap[$order->status] ?? ['Không rõ', 'var(--ddh-muted)', 'fas fa-question'];
                            @endphp
                            <span class="recent-order-status" style="color: {{ $s[1] }}; display: flex; align-items: center; gap: 4px;">
                                <i class="{{ $s[2] }}"></i> {{ $s[0] }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    const ctx = document.getElementById('revenueChart').getContext('2d');

    const gradient = ctx.createLinearGradient(0, 0, 0, 320);
    gradient.addColorStop(0, 'rgba(0, 86, 150, 0.15)');
    gradient.addColorStop(1, 'rgba(0, 86, 150, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labels) !!},
            datasets: [{
                label: 'Doanh thu',
                data: {!! json_encode($data) !!},
                borderColor: '#005696',
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointBackgroundColor: '#F7941E',
                pointBorderColor: '#fff',
                pointBorderWidth: 3,
                pointHoverRadius: 9,
                borderWidth: 4
            }]
        },
        options: {
            maintainAspectRatio: false,
            responsive: true,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0d2137', titleColor: '#F7941E', bodyColor: '#fff',
                    padding: 12, cornerRadius: 10, displayColors: false,
                    callbacks: { label: ctx => ctx.parsed.y.toLocaleString('vi-VN') + ' VNĐ' }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { callback: v => v.toLocaleString() + ' VNĐ', color: '#94a3b8', font: { size: 11 } },
                    grid: { color: 'rgba(0,0,0,.04)', drawBorder: false }
                },
                x: {
                    ticks: { color: '#94a3b8', font: { size: 11 } },
                    grid: { display: false }
                }
            }
        }
    });
</script>
@endsection
