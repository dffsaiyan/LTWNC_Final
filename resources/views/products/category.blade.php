@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- ELITE BREADCRUMB -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white shadow-sm rounded-pill px-4 py-2 border border-light animate-fade-in-down" style="width: fit-content; font-size: 13px;">
            <li class="breadcrumb-item d-flex align-items-center">
                <a href="{{ url('/') }}" class="text-decoration-none text-muted transition-all hover-text-warning d-flex align-items-center gap-1">
                    <i class="fas fa-home"></i> Trang chủ
                </a>
            </li>
            <li class="breadcrumb-item active fw-bold text-dark d-flex align-items-center gap-1" aria-current="page">
                <i class="fas fa-folder-open text-warning"></i> {{ $category->name }}
            </li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-12">
            <!-- CATEGORY HERO ELITE -->
            <div class="category-hero-elite rounded-4 mb-5 overflow-hidden position-relative shadow-lg border-0 animate-fade-in" style="height: 300px;">
                <div class="position-absolute top-0 start-0 w-100 h-100">
                    <img src="{{ $category->image ? asset($category->image) : asset('images/keyboard-hero.jpg') }}" 
                         class="w-100 h-100 object-fit-cover transition-all duration-700 hover-scale-105" 
                         style="image-rendering: -webkit-optimize-contrast; object-position: center;"
                         alt="{{ $category->name }}">
                    <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(90deg, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0.4) 50%, transparent 100%);"></div>
                </div>

                <div class="position-relative h-100 d-flex align-items-center px-4 px-md-5 text-white z-2">
                    <div class="flex-grow-1 d-flex flex-column py-5" style="max-width: 65%;">
                        <div class="d-flex align-items-center gap-2 mb-3 animate-slide-in-left">
                            <span class="px-2 py-1 bg-warning text-dark fw-black small shadow-sm" style="font-size: 9px; letter-spacing: 2px; border-radius: 2px;">ELITE</span>
                            <div class="text-white opacity-50 fw-bold small border-start border-white border-opacity-25 ps-2" style="letter-spacing: 1px; font-size: 11px;">PREMIUM HARDWARE</div>
                        </div>
                        
                        <h1 class="fw-black mb-3 display-3 animate-slide-in-left text-uppercase" style="letter-spacing: -2px; color: #fff; text-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                            {{ $category->name }}
                        </h1>
                        
                        <p class="mb-4 text-white opacity-75 fw-medium animate-slide-in-left" style="font-size: 16px; max-width: 520px; line-height: 1.7; border-left: 4px solid #fbbf24; padding-left: 15px;">
                            {{ $category->description ?? 'Bộ sưu tập sản phẩm '.$category->name.' phân phối chính hãng tại Elite Electronics.' }}
                        </p>

                        <div class="d-flex flex-wrap gap-4 animate-slide-in-up">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center border border-warning border-opacity-50" style="width: 42px; height: 42px; background: rgba(251, 191, 36, 0.1);">
                                    <i class="fas fa-award text-warning"></i>
                                </div>
                                <div class="d-flex flex-column">
                                    <span class="text-white fw-black x-small text-uppercase" style="letter-spacing: 0.5px;">Chính hãng</span>
                                    <span class="text-muted" style="font-size: 9px;">100% ELITE QUALITY</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- LARGE FLOATING 3D ICON FROM CATEGORY -->
                    <div class="d-none d-lg-block flex-shrink-0 animate-float ms-auto" style="width: 320px; filter: drop-shadow(0 20px 50px rgba(0,0,0,0.5)); transform: perspective(1000px) rotateY(-10deg);">
                        <img src="{{ asset($category->icon ?: 'images/icon/gaming-mouse-3d-icon-png-download-9675855.webp') }}" class="w-100 h-100 object-fit-contain" style="image-rendering: high-quality;" alt="{{ $category->name }}">
                    </div>
                </div>
                
                <!-- Decorative Elements -->
                <div class="position-absolute bottom-0 end-0 p-4 opacity-10 d-none d-lg-block">
                    <i class="fas fa-trophy" style="font-size: 15rem; transform: rotate(-15deg);"></i>
                </div>
            </div>
            <div id="product-container-elite">
                <!-- PREMIUM FILTER BAR -->
                <form id="filterForm" action="{{ url()->current() }}" method="GET" class="mb-5">
                    <input type="hidden" name="sort" id="hiddenSort" value="{{ request('sort', 'default') }}">
                    
                    <div class="bg-white rounded-4 shadow-sm p-3 border border-light d-flex flex-wrap align-items-center gap-3">
                        <div class="d-flex flex-wrap align-items-center gap-2 flex-grow-1">
                            <div class="filter-label-elite pe-3 me-1 border-end border-light d-none d-xl-block">
                                <span class="text-uppercase small fw-bold text-muted" style="letter-spacing: 2px; font-size: 10px;">
                                    <i class="fas fa-sliders-h me-1 text-warning"></i> BỘ LỌC
                                </span>
                            </div>
                            
                            @if(in_array('price', $category->filters ?? []))
                            <!-- Price Filter -->
                            <div class="dropdown">
                                @php $selectedPrice = (array)request('price'); @endphp
                                <button class="btn btn-elite-filter dropdown-toggle {{ !empty($selectedPrice) ? 'active' : '' }}" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-money-bill-wave {{ !empty($selectedPrice) ? 'text-warning' : '' }}"></i>
                                    <span class="mx-1">Khoảng giá</span>
                                    @if(!empty($selectedPrice))
                                        <span class="badge bg-warning text-dark rounded-pill">{{ count($selectedPrice) }}</span>
                                    @endif
                                </button>
                                <div class="dropdown-menu shadow-xl border-0 rounded-4 p-4 mt-3 animate-fade-in-up" style="min-width: 260px;">
                                    <h6 class="dropdown-header px-0 text-dark fw-black mb-3 text-uppercase x-small opacity-50" style="letter-spacing: 1px;">Chọn mức ngân sách</h6>
                                    @foreach([
                                        'under_1m' => 'Dưới 1 triệu',
                                        '1_3m' => '1 - 3 triệu',
                                        '3_5m' => '3 - 5 triệu',
                                        'over_5m' => 'Trên 5 triệu'
                                    ] as $val => $label)
                                    <div class="form-check custom-elite-check">
                                        <input class="form-check-input" type="checkbox" name="price[]" value="{{ $val }}" id="price_{{ $val }}" {{ in_array($val, $selectedPrice) ? 'checked' : '' }} onchange="updateFilterAjax()">
                                        <label class="form-check-label" for="price_{{ $val }}">{{ $label }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if(in_array('brand', $category->filters ?? []))
                            <!-- Brand Filter -->
                            <div class="dropdown">
                                @php $selectedBrand = (array)request('brand'); @endphp
                                <button class="btn btn-elite-filter dropdown-toggle {{ !empty($selectedBrand) ? 'active' : '' }}" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-crown {{ !empty($selectedBrand) ? 'text-warning' : '' }}"></i>
                                    <span class="mx-1">Thương hiệu</span>
                                    @if(!empty($selectedBrand))
                                        <span class="badge bg-warning text-dark rounded-pill">{{ count($selectedBrand) }}</span>
                                    @endif
                                </button>
                                <div class="dropdown-menu shadow-xl border-0 rounded-4 p-4 mt-3 animate-fade-in-up" style="min-width: 280px;">
                                    <h6 class="dropdown-header px-0 text-dark fw-black mb-3 text-uppercase x-small opacity-50" style="letter-spacing: 1px;">Hãng sản xuất</h6>
                                    <div class="row g-2" style="max-height: 300px; overflow-y: auto;">
                                        @foreach($availableBrands as $brand)
                                        <div class="col-6">
                                            <div class="form-check custom-elite-check h-100">
                                                <input class="form-check-input" type="checkbox" name="brand[]" value="{{ $brand->id }}" id="brand_{{ $brand->id }}" {{ in_array($brand->id, $selectedBrand) ? 'checked' : '' }} onchange="updateFilterAjax()">
                                                <label class="form-check-label d-flex align-items-center gap-2" for="brand_{{ $brand->id }}">
                                                    @if($brand->logo)
                                                        <img src="{{ asset('storage/'.$brand->logo) }}" alt="{{ $brand->name }}" style="height: 14px; width: auto; object-fit: contain; filter: grayscale(1); opacity: 0.8;">
                                                    @endif
                                                    {{ $brand->name }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if(in_array('layout', $category->filters ?? []) && $availableLayouts->count() > 0)
                            <!-- Layout Filter -->
                            <div class="dropdown">
                                @php $selectedLayout = (array)request('layout'); @endphp
                                <button class="btn btn-elite-filter dropdown-toggle {{ !empty($selectedLayout) ? 'active' : '' }}" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-th-large {{ !empty($selectedLayout) ? 'text-warning' : '' }}"></i>
                                    <span class="mx-1">Kích thước</span>
                                </button>
                                <div class="dropdown-menu shadow-xl border-0 rounded-4 p-4 mt-3 animate-fade-in-up" style="min-width: 200px;">
                                    @foreach($availableLayouts as $layout)
                                    <div class="form-check custom-elite-check">
                                        <input class="form-check-input" type="checkbox" name="layout[]" value="{{ $layout }}" id="layout_{{ Str::slug($layout) }}" {{ in_array($layout, $selectedLayout) ? 'checked' : '' }} onchange="updateFilterAjax()">
                                        <label class="form-check-label" for="layout_{{ Str::slug($layout) }}">{{ $layout }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if(in_array('cpu', $category->filters ?? []) && $availableCPUs->count() > 0)
                            <!-- CPU Filter -->
                            <div class="dropdown">
                                @php $selectedCpu = (array)request('cpu'); @endphp
                                <button class="btn btn-elite-filter dropdown-toggle {{ !empty($selectedCpu) ? 'active' : '' }}" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-microchip {{ !empty($selectedCpu) ? 'text-warning' : '' }}"></i>
                                    <span class="mx-1">CPU</span>
                                </button>
                                <div class="dropdown-menu shadow-xl border-0 rounded-4 p-4 mt-3 animate-fade-in-up" style="min-width: 250px;">
                                    @foreach($availableCPUs as $cpu)
                                    <div class="form-check custom-elite-check">
                                        <input class="form-check-input" type="checkbox" name="cpu[]" value="{{ $cpu }}" id="cpu_{{ Str::slug($cpu) }}" {{ in_array($cpu, $selectedCpu) ? 'checked' : '' }} onchange="updateFilterAjax()">
                                        <label class="form-check-label" for="cpu_{{ Str::slug($cpu) }}">{{ $cpu }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if(in_array('connection', $category->filters ?? []) && $availableConnections->count() > 0)
                            <!-- Connection Filter -->
                            <div class="dropdown">
                                @php $selectedConn = (array)request('connection'); @endphp
                                <button class="btn btn-elite-filter dropdown-toggle {{ !empty($selectedConn) ? 'active' : '' }}" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-wifi {{ !empty($selectedConn) ? 'text-warning' : '' }}"></i>
                                    <span class="mx-1">Kết nối</span>
                                </button>
                                <div class="dropdown-menu shadow-xl border-0 rounded-4 p-4 mt-3 animate-fade-in-up" style="min-width: 200px;">
                                    @foreach($availableConnections as $conn)
                                    <div class="form-check custom-elite-check">
                                        <input class="form-check-input" type="checkbox" name="connection[]" value="{{ $conn }}" id="conn_{{ Str::slug($conn) }}" {{ in_array($conn, $selectedConn) ? 'checked' : '' }} onchange="updateFilterAjax()">
                                        <label class="form-check-label" for="conn_{{ Str::slug($conn) }}">{{ $conn }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($category->slug == 'lot-chuot-gear')
                            <!-- Size Filter -->
                            <div class="dropdown">
                                @php $selectedSize = (array)request('size'); @endphp
                                <button class="btn btn-elite-filter dropdown-toggle {{ !empty($selectedSize) ? 'active' : '' }}" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-ruler-combined {{ !empty($selectedSize) ? 'text-warning' : '' }}"></i>
                                    <span class="mx-1">Kích thước</span>
                                    @if(!empty($selectedSize))
                                        <span class="badge bg-warning text-dark rounded-pill">{{ count($selectedSize) }}</span>
                                    @endif
                                </button>
                                <div class="dropdown-menu shadow-xl border-0 rounded-4 p-4 mt-3 animate-fade-in-up" style="min-width: 250px;">
                                    <h6 class="dropdown-header px-0 text-dark fw-black mb-3 text-uppercase x-small opacity-50" style="letter-spacing: 1px;">Kích cỡ pad</h6>
                                    @foreach(['Extended (900x400)', 'XL (450x400)', 'L (320x270)', 'M (250x210)'] as $size)
                                    <div class="form-check custom-elite-check">
                                        <input class="form-check-input" type="checkbox" name="size[]" value="{{ $size }}" id="size_{{ Str::slug($size) }}" {{ in_array($size, $selectedSize) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="size_{{ Str::slug($size) }}" style="font-size: 13px;">{{ $size }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Surface Filter -->
                            <div class="dropdown">
                                @php $selectedSurface = (array)request('surface'); @endphp
                                <button class="btn btn-elite-filter dropdown-toggle {{ !empty($selectedSurface) ? 'active' : '' }}" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-wave-square {{ !empty($selectedSurface) ? 'text-warning' : '' }}"></i>
                                    <span class="mx-1">Bề mặt</span>
                                    @if(!empty($selectedSurface))
                                        <span class="badge bg-warning text-dark rounded-pill">{{ count($selectedSurface) }}</span>
                                    @endif
                                </button>
                                <div class="dropdown-menu shadow-xl border-0 rounded-4 p-4 mt-3 animate-fade-in-up" style="min-width: 200px;">
                                    <h6 class="dropdown-header px-0 text-dark fw-black mb-3 text-uppercase x-small opacity-50" style="letter-spacing: 1px;">Loại bề mặt</h6>
                                    @foreach(['Speed', 'Control', 'Hybrid'] as $surface)
                                    <div class="form-check custom-elite-check">
                                        <input class="form-check-input" type="checkbox" name="surface[]" value="{{ $surface }}" id="surf_{{ Str::slug($surface) }}" {{ in_array($surface, $selectedSurface) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="surf_{{ Str::slug($surface) }}" style="font-size: 13px;">{{ $surface }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($category->slug == 'keycaps-switch')
                            <!-- Material Filter -->
                            <div class="dropdown">
                                @php $selectedMat = (array)request('material'); @endphp
                                <button class="btn btn-elite-filter dropdown-toggle {{ !empty($selectedMat) ? 'active' : '' }}" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-layer-group {{ !empty($selectedMat) ? 'text-warning' : '' }}"></i>
                                    <span class="mx-1">Chất liệu</span>
                                </button>
                                <div class="dropdown-menu shadow-xl border-0 rounded-4 p-4 mt-3 animate-fade-in-up" style="min-width: 200px;">
                                    @foreach(['PBT Double-shot', 'ABS Laser-etched', 'PBT Dye-sub'] as $mat)
                                    <div class="form-check custom-elite-check">
                                        <input class="form-check-input" type="checkbox" name="material[]" value="{{ $mat }}" id="mat_{{ Str::slug($mat) }}" {{ in_array($mat, $selectedMat) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="mat_{{ Str::slug($mat) }}">{{ $mat }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Profile Filter -->
                            <div class="dropdown">
                                @php $selectedProf = (array)request('profile'); @endphp
                                <button class="btn btn-elite-filter dropdown-toggle {{ !empty($selectedProf) ? 'active' : '' }}" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-shapes {{ !empty($selectedProf) ? 'text-warning' : '' }}"></i>
                                    <span class="mx-1">Profile</span>
                                </button>
                                <div class="dropdown-menu shadow-xl border-0 rounded-4 p-4 mt-3 animate-fade-in-up" style="min-width: 200px;">
                                    @foreach(['Cherry Profile', 'OEM Profile', 'XDA Profile', 'ASA Profile'] as $prof)
                                    <div class="form-check custom-elite-check">
                                        <input class="form-check-input" type="checkbox" name="profile[]" value="{{ $prof }}" id="prof_{{ Str::slug($prof) }}" {{ in_array($prof, $selectedProf) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="prof_{{ Str::slug($prof) }}">{{ $prof }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($category->slug == 'ghe-cong-thai-hoc')
                            <!-- Frame Filter -->
                            <div class="dropdown">
                                @php $selectedFrame = (array)request('frame'); @endphp
                                <button class="btn btn-elite-filter dropdown-toggle {{ !empty($selectedFrame) ? 'active' : '' }}" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-skeleton {{ !empty($selectedFrame) ? 'text-warning' : '' }}"></i>
                                    <span class="mx-1">Khung ghế</span>
                                </button>
                                <div class="dropdown-menu shadow-xl border-0 rounded-4 p-4 mt-3 animate-fade-in-up" style="min-width: 200px;">
                                    @foreach(['Hợp kim nhôm', 'Thép cường lực', 'Nhựa ABS chịu lực'] as $frame)
                                    <div class="form-check custom-elite-check">
                                        <input class="form-check-input" type="checkbox" name="frame[]" value="{{ $frame }}" id="frame_{{ Str::slug($frame) }}" {{ in_array($frame, $selectedFrame) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="frame_{{ Str::slug($frame) }}">{{ $frame }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($category->slug == 'chuot-gaming')
                            <!-- Connection Filter -->
                            <div class="dropdown">
                                @php $selectedConn = (array)request('connection'); @endphp
                                <button class="btn btn-elite-filter dropdown-toggle {{ !empty($selectedConn) ? 'active' : '' }}" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-wifi {{ !empty($selectedConn) ? 'text-warning' : '' }}"></i>
                                    <span class="mx-1">Kết nối</span>
                                    @if(!empty($selectedConn))
                                        <span class="badge bg-warning text-dark rounded-pill">{{ count($selectedConn) }}</span>
                                    @endif
                                </button>
                                <div class="dropdown-menu shadow-xl border-0 rounded-4 p-4 mt-3 animate-fade-in-up" style="min-width: 240px;">
                                    <h6 class="dropdown-header px-0 text-dark fw-black mb-3 text-uppercase x-small opacity-50" style="letter-spacing: 1px;">Kiểu kết nối</h6>
                                    @foreach(['Có dây', 'Wireless 2.4GHz', 'Bluetooth'] as $conn)
                                    <div class="form-check custom-elite-check">
                                        <input class="form-check-input" type="checkbox" name="connection[]" value="{{ $conn }}" id="conn_{{ Str::slug($conn) }}" {{ in_array($conn, $selectedConn) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="conn_{{ Str::slug($conn) }}" style="font-size: 13px;">{{ $conn }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Weight Filter -->
                            <div class="dropdown">
                                @php $selectedWeight = (array)request('weight'); @endphp
                                <button class="btn btn-elite-filter dropdown-toggle {{ !empty($selectedWeight) ? 'active' : '' }}" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-weight-hanging {{ !empty($selectedWeight) ? 'text-warning' : '' }}"></i>
                                    <span class="mx-1">Trọng lượng</span>
                                    @if(!empty($selectedWeight))
                                        <span class="badge bg-warning text-dark rounded-pill">{{ count($selectedWeight) }}</span>
                                    @endif
                                </button>
                                <div class="dropdown-menu shadow-xl border-0 rounded-4 p-4 mt-3 animate-fade-in-up" style="min-width: 240px;">
                                    <h6 class="dropdown-header px-0 text-dark fw-black mb-3 text-uppercase x-small opacity-50" style="letter-spacing: 1px;">Cân năng</h6>
                                    @php
                                        $weightOptions = [
                                            'ultralight' => 'Siêu nhẹ (< 60g)',
                                            'light' => 'Nhẹ (60g - 90g)',
                                            'heavy' => 'Đầm tay (> 90g)'
                                        ];
                                    @endphp
                                    @foreach($weightOptions as $val => $label)
                                    <div class="form-check custom-elite-check">
                                        <input class="form-check-input" type="checkbox" name="weight[]" value="{{ $val }}" id="w_{{ $val }}" {{ in_array($val, $selectedWeight) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="w_{{ $val }}" style="font-size: 13px;">{{ $label }}</label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            {{-- Nút lọc ngay đã được thay thế bằng tự động lọc qua onchange --}}
                        </div>

                        <!-- SORTING -->
                        <div class="ms-auto d-flex align-items-center gap-2">
                            <span class="text-muted small fw-bold text-uppercase d-none d-xl-block" style="letter-spacing: 1px; font-size: 10px;">Xếp theo:</span>
                            <div class="dropdown">
                                @php
                                    $sortLabels = [
                                        'default' => 'Mặc định',
                                        'price_asc' => 'Giá: Thấp đến Cao',
                                        'price_desc' => 'Giá: Cao đến Thấp'
                                    ];
                                    $currentSort = request('sort', 'default');
                                @endphp
                                <button class="btn btn-elite-sort dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <span>{{ $sortLabels[$currentSort] ?? 'Mặc định' }}</span>
                                </button>
                                <div class="dropdown-menu elite-sort-menu shadow-xl animate-fade-in-up">
                                    @foreach($sortLabels as $key => $label)
                                    <a class="dropdown-item elite-sort-item {{ $currentSort == $key ? 'active' : '' }}" 
                                       href="javascript:void(0)" 
                                       onclick="document.getElementById('hiddenSort').value = '{{ $key }}'; updateFilterAjax();">
                                        {{ $label }}
                                        <i class="fas fa-check check-icon"></i>
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- ACTIVE FILTER CHIPS -->
                @php
                    $activeFilters = [];
                    foreach(['price', 'brand', 'layout', 'connection', 'weight', 'resolution', 'panel', 'cpu', 'gpu', 'ram', 'ssd', 'size', 'surface', 'material', 'profile', 'frame'] as $key) {
                        if(request()->filled($key)) {
                            foreach((array)request($key) as $val) {
                                $label = $val;
                                if($key == 'price') {
                                    $priceLabels = ['under_1m' => '< 1 triệu', '1_3m' => '1 - 3 triệu', '3_5m' => '3 - 5 triệu', 'over_5m' => '> 5 triệu'];
                                    $label = $priceLabels[$val] ?? $val;
                                }
                                if($key == 'brand') {
                                    $brandObj = $availableBrands->where('id', $val)->first();
                                    $label = $brandObj ? $brandObj->name : $val;
                                }
                                if($key == 'weight') {
                                    $weightLabels = ['ultralight' => 'Siêu nhẹ', 'light' => 'Nhẹ (60-90g)', 'heavy' => 'Đầm tay (>90g)'];
                                    $label = $weightLabels[$val] ?? $val;
                                }
                                $activeFilters[] = ['key' => $key, 'val' => $val, 'label' => $label];
                            }
                        }
                    }
                @endphp

                @if(!empty($activeFilters))
                <div class="d-flex flex-wrap align-items-center gap-2 mb-4 animate-slide-in-left">
                    <span class="text-muted fw-bold text-uppercase me-2" style="font-size: 11px; letter-spacing: 1.5px;">Đang hiển thị:</span>
                    @foreach($activeFilters as $filter)
                        <div class="elite-chip">
                            <i class="fas fa-filter small"></i>
                            <span>{{ $filter['label'] }}</span>
                            @php
                                $newQuery = request()->query();
                                $newQuery[$filter['key']] = array_diff((array)request($filter['key']), [$filter['val']]);
                                $chipLink = request()->url() . '?' . http_build_query($newQuery);
                            @endphp
                            <a href="javascript:void(0)" onclick="loadFilterPage('{{ $chipLink }}')" class="btn-close-chip">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    @endforeach
                    <a href="javascript:void(0)" onclick="resetFilters()" class="text-danger fw-bold small text-decoration-none ms-2 hover-underline" style="font-size: 12px;">Xóa tất cả</a>
                </div>
                @endif

                <!-- PRODUCT GRID -->
                <div class="row g-3 g-md-4">
                    @forelse($products as $product)
                    <div class="col-6 col-md-4 col-lg-3 animate-slide-in-up" style="animation-delay: {{ $loop->index * 0.05 }}s;">
                        <div class="card card-product-elite h-100 shadow-sm border-0 transition-all hover-translate-y-n3">
                            <div class="product-img-wrapper position-relative" style="aspect-ratio: 1/1;">
                                @if($product->is_flash_sale)
                                    <div class="product-badge-elite bg-danger">SALE</div>
                                @endif
                                <a href="{{ route('products.show', $product->slug) }}">
                                    <img src="{{ $product->image ?? asset('images/placeholder.jpg') }}" class="w-100 h-100 object-fit-contain p-3" alt="{{ $product->name }}">
                                </a>
                            </div>
                            <div class="card-body p-3 d-flex flex-column">
                                <p class="text-muted small mb-1 text-uppercase fw-bold opacity-75" style="font-size: 10px; letter-spacing: 0.5px;">{{ $product->brand->name ?? 'ELITE GEAR' }}</p>
                                <h6 class="fw-bold text-dark text-truncate mb-2" title="{{ $product->name }}" style="font-size: 15px;">{{ $product->name }}</h6>
                                
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
                                        <a href="{{ route('products.show', $product->slug) }}" class="btn-elite-secondary flex-grow-1">
                                            <i class="fas fa-eye"></i> Chi tiết
                                        </a>
                                        <button class="btn-elite-secondary px-3" onclick="addToCartElite({{ $product->id }}, '{{ route('cart.add', $product->id) }}', event, '{{ $product->image ?? asset('images/placeholder.jpg') }}')">
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                    </div>
                                    <a href="javascript:void(0)" onclick="addToCartElite({{ $product->id }}, '{{ route('cart.add', $product->id) }}', event, '{{ $product->image ?? asset('images/placeholder.jpg') }}', true)" class="btn btn-elite-buy w-100 shadow-sm py-2">
                                        <i class="fas fa-shopping-bag me-1 small"></i> Mua Ngay
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 py-5 text-center animate-fade-in">
                        <div class="mb-4">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                <i class="fas fa-search text-muted opacity-30 display-4"></i>
                            </div>
                        </div>
                        <h4 class="fw-black text-dark mb-2">Không tìm thấy sản phẩm</h4>
                        <p class="text-muted mb-4 opacity-75">Vui lòng thử điều kiện lọc khác hoặc xóa bộ lọc hiện tại.</p>
                        <a href="javascript:void(0)" onclick="resetFilters()" class="btn btn-warning rounded-pill px-5 fw-bold shadow-warning-sm">Xóa tất cả bộ lọc</a>
                    </div>
                    @endforelse
                </div>

                <!-- PAGINATION -->
                <div class="pagination-elite-wrapper d-flex flex-column flex-md-row align-items-center justify-content-between mt-5 gap-4 border-top pt-5 border-light">
                    <div class="pagination-elite-info order-2 order-md-1">
                        Hiển thị <span>{{ $products->firstItem() ?? 0 }}</span> - <span>{{ $products->lastItem() ?? 0 }}</span> TRÊN TỔNG SỐ <span>{{ $products->total() }}</span> SẢN PHẨM
                    </div>
                    <div class="order-1 order-md-2" id="ajax-pagination">
                        {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        initAjaxPagination();
    });

    function initAjaxPagination() {
        // Intercept pagination links
        document.querySelectorAll('#ajax-pagination a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                loadFilterPage(this.getAttribute('href'));
            });
        });

        // Intercept filter form
        const filterForm = document.getElementById('filterForm');
        if(filterForm) {
            filterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                updateFilterAjax();
            });
        }
    }

    function updateFilterAjax() {
        const form = document.getElementById('filterForm');
        const formData = new FormData(form);
        const params = new URLSearchParams(formData).toString();
        const url = form.getAttribute('action') + '?' + params;
        loadFilterPage(url);
    }

    function resetFilters() {
        loadFilterPage('{{ request()->url() }}');
    }

    function loadFilterPage(url) {
        const overlay = document.getElementById('elite-loading-overlay');
        overlay.style.display = 'flex';
        overlay.style.opacity = '0';
        setTimeout(() => overlay.style.opacity = '1', 10);

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContent = doc.querySelector('#product-container-elite').innerHTML;
            
            document.getElementById('product-container-elite').innerHTML = newContent;
            
            // Re-initialize events
            initAjaxPagination();
            
            // Update URL in browser
            window.history.pushState({}, '', url);
            
            // Scroll to top of filters smoothly
            document.getElementById('product-container-elite').scrollIntoView({ behavior: 'smooth', block: 'start' });

            // Hide overlay
            overlay.style.opacity = '0';
            setTimeout(() => overlay.style.display = 'none', 300);
        })
        .catch(error => {
            console.error('Error loading page:', error);
            overlay.style.display = 'none';
        });
    }
</script>
@endpush

@push('styles')
<style>
    /* CUSTOM ELITE CHECKBOX - REFINED */
    .custom-elite-check {
        padding-left: 1.8rem;
        margin-bottom: 0.85rem;
        transition: all 0.2s;
    }
    .custom-elite-check:last-child { margin-bottom: 0; }
    
    .custom-elite-check .form-check-input {
        width: 1.1rem;
        height: 1.1rem;
        margin-left: -1.8rem;
        border: 1.5px solid #e2e8f0;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .custom-elite-check .form-check-input:checked {
        background-color: #fbbf24;
        border-color: #fbbf24;
        box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.15);
    }
    .custom-elite-check .form-check-label {
        font-size: 13px;
        font-weight: 500;
        color: #475569;
        cursor: pointer;
        padding-top: 1px;
        transition: all 0.2s;
    }
    .custom-elite-check:hover .form-check-label { color: #1e293b; }
    
    .btn-elite-filter {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        color: #64748b;
        font-weight: 600;
        font-size: 13px;
        padding: 8px 16px;
        border-radius: 12px;
        transition: all 0.2s;
    }
    .btn-elite-filter:hover {
        background: #fff;
        border-color: #fbbf24;
        color: #1e293b;
        box-shadow: 0 4px 12px rgba(251, 191, 36, 0.08);
    }
    .btn-elite-filter.active {
        background: rgba(251, 191, 36, 0.05);
        border-color: #fbbf24;
        color: #1e293b;
    }
    
    .elite-chip {
        background: #fff;
        border: 1px solid #e2e8f0;
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 12px;
        font-weight: 600;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        animation: slideInDown 0.3s ease-out forwards;
    }
    .btn-close-chip {
        color: #94a3b8;
        text-decoration: none;
        font-size: 10px;
        transition: all 0.2s;
    }
    .btn-close-chip:hover { color: #ef4444; }

    .hover-translate-y-n3:hover { transform: translateY(-3px); }
    .animate-fade-in { animation: fadeIn 0.8s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    /* Custom pagination overrides to match Elite UI */
    .pagination .page-item .page-link {
        border-radius: 10px;
        margin: 0 3px;
        border: none;
        background: #f8fafc;
        color: #64748b;
        font-weight: 600;
        transition: all 0.3s;
    }
    .pagination .page-item.active .page-link {
        background: #fbbf24;
        color: #1e293b;
        box-shadow: 0 4px 12px rgba(251, 191, 36, 0.3);
    }
</style>
@endpush
@endsection
