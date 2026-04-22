@extends('layouts.app')

@section('title', 'Danh sách yêu thích')

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
    .wishlist-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.05);
        padding: 40px;
    }
    .product-wish-item {
        transition: all 0.3s ease;
        border: 1px solid #f1f5f9;
    }
    .product-wish-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border-color: #fed7aa;
    }
    .btn-remove-wish {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: rgba(255,255,255,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ef4444;
        border: 1px solid #f1f5f9;
        transition: all 0.2s;
        z-index: 10;
    }
    .btn-remove-wish:hover {
        background: #ef4444;
        color: #fff;
        transform: scale(1.1);
    }
</style>
@endpush

@section('content')
<div class="container py-5 mt-4">
    <div class="row g-4">
        <!-- Sidebar Menu -->
        <div class="col-lg-3 animate-slide-in-left">
            <div class="account-sidebar shadow-sm">
                <div class="p-4 text-center border-bottom bg-light sidebar-user-info">
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
                    <a href="{{ route('account.wishlist') }}" class="account-menu-item active">
                        <i class="fas fa-heart"></i> Danh sách yêu thích
                    </a>
                    <a href="{{ route('account.orders') }}" class="account-menu-item">
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
            <div class="wishlist-card shadow-sm">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0 d-flex align-items-center gap-3">
                        <span style="width: 8px; height: 25px; background: #f97316; border-radius: 50px;"></span>
                        Danh sách yêu thích ({{ $wishlist->count() }})
                    </h4>
                    @if($wishlist->count() > 0)
                        <button class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold border-0" onclick="clearWishlist('{{ route('wishlist.clear') }}')">
                            <i class="fas fa-trash-alt me-1"></i> Xóa tất cả
                        </button>
                    @endif
                </div>

                @if($wishlist->count() > 0)
                    <div class="row g-4">
                        @foreach($wishlist as $item)
                            @php $product = $item->product; @endphp
                            <div class="col-md-4 col-6" id="wish-item-{{ $product->id }}">
                                <div class="card product-wish-item h-100 rounded-4 overflow-hidden position-relative">
                                    <button class="btn-remove-wish" onclick="removeWishlist(event, '{{ $product->id }}', '{{ route('wishlist.toggle', $product->id) }}')">
                                        <i class="fas fa-trash-alt small"></i>
                                    </button>
                                    
                                    <a href="{{ route('products.show', $product->slug) }}" class="p-3 d-block text-center">
                                        <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/300x300' }}" class="img-fluid rounded-3" style="height: 150px; object-fit: contain;">
                                    </a>
                                    
                                    <div class="card-body p-3 pt-0 d-flex flex-column">
                                        <h6 class="fw-bold text-dark mb-2 text-truncate-2 small" style="min-height: 40px; line-height: 1.5;">{{ $product->name }}</h6>
                                        <div class="mt-auto">
                                            <div class="mb-3">
                                                <span class="fw-bold text-orange-gradient" style="font-size: 16px;">{{ number_format($product->sale_price > 0 ? $product->sale_price : $product->price, 0, ',', '.') }} VNĐ</span>
                                            </div>
                                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-dark w-100 rounded-pill py-2 small fw-bold" style="font-size: 11px;">XEM CHI TIẾT</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="far fa-heart text-light" style="font-size: 80px;"></i>
                        </div>
                        <h5 class="fw-bold text-muted">Danh sách yêu thích trống!</h5>
                        <p class="text-muted small mb-4">Hãy thêm những sản phẩm bạn yêu thích để dễ dàng theo dõi và mua sắm sau này.</p>
                        <a href="/" class="btn btn-dark rounded-pill px-5 fw-bold">KHÁM PHÁ CỬA HÀNG</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

@push('scripts')
<script>
    function clearWishlist(url) {
        Swal.fire({
            title: 'Xóa tất cả?',
            text: 'Bạn có chắc chắn muốn xóa toàn bộ sản phẩm trong danh sách yêu thích không?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Có, xóa tất cả',
            cancelButtonText: 'Quay lại',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-4 shadow-lg border-0',
                confirmButton: 'rounded-pill px-4 fw-bold',
                cancelButton: 'rounded-pill px-4 fw-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if(data.success) {
                        window.location.reload();
                    }
                });
            }
        });
    }

    function removeWishlist(event, productId, url) {
        event.preventDefault();
        
        Swal.fire({
            title: 'Xóa khỏi danh sách?',
            text: 'Bạn có chắc chắn muốn xóa sản phẩm này khỏi danh sách yêu thích?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Xác nhận xóa',
            cancelButtonText: 'Hủy',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-4 shadow-lg border-0',
                confirmButton: 'rounded-pill px-4 fw-bold',
                cancelButton: 'rounded-pill px-4 fw-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(r => r.json())
                .then(data => {
                    if(data.success) {
                        const item = document.getElementById(`wish-item-${productId}`);
                        item.style.transform = 'scale(0)';
                        item.style.opacity = '0';
                        setTimeout(() => {
                            item.remove();
                            // Check if empty
                            if(document.querySelectorAll('.product-wish-item').length === 0) {
                                window.location.reload();
                            }
                        }, 300);
                    }
                });
            }
        });
    }
</script>
@endpush
@endsection
