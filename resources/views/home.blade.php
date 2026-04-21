@extends('layouts.app')

@section('title', 'Trang Chủ - DDH Electronics Elite')

@section('content')
<div class="container mt-2">
    <!-- RESPONSIVE HERO GRID (ELITE CLEAN VERSION) -->
    <div class="row g-2 px-1 hero-row-elite align-items-stretch">
        
        <!-- LEFT: CATEGORY SIDEBAR -->
        <div class="col-xl-auto d-none d-xl-block sidebar-column-elite d-flex flex-column h-auto">
            <div id="productSidebarElite" class="bg-white rounded-3 shadow-sm h-100 overflow-hidden border border-light sidebar-elite-container d-flex flex-column transition-all">
                <div class="p-3 bg-dark-elite text-white fw-bold d-flex align-items-center gap-2 small border-bottom border-warning border-3">
                    <i class="fas fa-bars text-warning"></i> DANH MỤC SẢN PHẨM
                </div>
                <div class="d-flex flex-column py-1 flex-grow-1">
                    @foreach($sidebarCategories as $cat)
                    <a href="{{ route('categories.show', $cat->slug) }}" class="category-item-elite px-3 flex-fill">
                        <div class="d-flex align-items-center gap-2">
                             <img src="{{ asset($cat->icon ?: 'images/icon/gaming-mouse-3d-icon-png-download-9675855.webp') }}" alt="{{ $cat->name }}" 
                                  style="width: 22px; height: 22px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                             <span>{{ $cat->name }}</span>
                        </div>
                        <i class="fas fa-chevron-right xx-small opacity-30"></i>
                    </a>
                    @endforeach
                    
                    <div class="mx-3 my-2 border-top border-light opacity-50"></div>
                    
                    <a href="{{ $flashSaleLink }}" class="category-item-elite px-3 text-danger fw-black border-bottom-0 sale-highlight flex-fill">
                        <div class="d-flex align-items-center justify-content-between w-100">
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ asset('images/icon/pngtree-3d-lightning-icon-flash-sale-listrik-petir-png-image_17854619.webp') }}" 
                                     alt="Lightning" class="flash-pulse" style="width: 24px; height: 24px; object-fit: contain;">
                                <span>SĂN DEAL HOT</span>
                            </div>
                            <img src="{{ asset('images/icon/fire-3d-icon-png-download-12328451.png') }}" 
                                 alt="Fire" style="width: 20px; height: 20px; object-fit: contain; opacity: 0.9;">
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- CENTER: PURE IMAGE SLIDER (3.5s INTERVAL) -->
        <div class="col-12 col-md-grow hero-column-elite d-flex flex-column h-auto">
            <div class="bg-white rounded-3 shadow-sm h-100 overflow-hidden d-flex flex-column border border-light">
                <div id="heroCarousel" class="carousel slide h-100" data-bs-ride="carousel" data-bs-interval="3500" data-bs-pause="false">
                    <!-- SMALL DOTS INDICATORS -->
                    <div class="carousel-indicators elite-dots">
                        @foreach($slides as $slide)
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></button>
                        @endforeach
                    </div>

                    <div class="carousel-inner h-100">
                        @foreach($slides as $slide)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }} h-100">
                            @if($slide->link)
                                <a href="{{ $slide->link }}">
                                    <img src="{{ asset($slide->image) }}" class="d-block w-100 h-100 object-fit-cover" alt="Elite Gear Slide">
                                </a>
                            @else
                                <img src="{{ asset($slide->image) }}" class="d-block w-100 h-100 object-fit-cover" alt="Elite Gear Slide">
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-prev half-circle prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="carousel-control-next half-circle next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- RIGHT: 3 BANNERS -->
        <div class="col-12 col-md-auto banners-column-elite d-flex flex-column h-auto">
            <div class="banners-wrapper-elite flex-grow-1 d-flex flex-column gap-2 h-100">
                @php 
                    $rightBanners = ['right_1', 'right_2', 'right_3']; 
                @endphp
                @foreach($rightBanners as $pos)
                    @php $b = $banners->where('position', $pos)->first(); @endphp
                    @if($b)
                        <a href="{{ $b->link ?? '#' }}" class="banner-right-elite rounded-3 overflow-hidden flex-fill">
                            <img src="{{ asset($b->image) }}" class="w-100 h-100 object-fit-cover" alt="Elite Banner Right">
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- MID-PAGE PROMO BANNER (ELITE) -->
<div class="container mt-4">
    @php $hb = $banners->where('position', 'horizontal_middle')->first(); @endphp
    @if($hb)
    <a href="{{ $hb->link ?? '#' }}" class="d-block banner-promo-elite rounded-4 overflow-hidden shadow-sm border-0">
        <img src="{{ asset($hb->image) }}" 
             class="w-100 d-block shadow-sm" 
             alt="Promotion Banner">
    </a>
    @endif
</div>

<style>
    .banner-promo-elite {
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: block;
        width: 100%;
    }
    .banner-promo-elite img {
        width: 100%;
        display: block;
        object-fit: fill;
        height: 140px; /* Default height */
        transition: transform 0.5s ease;
        image-rendering: -webkit-optimize-contrast;
    }
    .banner-promo-elite:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1) !important;
    }
    .banner-promo-elite:hover img {
        transform: scale(1.02);
    }
    @media (max-width: 991.98px) {
        .banner-promo-elite img { height: 100px; }
    }
    @media (max-width: 767.98px) {
        .banner-promo-elite img { height: 70px; }
        .banner-promo-elite:active { transform: scale(0.98); }
    }
    /* RESPONSIVE WIDTHS & HEIGHTS FOR ELITE HERO GRID */
    @media (min-width: 1200px) {
        .sidebar-column-elite { width: 19.5% !important; }
        .hero-column-elite { width: 61% !important; }
        .banners-column-elite { width: 19.5% !important; }
        .hero-row-elite { height: 500px; }
    }

    @media (max-width: 1199.98px) {
        .hero-column-elite { width: 75% !important; }
        .banners-column-elite { width: 25% !important; }
        #heroCarousel, .banners-wrapper-elite { height: 380px !important; }
        .banner-right-elite img { object-fit: fill !important; } /* Giảm zoom, hiện toàn bộ ảnh */
    }

    @media (max-width: 991.98px) {
        #heroCarousel, .banners-wrapper-elite { height: 300px !important; }
    }

    @media (max-width: 767.98px) {
        .hero-column-elite, .banners-column-elite { width: 100% !important; }
        .banners-wrapper-elite { 
            flex-direction: row !important;
            height: 100px !important; 
            gap: 5px !important;
        }
        #heroCarousel { 
            height: 200px !important; 
            padding: 2px;
            background: #f1f5f9;
            border-radius: 8px;
        }
        #heroCarousel img {
            border-radius: 6px;
            object-fit: cover !important;
        }
        .banner-right-elite img {
            object-fit: fill !important;
        }
    }

    .hero-row-elite { display: flex; align-items: stretch; }

    .bg-dark-elite { background-color: #0f172a; }

    /* ELITE DOT INDICATORS */
    .elite-dots { bottom: 20px; display: flex !important; align-items: center !important; justify-content: center !important; }
    .elite-dots button {
        width: 10px !important; height: 10px !important; border-radius: 50% !important;
        background-color: #fff !important; border: none !important; opacity: 0.4 !important;
        margin: 0 8px !important; transition: all 0.3s ease !important;
        box-shadow: 0 0 5px rgba(0,0,0,0.3);
    }
    .elite-dots button.active { background-color: var(--accent-orange) !important; opacity: 1 !important; transform: scale(1.4); }

    .half-circle {
        width: 45px; height: 90px; background: rgba(15, 23, 42, 0.4);
        position: absolute; top: 50%; transform: translateY(-50%);
        border: none; color: white; transition: all 0.3s ease; opacity: 0;
        display: flex; align-items: center; justify-content: center; backdrop-filter: blur(5px); z-index: 10;
    }
    .half-circle.prev { left: 0; border-radius: 0 100px 100px 0; padding-right: 12px; }
    .half-circle.next { right: 0; border-radius: 100px 0 0 100px; padding-left: 12px; }
    .carousel:hover .half-circle { opacity: 1; }

    @media (max-width: 767.98px) {
        .elite-dots { bottom: 10px !important; gap: 4px !important; }
        .elite-dots button {
            width: 6px !important; height: 6px !important;
            margin: 0 3px !important;
        }
        .elite-dots button.active { transform: scale(1.2); }
        .half-circle {
            width: 30px; height: 60px; font-size: 12px;
            opacity: 0.6 !important; /* Always show a bit on mobile for touch */
        }
        .half-circle.prev { padding-right: 8px; }
        .half-circle.next { padding-left: 8px; }
    }

    .banner-right-elite { display: block; transition: all 0.4s ease; }
    .banner-right-elite:hover { transform: scale(1.03); z-index: 5; }

    .category-item-elite { 
        display: flex; align-items: center; justify-content: space-between; 
        padding: 11px 18px; color: #1e293b; text-decoration: none !important; 
        font-weight: 500; font-size: 13px; border-bottom: 1px solid rgba(0,0,0,0.03); 
        transition: all 0.2s ease;
    }
    .category-item-elite:hover { background: #f1f5f9; color: var(--accent-orange); border-left: 3px solid var(--accent-orange); }

    /* SIDEBAR SPOTLIGHT ANIMATION */
    .highlight-sidebar-elite {
        animation: sidebarGlowElite 2.5s ease-in-out;
    }
    @keyframes sidebarGlowElite {
        0% { box-shadow: 0 0 0 rgba(249, 115, 22, 0); transform: scale(1); }
        30% { box-shadow: 0 0 50px rgba(249, 115, 22, 0.8); transform: scale(1.03); border-color: var(--accent-orange); }
        100% { box-shadow: 0 4px 12px rgba(0,0,0,0.05); transform: scale(1); }
    }
    .flash-sale-container-elite {
        position: relative;
        background: #fff;
        border: 8px solid transparent; /* Trả về 8px theo đúng lệnh của bạn */
        background-image: linear-gradient(#fff, #fff), linear-gradient(135deg, #f97316 0%, #ef4444 100%);
        background-origin: border-box;
        background-clip: content-box, border-box;
        box-shadow: 0 10px 30px rgba(239, 68, 68, 0.08) !important;
        transition: all 0.4s ease;
    }
    .flash-sale-container-elite:hover {
        box-shadow: 0 20px 50px rgba(239, 68, 68, 0.2) !important;
        transform: translateY(-4px);
    }
    .gift-deco {
        position: absolute;
        top: -30px; /* Đẩy cao hẳn lên để lộ ra ngoài viền */
        font-size: 45px; /* Tăng kích thước hộp quà cho tương xứng với viền dày */
        background: linear-gradient(135deg, #f97316, #ef4444);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        filter: drop-shadow(0 4px 6px rgba(0,0,0,0.1));
        z-index: 10;
        animation: giftBounce 2s infinite ease-in-out;
    }
    @keyframes giftBounce {
        0%, 100% { transform: translateY(0) rotate(0); }
        50% { transform: translateY(-5px) rotate(10deg); }
    }
    .keyboard-section-elite {
        position: relative;
        background: #fff;
        border: 4px solid transparent; 
        background-image: linear-gradient(#fff, #fff), linear-gradient(135deg, #0f172a 0%, #334155 100%);
        background-origin: border-box;
        background-clip: content-box, border-box;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08) !important;
        transition: all 0.4s ease;
        width: 100%;
    }

    @media (max-width: 767.98px) {
        .keyboard-section-elite .px-4.py-3 {
            padding: 15px 12px !important;
            flex-direction: column;
            align-items: center !important;
            text-align: center;
            gap: 12px;
        }
        .keyboard-section-elite .px-4.py-3 .d-flex.align-items-center {
            flex-direction: column;
            gap: 8px !important;
        }
        .keyboard-section-elite h2 {
            font-size: 16px !important;
        }
        .keyboard-section-elite .btn-outline-dark {
            width: 100%;
            font-size: 12px !important;
            padding: 8px 15px !important;
        }
        .keyboard-section-elite .p-4 { padding: 12px !important; }
        
        .card-product-elite .card-body { padding: 10px !important; }
        .card-product-elite h6 { font-size: 13px !important; margin-bottom: 5px !important; }
        .card-product-elite .product-price-elite { font-size: 14px !important; margin-bottom: 10px !important; }
        .card-product-elite .btn-elite-secondary { 
            padding: 6px 8px !important; 
            font-size: 10px !important;
            flex: 1;
            justify-content: center;
        }
        .card-product-elite .btn-elite-buy { 
            font-size: 12px !important; 
            padding: 8px !important;
        }
    }
</style>

@php
    $flashEndCarbon = $flashSaleEnd ? \Carbon\Carbon::parse($flashSaleEnd) : null;
    $isLive = $flashEndCarbon && $flashEndCarbon->isFuture();
    $targetTimeProp = $isLive ? $flashEndCarbon->format('Y-m-d\TH:i:s') : '';
@endphp

@if($flashSaleProducts->count() > 0 && $isLive)
<div class="container mt-5">
    <div id="flash-sale" class="mb-5 rounded-4 shadow-sm flash-sale-container-elite bg-white position-relative">
        <!-- DECORATIVE GIFTS -->
        <i class="fas fa-gift gift-deco" style="left: 20px;"></i>
        <i class="fas fa-gift gift-deco" style="right: 20px;"></i>
        <!-- PREMIUM FLASH SALE HEADER -->
        <div class="d-flex align-items-center justify-content-between px-4 py-3 mb-1" 
             style="background: linear-gradient(90deg, #fff5f5 0%, #ffffff 50%, #fff5f5 100%); border-bottom: 2px solid #fee2e2; border-radius: 16px 16px 0 0;">
            
            <div class="d-flex align-items-center gap-3">
                <div class="position-relative">
                    <img src="{{ asset('images/icon/pngtree-3d-lightning-icon-flash-sale-listrik-petir-png-image_17854619.webp') }}" 
                         alt="Flash Sale" class="flash-pulse" style="width: 42px; height: 42px; object-fit: contain; filter: drop-shadow(0 4px 8px rgba(249, 115, 22, 0.3));">
                </div>
                <div>
                    <h2 class="fw-black mb-0 text-uppercase" 
                        style="font-family: 'Outfit', sans-serif; font-size: 26px; background: linear-gradient(135deg, #ef4444, #f97316); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: -1px;">
                        FLASH SALE
                    </h2>
                </div>
            </div>

            <div class="d-flex align-items-center gap-3">
                <p class="mb-0 text-muted fw-bold d-none d-sm-block" style="font-size: 11px; letter-spacing: 1px;">KẾT THÚC SAU:</p>
                <div id="countdown" class="d-flex gap-2 align-items-center">
                    <div class="text-center">
                        <span id="hours" class="d-flex align-items-center justify-content-center fw-black rounded-3 shadow-sm text-white" 
                              style="width: 42px; height: 42px; background: #1e293b; font-size: 18px;">00</span>
                    </div>
                    <span class="fw-bold fs-5 text-dark">:</span>
                    <div class="text-center">
                        <span id="minutes" class="d-flex align-items-center justify-content-center fw-black rounded-3 shadow-sm text-white" 
                              style="width: 42px; height: 42px; background: #1e293b; font-size: 18px;">00</span>
                    </div>
                    <span class="fw-bold fs-5 text-dark">:</span>
                    <div class="text-center">
                        <span id="seconds" class="d-flex align-items-center justify-content-center fw-black rounded-3 shadow-sm text-white position-relative" 
                              style="width: 42px; height: 42px; background: #ef4444; font-size: 18px; box-shadow: 0 0 15px rgba(239, 68, 68, 0.4) !important;">
                            00
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-4">
        <div class="row g-3 g-md-4">
            @foreach($flashSaleProducts as $product)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card card-product-elite card-product-flash h-100 shadow-sm border-0">
                    <!-- Flash Badge -->
                    <div class="badge-flash-elite">
                        <i class="fas fa-bolt"></i> FLASH SALE
                    </div>

                    <div class="product-img-wrapper" style="aspect-ratio: 1/1;">
                        <a href="{{ route('products.show', $product->slug) }}">
                            <img src="{{ $product->image ?? 'https://via.placeholder.com/400x400' }}" class="w-100 h-100 object-fit-contain p-3" alt="{{ $product->name }}">
                        </a>
                    </div>
                    
                    <div class="card-body p-3 d-flex flex-column">
                        <p class="text-muted small mb-1 text-uppercase fw-bold opacity-75">Limited Edition</p>
                        <h6 class="fw-bold text-dark text-truncate mb-2" title="{{ $product->name }}">{{ $product->name }}</h6>
                        
                        <div class="flash-price-row mb-3">
                            @if((float)$product->sale_price > 0 && $product->sale_price < $product->price)
                                <span class="product-price-elite text-danger">{{ number_format($product->sale_price, 0, ',', '.') }} VNĐ</span>
                                <span class="flash-price-strike">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                            @else
                                <span class="product-price-elite text-dark">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                            @endif
                        </div>

                        <!-- Flash Stock Progress -->
                        @php 
                            $sold = $product->sold_count ?? 0; 
                            $total = $sold + $product->stock; 
                            $percent = $total > 0 ? round(($sold / $total) * 100) : 0;
                        @endphp
                        <div class="flash-stock-info mb-4">
                            <div class="stock-text-elite">
                                <span>Đã bán: <b>{{ $sold }}</b></span>
                                <span>Còn: <b>{{ $product->stock }}</b></span>
                            </div>
                            <div class="stock-progress-container">
                                <div class="stock-progress-bar" style="width: {{ $percent }}%;"></div>
                            </div>
                        </div>

                        <div class="d-flex flex-column gap-2 mt-auto">
                            <div class="d-flex gap-2">
                                <a href="{{ route('products.show', $product->slug) }}" class="btn-elite-secondary">
                                    <i class="fas fa-eye"></i> Chi tiết
                                </a>
                                <button class="btn-elite-secondary" onclick="addToCartElite({{ $product->id }}, '{{ route('cart.add', $product->id) }}', event, '{{ $product->image ?? asset('images/placeholder.jpg') }}')">
                                    <i class="fas fa-cart-plus"></i> + Giỏ
                                </button>
                            </div>
                            <a href="javascript:void(0)" onclick="addToCartElite({{ $product->id }}, '{{ route('cart.add', $product->id) }}', event, '{{ $product->image ?? asset('images/placeholder.jpg') }}', true)" class="btn-flash-buy w-100 shadow-sm text-decoration-none">
                                <i class="fas fa-bolt"></i> Mua Ngay
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
</div> <!-- Đóng container của Flash Sale ở đây để khối dưới không bị thụt vào -->
@endif

<!-- SECTION: BÀN PHÍM CƠ CHUYÊN NGHIỆP (ELITE) -->
@php $kbdProducts = $allProducts->filter(fn($p) => $p->category && $p->category->slug == 'ban-phim-co')->take(8); @endphp
@if($kbdProducts->count() > 0)
<div class="container mt-5 mb-5">
    <div class="keyboard-section-elite rounded-4 shadow-sm bg-white overflow-hidden">
        <!-- HEADER CÙNG KIỂU FLASH SALE -->
        <div class="d-flex align-items-center justify-content-between px-4 py-3 bg-light border-bottom border-light" style="background: #f8fafc !important; border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white rounded-3 shadow-sm p-1 border border-light">
                    <img src="{{ asset('images/icon/vecteezy_ergonomic-mechanical-keyboard-with-custom-keycaps-for_60514914.png') }}" 
                         alt="Keyboard Icon" style="width: 42px; height: 42px; object-fit: contain;">
                </div>
                <div>
                    <h2 class="fw-bold mb-0 text-uppercase" style="font-size: 20px; color: #1e293b; letter-spacing: -0.5px;">Bàn phím cơ chuyên nghiệp</h2>
                </div>
            </div>
            <a href="{{ route('categories.show', 'ban-phim-co') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold small transition-all hover-scale">Xem tất cả <i class="fas fa-arrow-right ms-1"></i></a>
        </div>

        <div class="p-4">
            <div class="row g-3 g-md-4">
                @foreach($kbdProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card card-product-elite h-100 shadow-sm border-0">
                        <div class="product-img-wrapper" style="aspect-ratio: 1/1;">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->image ?? 'https://via.placeholder.com/400x400' }}" class="w-100 h-100 object-fit-contain p-3" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <div class="card-body p-3 d-flex flex-column">
                            <p class="text-muted small mb-1 text-uppercase fw-bold opacity-75">Mechanical Gear</p>
                            <h6 class="fw-bold text-dark text-truncate mb-2" title="{{ $product->name }}">{{ $product->name }}</h6>
                            <div class="product-price-elite mb-3">
                                @if($product->is_flash_sale && (float)$product->sale_price > 0 && $product->sale_price < $product->price)
                                    <span class="text-danger fw-black">{{ number_format($product->sale_price, 0, ',', '.') }} VNĐ</span>
                                    <span class="text-muted text-decoration-line-through x-small ms-1">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                @else
                                    <span class="text-dark fw-black">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                @endif
                            </div>
                            <div class="d-flex flex-column gap-2 mt-auto">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn-elite-secondary">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </a>
                                <button class="btn-elite-secondary" onclick="addToCartElite({{ $product->id }}, '{{ route('cart.add', $product->id) }}', event, '{{ $product->image ?? asset('images/placeholder.jpg') }}')">
                                    <i class="fas fa-cart-plus"></i> + Giỏ
                                </button>
                                </div>
                                <a href="javascript:void(0)" onclick="addToCartElite({{ $product->id }}, '{{ route('cart.add', $product->id) }}', event, '{{ $product->image ?? asset('images/placeholder.jpg') }}', true)" class="btn btn-elite-buy w-100 shadow-sm">Mua Ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- SECTION: CHUỘT GAMING (2 HÀNG) -->
@php $mouseProducts = $allProducts->filter(fn($p) => $p->category && $p->category->slug == 'chuot-gaming')->take(8); @endphp
@if($mouseProducts->count() > 0)
<div class="container mt-5 mb-5">
    <div class="keyboard-section-elite rounded-4 shadow-sm bg-white overflow-hidden">
        <div class="d-flex align-items-center justify-content-between px-4 py-3 bg-light border-bottom border-light" style="background: #f8fafc !important; border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white rounded-3 shadow-sm p-1 border border-light">
                    <img src="{{ asset('images/icon/gaming-mouse-3d-icon-png-download-9675855.webp') }}" 
                         alt="Mouse Icon" style="width: 42px; height: 42px; object-fit: contain;">
                </div>
                <div>
                    <h2 class="fw-bold mb-0 text-uppercase" style="font-size: 20px; color: #1e293b; letter-spacing: -0.5px;">Chuột Gaming Cao Cấp</h2>
                </div>
            </div>
            <a href="{{ route('categories.show', 'chuot-gaming') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold small transition-all hover-scale">Xem tất cả <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="p-4">
            <div class="row g-3 g-md-4">
                @foreach($mouseProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card card-product-elite h-100 shadow-sm border-0">
                        <div class="product-img-wrapper" style="aspect-ratio: 1/1;">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->image ?? 'https://via.placeholder.com/400x400' }}" class="w-100 h-100 object-fit-contain p-3" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <div class="card-body p-3 d-flex flex-column">
                            <p class="text-muted small mb-1 text-uppercase fw-bold opacity-75">Gaming Mouse</p>
                            <h6 class="fw-bold text-dark text-truncate mb-2" title="{{ $product->name }}">{{ $product->name }}</h6>
                            <div class="product-price-elite mb-3">
                                @if($product->is_flash_sale && (float)$product->sale_price > 0 && $product->sale_price < $product->price)
                                    <span class="text-danger fw-black">{{ number_format($product->sale_price, 0, ',', '.') }} VNĐ</span>
                                    <span class="text-muted text-decoration-line-through x-small ms-1">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                @else
                                    <span class="text-dark fw-black">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                @endif
                            </div>
                            <div class="d-flex flex-column gap-2 mt-auto">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn-elite-secondary">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </a>
                                <button class="btn-elite-secondary" onclick="addToCartElite({{ $product->id }}, '{{ route('cart.add', $product->id) }}', event, '{{ $product->image ?? asset('images/placeholder.jpg') }}')">
                                    <i class="fas fa-cart-plus"></i> + Giỏ
                                </button>
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-elite-buy w-100 shadow-sm">Mua Ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- SECTION: MÀN HÌNH ĐỒ HỌA (2 HÀNG) -->
@php $monitorProducts = $allProducts->filter(fn($p) => $p->category && $p->category->slug == 'man-hinh-do-hoa')->take(8); @endphp
@if($monitorProducts->count() > 0)
<div class="container mt-5 mb-5">
    <div class="keyboard-section-elite rounded-4 shadow-sm bg-white overflow-hidden">
        <div class="d-flex align-items-center justify-content-between px-4 py-3 bg-light border-bottom border-light" style="background: #f8fafc !important; border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white rounded-3 shadow-sm p-1 border border-light">
                    <img src="{{ asset('images/icon/premium-computer-parts-display-monitor-icon-3d-rendering-isolated-background_150525-4565.png') }}" 
                         alt="Monitor Icon" style="width: 42px; height: 42px; object-fit: contain;">
                </div>
                <div>
                    <h2 class="fw-bold mb-0 text-uppercase" style="font-size: 20px; color: #1e293b; letter-spacing: -0.5px;">Màn hình đồ họa chuẩn màu</h2>
                </div>
            </div>
            <a href="{{ route('categories.show', 'man-hinh-do-hoa') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold small transition-all hover-scale">Xem tất cả <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="p-4">
            <div class="row g-3 g-md-4">
                @foreach($monitorProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card card-product-elite h-100 shadow-sm border-0">
                        <div class="product-img-wrapper" style="aspect-ratio: 1/1;">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->image ?? 'https://via.placeholder.com/400x400' }}" class="w-100 h-100 object-fit-contain p-3" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <div class="card-body p-3 d-flex flex-column">
                            <p class="text-muted small mb-1 text-uppercase fw-bold opacity-75">Professional Monitor</p>
                            <h6 class="fw-bold text-dark text-truncate mb-2" title="{{ $product->name }}">{{ $product->name }}</h6>
                            <div class="product-price-elite mb-3">
                                @if($product->is_flash_sale && (float)$product->sale_price > 0 && $product->sale_price < $product->price)
                                    <span class="text-danger fw-black">{{ number_format($product->sale_price, 0, ',', '.') }} VNĐ</span>
                                    <span class="text-muted text-decoration-line-through x-small ms-1">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                @else
                                    <span class="text-dark fw-black">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                @endif
                            </div>
                            <div class="d-flex flex-column gap-2 mt-auto">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn-elite-secondary">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </a>
                                <button class="btn-elite-secondary" onclick="addToCartElite({{ $product->id }}, '{{ route('cart.add', $product->id) }}', event, '{{ $product->image ?? asset('images/placeholder.jpg') }}')">
                                    <i class="fas fa-cart-plus"></i> + Giỏ
                                </button>
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-elite-buy w-100 shadow-sm">Mua Ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- SECTION: LAPTOP GAMING (2 HÀNG) -->
@php $laptopProducts = $allProducts->filter(fn($p) => $p->category && $p->category->slug == 'laptop-gaming')->take(8); @endphp
@if($laptopProducts->count() > 0)
<div class="container mt-5 mb-5">
    <div class="keyboard-section-elite rounded-4 shadow-sm bg-white overflow-hidden">
        <div class="d-flex align-items-center justify-content-between px-4 py-3 bg-light border-bottom border-light" style="background: #f8fafc !important; border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white rounded-3 shadow-sm p-1 border border-light">
                    <img src="{{ asset('images/icon/laptop-gaming-3d-icon-png-download-11431625.webp') }}" 
                         alt="Laptop Icon" style="width: 42px; height: 42px; object-fit: contain;">
                </div>
                <div>
                    <h2 class="fw-bold mb-0 text-uppercase" style="font-size: 20px; color: #1e293b; letter-spacing: -0.5px;">Laptop Gaming Power</h2>
                </div>
            </div>
            <a href="{{ route('categories.show', 'laptop-gaming') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold small transition-all hover-scale">Xem tất cả <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="p-4">
            <div class="row g-3 g-md-4">
                @foreach($laptopProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card card-product-elite h-100 shadow-sm border-0">
                        <div class="product-img-wrapper" style="aspect-ratio: 1/1;">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->image ?? 'https://via.placeholder.com/400x400' }}" class="w-100 h-100 object-fit-contain p-3" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <div class="card-body p-3 d-flex flex-column">
                            <p class="text-muted small mb-1 text-uppercase fw-bold opacity-75">Gaming Laptop</p>
                            <h6 class="fw-bold text-dark text-truncate mb-2" title="{{ $product->name }}">{{ $product->name }}</h6>
                            <div class="product-price-elite mb-3">
                                @if($product->is_flash_sale && (float)$product->sale_price > 0 && $product->sale_price < $product->price)
                                    <span class="text-danger fw-black">{{ number_format($product->sale_price, 0, ',', '.') }} VNĐ</span>
                                    <span class="text-muted text-decoration-line-through x-small ms-1">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                @else
                                    <span class="text-dark fw-black">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                @endif
                            </div>
                            <div class="d-flex flex-column gap-2 mt-auto">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn-elite-secondary">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </a>
                                <button class="btn-elite-secondary" onclick="addToCartElite({{ $product->id }}, '{{ route('cart.add', $product->id) }}', event, '{{ $product->image ?? asset('images/placeholder.jpg') }}')">
                                    <i class="fas fa-cart-plus"></i> + Giỏ
                                </button>
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-elite-buy w-100 shadow-sm">Mua Ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- SECTION: ÂM THANH & LOA (1 HÀNG) -->
@php $audioProducts = $allProducts->filter(fn($p) => $p->category && $p->category->slug == 'am-thanh-loa')->take(4); @endphp
@if($audioProducts->count() > 0)
<div class="container mt-5 mb-5">
    <div class="keyboard-section-elite rounded-4 shadow-sm bg-white overflow-hidden">
        <div class="d-flex align-items-center justify-content-between px-4 py-3 bg-light border-bottom border-light" style="background: #f8fafc !important; border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white rounded-3 shadow-sm p-1 border border-light">
                    <img src="{{ asset('images/icon/audio-icon-concept-with-3d-cartoon-style-headphone-and-blue-speaker-3d-illustration-png.png') }}" 
                         alt="Audio Icon" style="width: 42px; height: 42px; object-fit: contain;">
                </div>
                <div>
                    <h2 class="fw-bold mb-0 text-uppercase" style="font-size: 20px; color: #1e293b; letter-spacing: -0.5px;">Âm thanh & Loa</h2>
                </div>
            </div>
            <a href="{{ route('categories.show', 'am-thanh-loa') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold small transition-all hover-scale">Xem tất cả <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="p-4">
            <div class="row g-3 g-md-4">
                @foreach($audioProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card card-product-elite h-100 shadow-sm border-0">
                        <div class="product-img-wrapper" style="aspect-ratio: 1/1;">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->image ?? 'https://via.placeholder.com/400x400' }}" class="w-100 h-100 object-fit-contain p-3" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <div class="card-body p-3 d-flex flex-column">
                            <p class="text-muted small mb-1 text-uppercase fw-bold opacity-75">Audio Gear</p>
                            <h6 class="fw-bold text-dark text-truncate mb-2" title="{{ $product->name }}">{{ $product->name }}</h6>
                            <div class="product-price-elite mb-3">
                                @if($product->is_flash_sale && (float)$product->sale_price > 0 && $product->sale_price < $product->price)
                                    <span class="text-danger fw-black">{{ number_format($product->sale_price, 0, ',', '.') }} VNĐ</span>
                                    <span class="text-muted text-decoration-line-through x-small ms-1">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                @else
                                    <span class="text-dark fw-black">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                @endif
                            </div>
                            <div class="d-flex flex-column gap-2 mt-auto">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn-elite-secondary">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </a>
                                <button class="btn-elite-secondary" onclick="addToCartElite({{ $product->id }}, '{{ route('cart.add', $product->id) }}', event, '{{ $product->image ?? asset('images/placeholder.jpg') }}')">
                                    <i class="fas fa-cart-plus"></i> + Giỏ
                                </button>
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-elite-buy w-100 shadow-sm">Mua Ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- SECTION: LÓT CHUỘT GEAR (1 HÀNG) -->
@php $padProducts = $allProducts->filter(fn($p) => $p->category && $p->category->slug == 'lot-chuot-gear')->take(4); @endphp
@if($padProducts->count() > 0)
<div class="container mt-5 mb-5">
    <div class="keyboard-section-elite rounded-4 shadow-sm bg-white overflow-hidden">
        <div class="d-flex align-items-center justify-content-between px-4 py-3 bg-light border-bottom border-light" style="background: #f8fafc !important; border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white rounded-3 shadow-sm p-1 border border-light">
                    <img src="{{ asset('images/icon/ai-gaming-mouse-pad-3d-icon-png-download-jpg-13387054.webp') }}" 
                         alt="Mousepad Icon" style="width: 42px; height: 42px; object-fit: contain;">
                </div>
                <div>
                    <h2 class="fw-bold mb-0 text-uppercase" style="font-size: 20px; color: #1e293b; letter-spacing: -0.5px;">Lót chuột Gear Precision</h2>
                </div>
            </div>
            <a href="{{ route('categories.show', 'lot-chuot-gear') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold small transition-all hover-scale">Xem tất cả <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="p-4">
            <div class="row g-3 g-md-4">
                @foreach($allProducts->filter(fn($p) => $p->category && $p->category->slug == 'lot-chuot-gear')->take(4) as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card card-product-elite h-100 shadow-sm border-0">
                        <div class="product-img-wrapper" style="aspect-ratio: 1/1;">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->image ?? 'https://via.placeholder.com/400x400' }}" class="w-100 h-100 object-fit-contain p-3" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <div class="card-body p-3 d-flex flex-column">
                            <p class="text-muted small mb-1 text-uppercase fw-bold opacity-75">Gaming Pad</p>
                            <h6 class="fw-bold text-dark text-truncate mb-2" title="{{ $product->name }}">{{ $product->name }}</h6>
                            <div class="product-price-elite mb-3">
                                @if($product->is_flash_sale && (float)$product->sale_price > 0 && $product->sale_price < $product->price)
                                    <span class="text-danger fw-black">{{ number_format($product->sale_price, 0, ',', '.') }} VNĐ</span>
                                    <span class="text-muted text-decoration-line-through x-small ms-1">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                @else
                                    <span class="text-dark fw-black">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                @endif
                            </div>
                            <div class="d-flex flex-column gap-2 mt-auto">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn-elite-secondary">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </a>
                                <button class="btn-elite-secondary" onclick="addToCartElite({{ $product->id }}, '{{ route('cart.add', $product->id) }}', event, '{{ $product->image ?? asset('images/placeholder.jpg') }}')">
                                    <i class="fas fa-cart-plus"></i> + Giỏ
                                </button>
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-elite-buy w-100 shadow-sm">Mua Ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- SECTION: KEYCAPS & SWITCH (1 HÀNG) -->
@php $keycapProducts = $allProducts->filter(fn($p) => $p->category && $p->category->slug == 'keycaps-switch')->take(4); @endphp
@if($keycapProducts->count() > 0)
<div class="container mt-5 mb-5">
    <div class="keyboard-section-elite rounded-4 shadow-sm bg-white overflow-hidden">
        <div class="d-flex align-items-center justify-content-between px-4 py-3 bg-light border-bottom border-light" style="background: #f8fafc !important; border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white rounded-3 shadow-sm p-1 border border-light">
                    <img src="{{ asset('images/icon/keycap-p-3d-icon-png-download-13964981.png') }}" 
                         alt="Keycap Icon" style="width: 42px; height: 42px; object-fit: contain;">
                </div>
                <div>
                    <h2 class="fw-bold mb-0 text-uppercase" style="font-size: 20px; color: #1e293b; letter-spacing: -0.5px;">Keycaps & Switch Layout</h2>
                </div>
            </div>
            <a href="{{ route('categories.show', 'keycaps-switch') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold small transition-all hover-scale">Xem tất cả <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="p-4">
            <div class="row g-3 g-md-4">
                @foreach($keycapProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card card-product-elite h-100 shadow-sm border-0">
                        <div class="product-img-wrapper" style="aspect-ratio: 1/1;">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->image ?? 'https://via.placeholder.com/400x400' }}" class="w-100 h-100 object-fit-contain p-3" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <div class="card-body p-3 d-flex flex-column">
                            <p class="text-muted small mb-1 text-uppercase fw-bold opacity-75">Custom Parts</p>
                            <h6 class="fw-bold text-dark text-truncate mb-2" title="{{ $product->name }}">{{ $product->name }}</h6>
                            <div class="product-price-elite mb-3">
                                @if($product->is_flash_sale && (float)$product->sale_price > 0 && $product->sale_price < $product->price)
                                    <span class="text-danger fw-black">{{ number_format($product->sale_price, 0, ',', '.') }} VNĐ</span>
                                    <span class="text-muted text-decoration-line-through x-small ms-1">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                @else
                                    <span class="text-dark fw-black">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                @endif
                            </div>
                            <div class="d-flex flex-column gap-2 mt-auto">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn-elite-secondary">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </a>
                                <button class="btn-elite-secondary" onclick="addToCartElite({{ $product->id }}, '{{ route('cart.add', $product->id) }}', event, '{{ $product->image ?? asset('images/placeholder.jpg') }}')">
                                    <i class="fas fa-cart-plus"></i> + Giỏ
                                </button>
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-elite-buy w-100 shadow-sm">Mua Ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- SECTION: GHẾ CÔNG THÁI HỌC (1 HÀNG) -->
@php $chairProducts = $allProducts->filter(fn($p) => $p->category && $p->category->slug == 'ghe-cong-thai-hoc')->take(4); @endphp
@if($chairProducts->count() > 0)
<div class="container mt-5 mb-5">
    <div class="keyboard-section-elite rounded-4 shadow-sm bg-white overflow-hidden">
        <div class="d-flex align-items-center justify-content-between px-4 py-3 bg-light border-bottom border-light" style="background: #f8fafc !important; border-radius: 12px 12px 0 0;">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-white rounded-3 shadow-sm p-1 border border-light">
                    <img src="{{ asset('images/icon/gaming-chair-3d-illustration-office-equipment-icon-png.png') }}" 
                         alt="Chair Icon" style="width: 42px; height: 42px; object-fit: contain;">
                </div>
                <div>
                    <h2 class="fw-bold mb-0 text-uppercase" style="font-size: 20px; color: #1e293b; letter-spacing: -0.5px;">Ghế công thái học</h2>
                </div>
            </div>
            <a href="{{ route('categories.show', 'ghe-cong-thai-hoc') }}" class="btn btn-outline-dark rounded-pill px-4 fw-bold small transition-all hover-scale">Xem tất cả <i class="fas fa-arrow-right ms-1"></i></a>
        </div>
        <div class="p-4">
            <div class="row g-3 g-md-4">
                @foreach($chairProducts as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card card-product-elite h-100 shadow-sm border-0">
                        <div class="product-img-wrapper" style="aspect-ratio: 1/1;">
                            <a href="{{ route('products.show', $product->slug) }}">
                                <img src="{{ $product->image ?? 'https://via.placeholder.com/400x400' }}" class="w-100 h-100 object-fit-contain p-3" alt="{{ $product->name }}">
                            </a>
                        </div>
                        <div class="card-body p-3 d-flex flex-column">
                            <p class="text-muted small mb-1 text-uppercase fw-bold opacity-75">Ergo Chair</p>
                            <h6 class="fw-bold text-dark text-truncate mb-2" title="{{ $product->name }}">{{ $product->name }}</h6>
                            <div class="product-price-elite mb-3">
                                @if($product->is_flash_sale && (float)$product->sale_price > 0 && $product->sale_price < $product->price)
                                    <span class="text-danger fw-black">{{ number_format($product->sale_price, 0, ',', '.') }} VNĐ</span>
                                    <span class="text-muted text-decoration-line-through x-small ms-1">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                @else
                                    <span class="text-dark fw-black">{{ number_format($product->price, 0, ',', '.') }} VNĐ</span>
                                @endif
                            </div>
                            <div class="d-flex flex-column gap-2 mt-auto">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('products.show', $product->slug) }}" class="btn-elite-secondary">
                                        <i class="fas fa-eye"></i> Chi tiết
                                    </a>
                                <button class="btn-elite-secondary" onclick="addToCartElite({{ $product->id }}, '{{ route('cart.add', $product->id) }}', event, '{{ $product->image ?? asset('images/placeholder.jpg') }}')">
                                    <i class="fas fa-cart-plus"></i> + Giỏ
                                </button>
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-elite-buy w-100 shadow-sm">Mua Ngay</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
@endif

<!-- SECTION: TIN TỨC CÔNG NGHỆ (KHÔNG VIỀN) -->
<div class="container mt-5 mb-5 pb-lg-5">
    <div class="d-flex align-items-center justify-content-between mb-4 section-news-header-elite">
        <div class="d-flex align-items-center gap-3">
            <h2 class="fw-bold mb-0 text-uppercase h2-news-elite" style="font-size: 24px; color: #0f172a; letter-spacing: -1px;">Tin tức công nghệ</h2>
            <div class="news-line-elite" style="width: 50px; height: 3px; background: #ef4444; border-radius: 2px;"></div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('posts.index') }}" class="btn btn-link text-dark fw-bold text-decoration-none p-0 news-all-link">Xem tất cả <i class="fas fa-chevron-right ms-1 small"></i></a>
        </div>
    </div>

    <div class="row g-4">
        @forelse($posts as $post)
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 h-100 bg-transparent post-card-elite">
                <div class="rounded-4 overflow-hidden mb-3 shadow-sm post-thumb-wrapper" style="aspect-ratio: 16/10;">
                    <img src="{{ $post->thumbnail ? (Str::startsWith($post->thumbnail, 'http') ? $post->thumbnail : asset($post->thumbnail)) : 'https://via.placeholder.com/500x310?text=News' }}" 
                         class="w-100 h-100 object-fit-cover transition-all hover-zoom-slow" 
                         alt="{{ $post->title }}">
                </div>
                <div class="card-body p-0">
                    <span class="text-danger small fw-bold text-uppercase mb-2 d-block post-date-elite">{{ $post->created_at->translatedFormat('d F, Y') }}</span>
                    <h5 class="fw-bold mb-2 lh-base post-title-elite" 
                        style="font-size: 17px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-dark text-decoration-none transition-all hover-text-danger">{{ $post->title }}</a>
                    </h5>
                    <p class="text-muted small mb-0 post-summary-elite" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $post->summary }}</p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p class="text-muted fw-bold">Hiện chưa có tin tức nào mới.</p>
        </div>
        @endforelse
    </div>
</div>

<style>
    @media (max-width: 767.98px) {
        .section-news-header-elite {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 12px;
        }
        .h2-news-elite { font-size: 20px !important; }
        .news-all-link { font-size: 13px !important; }
        .post-card-elite .post-title-elite { font-size: 15px !important; }
        .post-card-elite .post-summary-elite { font-size: 12.5px !important; }
    }
</style>

<style>
    .hover-zoom-slow { transition: transform 0.8s cubic-bezier(0.165, 0.84, 0.44, 1); }
    .post-card-elite:hover .hover-zoom-slow { transform: scale(1.1); }
    .hover-text-danger:hover { color: #ef4444 !important; }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const targetTime = "{{ $targetTimeProp }}";
        if(!targetTime) return;

        const hoursEl = document.getElementById('hours');
        const minutesEl = document.getElementById('minutes');
        const secondsEl = document.getElementById('seconds');
        const flashSection = document.getElementById('flash-sale');
        
        const updateCountdown = () => {
            const timeLeft = new Date(targetTime) - new Date();
            if(timeLeft <= 0) {
                if(flashSection) flashSection.style.display = 'none';
                return;
            }
            if(hoursEl) hoursEl.innerText = String(Math.floor(timeLeft/3600000)).padStart(2,'0');
            if(minutesEl) minutesEl.innerText = String(Math.floor((timeLeft%3600000)/60000)).padStart(2,'0');
            if(secondsEl) secondsEl.innerText = String(Math.floor((timeLeft%60000)/1000)).padStart(2,'0');
        };
        setInterval(updateCountdown, 1000); updateCountdown();
    });
</script>
@endpush
