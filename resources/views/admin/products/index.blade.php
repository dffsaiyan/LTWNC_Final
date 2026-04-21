@extends('layouts.admin')

@section('page-title', 'Quản lý Sản phẩm')
@section('page-icon', 'images/icon/box.png')

@section('content')
<div class="container-fluid px-0">
    <!-- 🏢 HEADER SECTION -->
    <div class="d-flex justify-content-between align-items-center mb-4 animate-in flex-wrap gap-3 elite-header-mobile">
        <div class="page-header-title">
            <h5 class="fw-bold mb-1 header-text-main">Kho sản phẩm</h5>
            <p class="text-muted mb-0 sub-text-main">Tổng cộng <span id="totalProductCount" class="fw-bold text-dark">{{ $products->total() }}</span> sản phẩm</p>
        </div>
        <div class="d-flex gap-2 header-actions-wrapper">
            <button type="button" class="btn btn-outline-danger elite-action-btn" onclick="confirmDeleteAll()">
                <i class="fas fa-trash-alt me-md-2"></i><span>Xóa tất cả</span>
            </button>
            <a href="{{ route('admin.products.create') }}" class="btn btn-ddh-primary elite-action-btn shadow-sm">
                <i class="fas fa-plus me-md-2"></i><span>Thêm sản phẩm</span>
            </a>
            <form id="deleteAllForm" action="{{ route('admin.products.delete-all') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>

    <!-- 🛠️ TOOLBAR: FILTER & SEARCH -->
    <div class="mb-4 animate-in delay-1">
        <div class="card border-0 shadow-sm rounded-4 toolbar-card-elite">
            <div class="card-body p-3">
                <div class="d-flex flex-column flex-md-row align-items-center gap-3">
                    
                    <!-- 🏹 CATEGORY NAVIGATION -->
                    <div class="category-nav-wrapper">
                        <button type="button" class="nav-arrow-btn" id="scrollLeftBtn">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        
                        <div class="category-scroll-container" id="categoryScroll">
                            <div class="d-flex gap-2 py-1">
                                <a href="{{ route('admin.products', ['search' => request('search')]) }}" 
                                   class="nav-tab-item {{ !request('category') ? 'active' : '' }}">
                                    Tất cả mẫu
                                </a>
                                @foreach($categories as $cat)
                                    <a href="{{ route('admin.products', ['category' => $cat->id, 'search' => request('search')]) }}" 
                                       class="nav-tab-item {{ request('category') == $cat->id ? 'active' : '' }}">
                                        {{ $cat->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <button type="button" class="nav-arrow-btn" id="scrollRightBtn">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <!-- Ô tìm kiếm nhanh -->
                    <div class="search-wrapper-elite">
                        <div class="position-relative">
                            <input type="text" id="searchInput" name="search" value="{{ request('search') }}" 
                                   class="form-control elite-search-input" 
                                   placeholder="Tìm sản phẩm..." 
                                   autocomplete="off">
                            <i class="fas fa-search search-icon-overlay"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* ── ELITE STYLE SYSTEM ── */
        .header-text-main { font-size: 1.6rem; font-weight: 800; color: #0f172a; }
        .sub-text-main { font-size: 1rem; color: #64748b; }
        .elite-action-btn { 
            border-radius: 50px; padding: 0.8rem 1.8rem; font-weight: 700; font-size: 1rem;
            display: flex; align-items: center; gap: 8px; transition: all 0.3s ease;
        }

        /* Category Nav */
        .category-nav-wrapper { display: flex; align-items: center; gap: 10px; background: #f8fafc; padding: 6px 12px; border-radius: 50px; border: 1px solid rgba(0,0,0,0.05); flex: 1; min-width: 0; }
        .category-scroll-container { 
            flex: 1; overflow-x: auto; scroll-behavior: smooth; white-space: nowrap;
            scrollbar-width: none; -ms-overflow-style: none;
        }
        .category-scroll-container::-webkit-scrollbar { display: none; }
        
        .nav-arrow-btn {
            width: 42px; height: 42px; border-radius: 50%; border: none;
            background: #fff; color: #0f172a; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1); cursor: pointer; transition: all 0.2s; flex-shrink: 0;
            z-index: 5;
        }
        .nav-arrow-btn:hover { background: #0f172a; color: #fff; }
        .nav-arrow-btn.disabled { opacity: 0.15; pointer-events: none; }

        .nav-tab-item {
            padding: 0.65rem 1.4rem; border-radius: 50px; font-size: 0.95rem; font-weight: 700;
            text-decoration: none; color: #475569; background: transparent; transition: all 0.2s;
            display: inline-block;
        }
        .nav-tab-item.active { background: #fff; color: #0f172a; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }

        .search-wrapper-elite { width: 300px; flex-shrink: 0; }
        .elite-search-input {
            border-radius: 50px; height: 50px; padding-left: 3rem; font-size: 1.05rem;
            font-weight: 600; border: 1px solid rgba(0,0,0,0.1); background: #f8fafc;
        }
        .search-icon-overlay { position: absolute; left: 18px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 1.1rem; }

        }
    </style>

    <div id="productTableContainer">
        <!-- 🖥️ UNIFIED RESPONSIVE TABLE -->
        <!-- 📱 MOBILE & 🖥️ DESKTOP UNIFIED VIEW -->
        <div class="card animate-in delay-1 border-0 shadow-sm rounded-4 overflow-hidden bg-transparent bg-lg-white">
            <div class="card-body p-0">
                <!-- 🖥️ DESKTOP TABLE VIEW (Visible on LG and up) -->
                <div class="table-responsive d-none d-lg-block">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-muted fw-600" style="font-size: .75rem; text-transform: uppercase;">Sản Phẩm</th>
                                <th class="py-3 text-muted fw-600" style="font-size: .75rem; text-transform: uppercase;">Danh Mục</th>
                                <th class="py-3 text-muted fw-600" style="font-size: .75rem; text-transform: uppercase;">Giá bán</th>
                                <th class="py-3 text-muted fw-600" style="font-size: .75rem; text-transform: uppercase;">Kho</th>
                                <th class="text-end pe-4 py-3 text-muted fw-600" style="font-size: .75rem; text-transform: uppercase;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="product-img-wrapper" style="width: 50px; height: 50px; border-radius: 10px; overflow: hidden; background: #f8fafc; border: 1px solid rgba(0,0,0,0.04); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                            <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/50' }}" class="object-fit-contain" width="40" height="40">
                                        </div>
                                        <div>
                                            <div class="fw-bold" style="font-size: .88rem; color: #1e293b;">{{ Str::limit($product->name, 45) }}</div>
                                            <div class="mt-1">
                                                <span style="font-size: .75rem; background: #f1f5f9; padding: 2px 8px; border-radius: 4px;">SKU: DDH-{{ strtoupper(Str::limit($product->category->slug ?? 'PRO', 3, '')) }}-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge-outline" style="border-color: var(--ddh-blue); color: var(--ddh-blue); font-weight: 600;">{{ $product->category->name ?? 'N/A' }}</span></td>
                                <td><span class="fw-bold" style="color: #0f172a; font-size: .9rem;">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span></td>
                                <td>
                                    @if($product->stock > 10)
                                        <span class="badge bg-success-soft text-success px-3 py-2 rounded-pill fw-bold" style="font-size: .75rem; background: rgba(16,185,129,0.1);">{{ $product->stock }} Còn hàng</span>
                                    @elseif($product->stock > 0)
                                        <span class="badge bg-warning-soft text-warning px-3 py-2 rounded-pill fw-bold" style="font-size: .75rem; background: rgba(245,158,11,0.1);">{{ $product->stock }} Sắp hết</span>
                                    @else
                                        <span class="badge bg-danger-soft text-danger px-3 py-2 rounded-pill fw-bold" style="font-size: .75rem; background: rgba(239,68,68,0.1);">Hết hàng</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" style="font-size: .75rem;">
                                            <i class="fas fa-pen me-md-1"></i><span class="d-none d-md-inline">Sửa</span>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-2 fw-bold" style="font-size: .75rem;" 
                                                onclick="confirmDelete('{{ $product->id }}', '{{ addslashes($product->name) }}')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $product->id }}" action="{{ route('admin.products.delete', $product->id) }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- 📱 MOBILE CARD VIEW (Visible below LG) -->
                <div class="d-lg-none p-2">
                    <div class="row g-3">
                        @foreach($products as $product)
                        <div class="col-12">
                            <div class="mobile-product-card p-3 rounded-4 shadow-sm bg-white border border-light">
                                <div class="d-flex gap-3 align-items-start mb-3">
                                    <div class="mobile-card-img" style="width: 70px; height: 70px; border-radius: 12px; background: #f8fafc; display: flex; align-items: center; justify-content: center; flex-shrink: 0; border: 1px solid rgba(0,0,0,0.03);">
                                        <img src="{{ $product->image ? asset($product->image) : 'https://via.placeholder.com/70' }}" class="object-fit-contain" width="55" height="55">
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold text-dark mb-1" style="font-size: 0.95rem; line-height: 1.3;">{{ $product->name }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">SKU: DDH-{{ strtoupper(Str::limit($product->category->slug ?? 'PRO', 3, '')) }}-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</div>
                                        <div class="mt-2">
                                            <span class="badge-outline py-1 px-2" style="font-size: 0.65rem; border-color: var(--ddh-blue); color: var(--ddh-blue);">{{ $product->category->name ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top border-light mt-3">
                                    <div>
                                        <div class="text-muted mb-1" style="font-size: 0.7rem; text-transform: uppercase; font-weight: 600;">Giá bán</div>
                                        <div class="fw-bold text-primary" style="font-size: 1rem;">{{ number_format($product->price, 0, ',', '.') }} <small>đ</small></div>
                                    </div>
                                    <div class="text-end">
                                        <div class="text-muted mb-1" style="font-size: 0.7rem; text-transform: uppercase; font-weight: 600;">Kho hàng</div>
                                        @if($product->stock > 10)
                                            <span class="text-success fw-bold" style="font-size: 0.85rem;">{{ $product->stock }} <span style="font-size: 0.75rem;">Còn hàng</span></span>
                                        @elseif($product->stock > 0)
                                            <span class="text-warning fw-bold" style="font-size: 0.85rem;">{{ $product->stock }} <span style="font-size: 0.75rem;">Sắp hết</span></span>
                                        @else
                                            <span class="text-danger fw-bold" style="font-size: 0.85rem;">Hết hàng</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="d-flex gap-2 mt-3">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-light border flex-grow-1 py-2 rounded-3 fw-bold" style="font-size: 0.85rem; color: #475569;">
                                        <i class="fas fa-pen me-2"></i>Chỉnh sửa
                                    </a>
                                    <button type="button" class="btn btn-outline-danger py-2 px-3 rounded-3" onclick="confirmDelete('{{ $product->id }}', '{{ addslashes($product->name) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @if($products->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4 pagination-elite-wrapper">
                {{ $products->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

<script>
    function initCategoryScroll() {
        const scrollContainer = document.getElementById('categoryScroll');
        const leftBtn = document.getElementById('scrollLeftBtn');
        const rightBtn = document.getElementById('scrollRightBtn');
        if (scrollContainer && leftBtn && rightBtn) {
            const updateArrows = () => {
                leftBtn.classList.toggle('disabled', scrollContainer.scrollLeft <= 5);
                rightBtn.classList.toggle('disabled', scrollContainer.scrollLeft + scrollContainer.clientWidth >= scrollContainer.scrollWidth - 5);
            };
            leftBtn.onclick = (e) => { e.preventDefault(); scrollContainer.scrollBy({ left: -200, behavior: 'smooth' }); setTimeout(updateArrows, 400); };
            rightBtn.onclick = (e) => { e.preventDefault(); scrollContainer.scrollBy({ left: 200, behavior: 'smooth' }); setTimeout(updateArrows, 400); };
            scrollContainer.onscroll = updateArrows;
            updateArrows();
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        initCategoryScroll();
        
        // Tự động cuộn đến danh mục đang chọn
        const activeTab = document.querySelector('.nav-tab-item.active');
        if (activeTab && activeTab.innerText.trim() !== 'Tất cả mẫu') {
            const scrollContainer = document.getElementById('categoryScroll');
            const scrollLeft = activeTab.offsetLeft - (scrollContainer.clientWidth / 2) + (activeTab.clientWidth / 2);
            scrollContainer.scrollTo({ left: scrollLeft, behavior: 'smooth' });
        }

        const searchInput = document.getElementById('searchInput');
        let debounceTimer;
        if (searchInput) {
            searchInput.oninput = function() {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => { performSearch(); }, 300);
            };
        }
        function performSearch() {
            const query = searchInput.value;
            const urlParams = new URLSearchParams(window.location.search);
            if (query) urlParams.set('search', query); else urlParams.delete('search');
            const newUrl = `${window.location.pathname}?${urlParams.toString()}`;
            const container = document.getElementById('productTableContainer');
            container.style.opacity = '0.5';
            fetch(newUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.text())
            .then(html => {
                const doc = new DOMParser().parseFromString(html, 'text/html');
                container.innerHTML = doc.getElementById('productTableContainer').innerHTML;
                document.getElementById('totalProductCount').innerText = doc.getElementById('totalProductCount').innerText;
                container.style.opacity = '1';
                window.history.pushState({}, '', newUrl);
                initCategoryScroll();
            });
        }
    });

    function confirmDelete(id, name) {
        Swal.fire({
            title: 'Xóa?', text: name, icon: 'warning', showCancelButton: true, confirmButtonColor: '#ef4444', confirmButtonText: 'Xóa'
        }).then((res) => { if (res.isConfirmed) document.getElementById(`delete-form-${id}`).submit(); });
    }

    function confirmDeleteAll() {
        Swal.fire({
            title: 'Xóa hết?', icon: 'error', showCancelButton: true, confirmButtonColor: '#d33', confirmButtonText: 'Xác nhận'
        }).then((res) => { if (res.isConfirmed) document.getElementById('deleteAllForm').submit(); });
    }
</script>
@endsection
