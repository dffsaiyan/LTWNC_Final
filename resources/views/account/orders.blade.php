@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@push('styles')
<style>
    .account-sidebar {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .account-menu-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 18px 25px;
        color: #64748b;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        border-bottom: 1px solid rgba(0,0,0,0.03);
    }
    .account-menu-item:last-child {
        border-bottom: none;
    }
    .account-menu-item:hover {
        background: #f8fafc;
        color: var(--primary-blue);
    }
    .account-menu-item.active {
        background: var(--primary-blue);
        color: #fff;
    }
    .account-menu-item.active i {
        color: #fff;
    }
    .account-menu-item i {
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
    }
    .order-history-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.05);
        padding: 40px;
        position: relative;
    }
    .premium-title {
        position: relative;
        display: inline-block;
        margin-bottom: 40px;
    }
    .premium-title h2 {
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: -0.5px;
        color: #0f172a;
        margin-bottom: 5px;
        font-size: 1.75rem;
    }
    .premium-title .title-line {
        width: 60px;
        height: 6px;
        background: var(--elite-orange, #fbbf24);
        border-radius: 10px;
    }
    .order-status-pill {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 6px 14px;
        border-radius: 100px;
        letter-spacing: 0.5px;
    }
    .order-table th {
        background: #f8fafc;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.5px;
        color: #64748b;
        padding: 15px 20px;
        border-bottom-width: 1px;
    }
    .order-table {
        min-width: 800px; /* Ensure table is wide enough to trigger scroll without wrapping */
    }
    .order-table td {
        padding: 18px 20px;
        white-space: nowrap; /* Prevent all cells from wrapping */
        border-bottom: 1px solid #f1f5f9;
        font-size: 14px;
    }
    .order-row:hover {
        background: #fcfcfc;
    }

    .order-tabs-wrapper {
        position: relative;
        margin-bottom: 30px;
    }
    .order-tabs-wrapper::before,
    .order-tabs-wrapper::after {
        content: '';
        position: absolute;
        top: 0;
        bottom: 3px; /* Trừ phần gạch chân */
        width: 50px;
        z-index: 2;
        pointer-events: none;
        transition: opacity 0.3s;
        opacity: 0;
    }
    .order-tabs-wrapper::before {
        left: 0;
        background: linear-gradient(to right, #fff, transparent);
    }
    .order-tabs-wrapper::after {
        right: 0;
        background: linear-gradient(to left, #fff, transparent);
    }
    .order-tabs-wrapper.is-overflow-left::before { opacity: 1; }
    .order-tabs-wrapper.is-overflow-right::after { opacity: 1; }

    .scroll-nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        width: 32px;
        height: 32px;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        cursor: pointer;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
        transition: all 0.3s;
        opacity: 0;
        visibility: hidden;
    }
    .scroll-nav-btn:hover {
        background: var(--elite-orange, #fbbf24);
        color: #fff;
        border-color: var(--elite-orange, #fbbf24);
    }
    .scroll-nav-btn.left { left: -10px; }
    .scroll-nav-btn.right { right: -10px; }
    .order-tabs-wrapper.is-overflow-left .scroll-nav-btn.left { opacity: 1; visibility: visible; }
    .order-tabs-wrapper.is-overflow-right .scroll-nav-btn.right { opacity: 1; visibility: visible; }

    .order-tabs-container {
        display: flex;
        gap: 0;
        margin-bottom: 0; /* Chuyển margin lên wrapper */
        border-bottom: 1px solid #eee;
        padding-bottom: 0;
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none;
        cursor: grab;
        user-select: none;
    }
    .order-tabs-container:active {
        cursor: grabbing;
    }
    .order-tabs-container::-webkit-scrollbar {
        display: none; /* Chrome, Safari */
    }
    .order-tab-item {
        flex-shrink: 0;
        padding: 12px 25px;
        font-weight: 700;
        font-size: 14px;
        color: #64748b;
        text-decoration: none;
        position: relative;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .order-tab-item:hover { color: var(--elite-orange, #fbbf24); }
    .order-tab-item.active { color: #000; }
    .order-tab-item.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--elite-orange, #fbbf24);
        border-radius: 10px 10px 0 0;
    }

    .loading-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255,255,255,0.7);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 10;
        border-radius: 20px;
        backdrop-filter: blur(2px);
    }

    /* HIGH-PRECISION RESPONSIVE DESIGN */
    @media (max-width: 991px) {
        .order-history-card { padding: 30px; }
        .premium-title h2 { font-size: 1.5rem; }
    }

    @media (max-width: 767px) {
        .container { padding-left: 15px; padding-right: 15px; }
        .order-history-card { padding: 25px 15px !important; border-radius: 15px; }
        .premium-title { margin-bottom: 25px; }
        .premium-title h2 { font-size: 1.25rem !important; }
        
        .sidebar-user-info { 
            display: flex !important; 
            flex-direction: column !important;
            text-align: center !important; 
            align-items: center !important; 
            padding: 25px 20px !important;
            gap: 5px;
        }
        .sidebar-user-info img { 
            width: 50px !important; height: 50px !important; 
            margin-bottom: 0 !important; border-width: 2px !important; 
        }
        .sidebar-user-info h6 { font-size: 13px !important; }
        .sidebar-user-info span { font-size: 10px !important; }
        .account-menu-item { padding: 12px 15px; font-size: 12px !important; }
        .account-menu-item i { font-size: 0.9rem; }

        .order-tabs-container { gap: 0 !important; margin-bottom: 20px !important; scrollbar-width: none; }
        .order-tabs-container::-webkit-scrollbar { display: none; }
        .order-tab-item { padding: 10px 15px !important; font-size: 12px !important; }

        .order-table th { font-size: 10px !important; padding: 12px 8px !important; }
        .order-table td { padding: 15px 8px !important; font-size: 12px !important; }
        .order-status-pill { padding: 4px 10px !important; font-size: 10px !important; }
        .fw-bold.text-danger { font-size: 13px !important; }
        .btn-sm.rounded-circle { width: 30px !important; height: 30px !important; }
    }

    @media (max-width: 480px) {
        .order-tab-item { padding: 10px 12px !important; font-size: 11px !important; }
        .order-table th { font-size: 9px !important; padding: 10px 5px !important; }
        .order-table td { font-size: 11px !important; padding: 12px 5px !important; }
        .order-status-pill { padding: 3px 6px !important; font-size: 9px !important; }
    }
</style>
@endpush

@section('content')
<div class="container py-4 py-md-5 mt-md-4">
    <div class="row g-4">
        <!-- Sidebar Menu -->
        <div class="col-lg-3 animate-slide-in-left">
            <div class="account-sidebar shadow-sm">
                <div class="p-4 text-center border-bottom bg-light sidebar-user-info">
                    @php $user = Auth::user(); @endphp
                    <img src="{{ $user->avatar ? asset($user->avatar) : ($user->social_avatar ?? asset('images/default-avatar.png')) }}" 
                         class="rounded-circle mb-3 shadow-sm border border-4 border-white mx-auto d-block" style="width: 80px; height: 80px; object-fit: cover;">
                    <div class="user-meta-elite">
                        <h6 class="fw-bold mb-0 text-dark">{{ $user->name }}</h6>
                        <span class="x-small text-muted fw-semibold">Thành viên Elite</span>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <a href="{{ route('account.profile') }}" class="account-menu-item">
                        <i class="fas fa-user-circle"></i> Hồ sơ của tôi
                    </a>
                    <a href="{{ route('account.wishlist') }}" class="account-menu-item">
                        <i class="fas fa-heart"></i> Danh sách yêu thích
                    </a>
                    <a href="{{ route('account.orders') }}" class="account-menu-item active">
                        <i class="fas fa-shopping-bag"></i> Đơn hàng đã mua
                    </a>
                    <a href="{{ route('posts.index') }}" class="account-menu-item">
                        <i class="fas fa-newspaper"></i> Đọc tin tức
                    </a>
                    @if(Auth::user()->can_write_posts || Auth::user()->email === 'admin@ddh.com')
                    <a href="{{ route('admin.posts') }}" class="account-menu-item">
                        <i class="fas fa-edit"></i> Viết bài mới
                    </a>
                    @endif
                    @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="account-menu-item text-primary">
                        <i class="fas fa-user-shield"></i> Quản trị hệ thống
                    </a>
                    @endif
                    <a href="{{ route('logout') }}" class="account-menu-item text-danger confirm-logout-app">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9 animate-slide-in-right">
            <div class="order-history-card shadow-sm">
                <div class="d-flex justify-content-between align-items-center order-history-header mb-4">
                    <div class="premium-title mb-0">
                        <h2 class="mb-1">Lịch sử đơn hàng</h2>
                        <div class="title-line"></div>
                    </div>
                </div>

                <!-- Status Filter Tabs -->
                <div class="order-tabs-wrapper">
                    <button class="scroll-nav-btn left" id="scroll-left">
                        <i class="fas fa-chevron-left small"></i>
                    </button>
                    <button class="scroll-nav-btn right" id="scroll-right">
                        <i class="fas fa-chevron-right small"></i>
                    </button>
                    <div class="order-tabs-container" id="order-tabs">
                        @php 
                            $currentStatus = request('status', 'all');
                            $statuses = [
                                'all' => 'Tất cả',
                                'pending' => 'Chờ xác nhận',
                                'processing' => 'Đang xử lý',
                                'shipping' => 'Đang vận chuyển',
                                'completed' => 'Đã nhận hàng',
                                'cancelled' => 'Hủy'
                            ];
                        @endphp
                        @foreach($statuses as $key => $label)
                            <a href="{{ route('account.orders', ['status' => $key]) }}" 
                               data-status="{{ $key }}"
                               class="order-tab-item tab-filter {{ $currentStatus == $key ? 'active' : '' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>

                <div id="order-list-wrapper" style="position: relative;">
                    <div class="loading-overlay" id="order-loader">
                        <div class="spinner-border text-warning" role="status"></div>
                    </div>
                    
                    <div id="order-list-content">
                        @if($orders->count() > 0)
                <div class="table-responsive rounded-4 border">
                    <table class="table align-middle mb-0 order-table">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-end px-4">Xem</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr class="order-row">
                                <td class="fw-bold text-dark">#DDH-{{ $order->id }}</td>
                                <td class="text-muted" style="font-size: 13px;">
                                    {{ $order->created_at->format('d/m/Y') }}
                                    <span class="d-none d-md-inline ms-1 x-small">{{ $order->created_at->format('H:i') }}</span>
                                </td>
                                <td class="fw-bold text-danger">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</td>
                                <td class="text-center">
                                    @php
                                        $status_badge = [
                                            'pending' => 'bg-warning text-dark',
                                            'processing' => 'bg-primary text-white',
                                            'shipping' => 'bg-info text-white',
                                            'completed' => 'bg-success text-white',
                                            'cancelled' => 'bg-danger text-white'
                                        ];
                                        $status_text = [
                                            'pending' => 'Chờ xác nhận',
                                            'processing' => 'Đang xử lý',
                                            'shipping' => 'Đang vận chuyển',
                                            'completed' => 'Đã nhận hàng',
                                            'cancelled' => 'Hủy'
                                        ];
                                    @endphp
                                    <span class="order-status-pill text-nowrap {{ $status_badge[$order->status] ?? 'bg-secondary' }}">
                                        {{ $status_text[$order->status] ?? $order->status }}
                                    </span>

                                </td>
                                <td class="text-end px-3">
                                    <div class="d-flex justify-content-end gap-2">
                                        @if($order->status === 'pending')
                                            <form action="{{ route('account.orders.cancel', $order->id) }}" method="POST" class="d-inline confirm-cancel-order">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold border-0" style="font-size: 11px;">
                                                    <i class="fas fa-times me-1"></i> Hủy đơn
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('account.order_detail', $order->id) }}" class="btn btn-light btn-sm rounded-circle shadow-sm border" style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                            <i class="fas fa-eye text-primary small"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 d-flex justify-content-center">
                    {{ $orders->links() }}
                </div>
                @else
                <div class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/4076/4076432.png" style="width: 120px; opacity: 0.2;" class="mb-4">
                    <h5 class="fw-bold text-muted">Bạn chưa có đơn hàng nào!</h5>
                    <p class="text-muted small mb-4">Mọi đơn hàng bạn mua sẽ xuất hiện tại đây để bạn dễ dàng theo dõi.</p>
                    <a href="/" class="btn btn-dark rounded-pill px-5 fw-bold">KHÁM PHÁ CỬA HÀNG</a>
                </div>
                @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab-filter');
        const content = document.getElementById('order-list-content');
        const loader = document.getElementById('order-loader');

        tabs.forEach(tab => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                
                const url = this.getAttribute('href');
                const status = this.getAttribute('data-status');

                // Update UI visually
                tabs.forEach(t => t.classList.remove('active'));
                this.classList.add('active');

                // Show loader
                loader.style.display = 'flex';
                content.style.opacity = '0.5';

                // Update URL without reload
                window.history.pushState({status: status}, '', url);

                // Fetch new content
                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.getElementById('order-list-content').innerHTML;
                    
                    content.innerHTML = newContent;
                    
                    // Hide loader
                    loader.style.display = 'none';
                    content.style.opacity = '1';

                    // Re-bind click events for pagination links if needed
                    bindPaginationLinks();
                })
                .catch(err => {
                    console.error('Error loading orders:', err);
                    window.location.href = url; // Fallback to normal load
                });
            });
        });

        function bindPaginationLinks() {
            const paginationLinks = document.querySelectorAll('#order-list-content .pagination a');
            paginationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    tab.click(); // This is a bit complex for general pagination, but logic is similar
                    // For simplicity, just fetch the link URL
                    const url = this.getAttribute('href');
                    loader.style.display = 'flex';
                    content.style.opacity = '0.5';
                    
                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(res => res.text())
                        .then(html => {
                            const doc = new DOMParser().parseFromString(html, 'text/html');
                            content.innerHTML = doc.getElementById('order-list-content').innerHTML;
                            loader.style.display = 'none';
                            content.style.opacity = '1';
                            bindPaginationLinks();
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        });
                });
            });
        }
        
        bindPaginationLinks();

        // --- DRAG TO SCROLL FOR TABS ---
        const slider = document.querySelector('.order-tabs-container');
        let isDown = false;
        let startX;
        let scrollLeft;

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            slider.classList.add('active');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });
        slider.addEventListener('mouseleave', () => {
            isDown = false;
        });
        slider.addEventListener('mouseup', () => {
            isDown = false;
        });
        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2; // Tốc độ trượt
            slider.scrollLeft = scrollLeft - walk;
            updateFades();
        });

        const wrapper = document.querySelector('.order-tabs-wrapper');
        function updateFades() {
            const isOverflowing = slider.scrollWidth > slider.clientWidth;
            if (!isOverflowing) {
                wrapper.classList.remove('is-overflow-left', 'is-overflow-right');
                return;
            }

            const scrollLeft = slider.scrollLeft;
            const maxScrollLeft = slider.scrollWidth - slider.clientWidth;

            if (scrollLeft > 5) {
                wrapper.classList.add('is-overflow-left');
            } else {
                wrapper.classList.remove('is-overflow-left');
            }

            if (scrollLeft < maxScrollLeft - 5) {
                wrapper.classList.add('is-overflow-right');
            } else {
                wrapper.classList.remove('is-overflow-right');
            }
        }

        slider.addEventListener('scroll', updateFades);
        window.addEventListener('resize', updateFades);
        updateFades(); // Initial check

        // --- CLICK TO SCROLL FOR ARROWS ---
        const btnLeft = document.getElementById('scroll-left');
        const btnRight = document.getElementById('scroll-right');

        btnLeft.addEventListener('click', () => {
            slider.scrollBy({
                left: -200,
                behavior: 'smooth'
            });
        });

        btnRight.addEventListener('click', () => {
            slider.scrollBy({
                left: 200,
                behavior: 'smooth'
            });
        });

        // --- CONFIRM CANCEL ORDER ---
        document.addEventListener('click', function(e) {
            const cancelForm = e.target.closest('.confirm-cancel-order');
            if (cancelForm) {
                e.preventDefault();
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
                        cancelForm.submit();
                    }
                });
            }
        });
    });
</script>
@endpush
@endsection


