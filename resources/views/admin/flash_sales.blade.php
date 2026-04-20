@extends('layouts.admin')
@section('page-icon', 'fas fa-bolt')
@section('page-title', 'Flash Sale')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 animate-in">
        <div>
            <h5 class="fw-bold mb-1">Quản lý Flash Sale</h5>
            <p class="text-muted mb-0" style="font-size: .82rem;">Bật/tắt chế độ giảm giá sốc cho từng sản phẩm</p>
        </div>
        <div class="d-flex align-items-center flex-wrap gap-2 gap-md-3">
            @if($active_flash_sales > 0)
            <form id="stopAllForm" action="{{ route('admin.flash_sales.stop_all') }}" method="POST">
                @csrf
                <button type="button" class="btn btn-outline-danger rounded-pill px-3 px-md-4 fw-bold shadow-sm" style="font-size: .82rem;" onclick="confirmStopAll()">
                    <i class="fas fa-power-off me-md-2"></i><span class="d-none d-md-inline">Dừng tất cả Sale</span><span class="d-inline d-md-none">Dừng hết</span>
                </button>
            </form>
            @endif
            <div class="d-flex align-items-center gap-2 px-3 px-md-4 py-2 rounded-pill shadow-sm" style="background: linear-gradient(135deg, var(--ddh-danger), #c0392b); color: #fff; font-weight: 700; font-size: .85rem;">
                <i class="fas fa-fire-flame-curved"></i>
                {{ $active_flash_sales }} <span class="d-none d-md-inline">đang chạy</span>
            </div>
        </div>
    </div>

    <!-- GLOBAL FLASH SALE SETTINGS -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 animate-in delay-1" style="background: linear-gradient(135deg, #1e293b, #0f172a);">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-3 mb-lg-0">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center shadow-lg" style="width: 50px; height: 50px;">
                            <i class="fas fa-clock text-dark fs-4"></i>
                        </div>
                        <div>
                            <h6 class="text-white fw-bold mb-1">Thời gian kết thúc chung</h6>
                            <p class="text-white-50 mb-0 small">Mốc thời gian này áp dụng cho nhà bán hàng để bộ đếm trang chủ chính xác.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <form action="{{ route('admin.flash_sales.global_end') }}" method="POST" class="row g-2 align-items-end">
                        @csrf
                        <div class="col-6 col-md-5">
                            <label class="text-white-50 x-small fw-bold mb-1 ms-2">NGÀY KẾT THÚC</label>
                            <input type="text" name="flash_sale_date" class="form-control rounded-pill border-0 flash-date-input px-3" 
                                   value="{{ $global_flash_sale_end ? \Carbon\Carbon::parse($global_flash_sale_end)->format('Y-m-d') : '' }}" placeholder="Chọn ngày...">
                        </div>
                        <div class="col-6 col-md-4">
                            <label class="text-white-50 x-small fw-bold mb-1 ms-2">GIỜ KẾT THÚC</label>
                            <input type="text" name="flash_sale_time" class="form-control rounded-pill border-0 flash-time-input px-3" 
                                   value="{{ $global_flash_sale_end ? \Carbon\Carbon::parse($global_flash_sale_end)->format('H:i') : '' }}" placeholder="Chọn giờ...">
                        </div>
                        <div class="col-12 col-md-3">
                            <button type="submit" class="btn btn-warning w-100 rounded-pill fw-bold" style="height: 48px;">
                                <i class="fas fa-save me-1"></i> Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="admin-alert admin-alert-error animate-in">
            <i class="fas fa-circle-xmark"></i>
            <ul class="mb-0 ps-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <!-- Search & Tabs Filter Block -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 animate-in delay-1">
        <div class="card-body p-2 d-flex flex-wrap align-items-center justify-content-between gap-3">
            <!-- Tabs Danh mục -->
            <div class="d-flex gap-1 overflow-x-auto pb-1 pb-md-0" style="max-width: 100%; scrollbar-width: none;">
                <a href="{{ route('admin.flash_sales', ['search' => request('search')]) }}" 
                   class="btn btn-sm rounded-pill px-3 py-1-5 {{ !request('category_id') ? 'bg-dark text-white fw-bold' : 'text-muted fw-500 bg-hover-light' }}" 
                   style="font-size: .78rem; white-space: nowrap;">
                    Tất cả mẫu
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('admin.flash_sales', ['category_id' => $category->id, 'search' => request('search')]) }}" 
                       class="btn btn-sm rounded-pill px-3 py-1-5 {{ request('category_id') == $category->id ? 'bg-dark text-white fw-bold' : 'text-muted fw-500 bg-hover-light' }}" 
                       style="font-size: .78rem; white-space: nowrap;">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <!-- Ô tìm kiếm nhanh -->
            <form action="{{ route('admin.flash_sales') }}" method="GET" class="d-flex gap-2 ms-auto w-100 w-md-auto mt-2 mt-md-0">
                @if(request('category_id'))
                    <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                @endif
                <div class="position-relative flex-grow-1 flex-md-grow-0">
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="form-control form-control-sm rounded-pill ps-4 w-100" 
                           placeholder="Tìm tên sản phẩm..." 
                           autocomplete="off" 
                           style="min-width: 200px; padding-right: 35px; font-size: .78rem; height: 36px; border-color: rgba(0,0,0,0.08);">
                    <i class="fas fa-search position-absolute top-50 translate-middle-y text-muted" style="right: 15px; font-size: .72rem;"></i>
                </div>
                @if(request('search') || request('category_id'))
                    <a href="{{ route('admin.flash_sales') }}" class="btn btn-light btn-sm rounded-pill px-3 d-flex align-items-center justify-content-center text-muted" title="Xóa lọc">
                        <i class="fas fa-times"></i>
                    </a>
                @endif
            </form>
        </div>
    </div>

    <div class="card animate-in delay-2">
        <div class="card-body p-0">
            <!-- Desktop Table View -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4" style="min-width: 250px;">Sản Phẩm</th>
                            <th>Giá Gốc</th>
                            <th style="min-width: 220px;">Giá Sale & Thời gian</th>
                            <th class="text-center">Trạng Thái</th>
                            <th class="text-end pe-4">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr style="{{ $product->is_flash_sale ? 'background: rgba(247,148,30,.03);' : '' }}">
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width: 48px; height: 48px; border-radius: 10px; overflow: hidden; background: #f8f9fa; flex-shrink: 0; display: flex; align-items: center; justify-content: center;">
                                        <img src="{{ $product->image ?? 'https://via.placeholder.com/48' }}" class="object-fit-contain" width="40" height="40">
                                    </div>
                                    <div>
                                        <div class="fw-bold" style="font-size: .85rem;">{{ Str::limit($product->name, 35) }}</div>
                                        <div style="font-size: .72rem; color: var(--ddh-blue); font-weight: 600;">
                                            <i class="fas fa-tag me-1" style="font-size: .65rem;"></i>{{ $product->category->name ?? 'N/A' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold" style="color: var(--ddh-muted); {{ $product->is_flash_sale ? 'text-decoration: line-through;' : '' }}">
                                    {{ number_format($product->price, 0, ',', '.') }} VNĐ
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.flash_sales.update', $product->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                        <div class="x-small text-muted fw-bold mb-1">Thiết lập giá sale:</div>
                                        <div class="input-group input-group-sm">
                                            <input type="number" name="sale_price" class="form-control fw-bold" style="color: var(--ddh-danger);"
                                                value="{{ round($product->sale_price) }}"
                                                {{ !$product->is_flash_sale ? 'disabled' : '' }}>
                                            <span class="input-group-text" style="font-size: .78rem;">VNĐ</span>
                                        </div>
                                    </div>
                                    @if($product->is_flash_sale)
                                        <button type="submit" name="update_price" value="1" class="btn btn-sm btn-ddh-primary w-100 rounded-pill" style="font-size: .78rem;">
                                            <i class="fas fa-save me-1"></i> Lưu giá
                                        </button>
                                    @endif
                                </form>
                            </td>
                            <td class="text-center">
                                @if($product->is_flash_sale)
                                    <span class="badge rounded-pill px-3 py-1 flash-pulse" style="background: var(--ddh-danger); font-size: .72rem; font-weight: 700;">
                                        <i class="fas fa-bolt me-1"></i> LIVE
                                    </span>
                                @else
                                    <span class="badge-outline" style="border-color: var(--ddh-border); color: var(--ddh-muted); font-size: .72rem;">Tắt</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <form action="{{ route('admin.flash_sales.update', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" name="toggle_status" value="1"
                                            class="btn btn-sm rounded-pill px-4 fw-bold {{ $product->is_flash_sale ? 'btn-outline-secondary' : 'btn-ddh-orange' }}" style="font-size: .78rem;">
                                        @if($product->is_flash_sale)
                                            <i class="fas fa-power-off me-1"></i> Tắt
                                        @else
                                            <i class="fas fa-bolt me-1"></i> Kích hoạt
                                        @endif
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Grid View -->
            <div class="d-md-none px-2 py-3">
                <div class="row row-cols-2 g-2">
                    @foreach($products as $product)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative {{ $product->is_flash_sale ? 'bg-white border border-danger border-opacity-25' : 'bg-white' }}" style="transition: transform 0.2s;">
                            <!-- Status Badge -->
                            <div class="position-absolute top-0 end-0 m-2 z-1">
                                @if($product->is_flash_sale)
                                    <span class="badge rounded-pill bg-danger shadow-sm flash-pulse" style="font-size: .6rem; padding: 4px 8px;">
                                        <i class="fas fa-bolt me-1"></i>LIVE
                                    </span>
                                @else
                                    <span class="badge rounded-pill bg-light text-muted border border-secondary border-opacity-25 shadow-sm" style="font-size: .6rem; padding: 4px 8px;">Tắt</span>
                                @endif
                            </div>

                            <div class="card-body p-2 d-flex flex-column">
                                <!-- Image Section -->
                                <div class="text-center mb-2 mt-1" style="height: 100px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 12px;">
                                    <img src="{{ $product->image ?? 'https://via.placeholder.com/100' }}" class="object-fit-contain" style="max-width: 85%; max-height: 85%;">
                                </div>

                                <!-- Info Section -->
                                <div class="flex-grow-1">
                                    <div class="fw-bold mb-1 text-dark" style="font-size: .78rem; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 2rem;">
                                        {{ $product->name }}
                                    </div>
                                    <div class="text-muted mb-2" style="font-size: .68rem;">
                                        <i class="fas fa-tag me-1 opacity-50"></i>{{ Str::limit($product->category->name ?? 'N/A', 15) }}
                                    </div>

                                    <div class="bg-light rounded-3 p-2 mb-2">
                                        <div class="text-muted text-center x-small mb-1" style="font-size: .62rem; text-decoration: line-through;">
                                            {{ number_format($product->price, 0, ',', '.') }} đ
                                        </div>
                                        <form action="{{ route('admin.flash_sales.update', $product->id) }}" method="POST">
                                            @csrf
                                            <div class="input-group input-group-sm">
                                                <input type="number" name="sale_price" class="form-control border-0 text-center fw-bold text-danger p-0" 
                                                       value="{{ round($product->sale_price) }}"
                                                       {{ !$product->is_flash_sale ? 'disabled' : '' }}
                                                       style="font-size: .85rem; background: transparent;">
                                                @if($product->is_flash_sale)
                                                    <button type="submit" name="update_price" value="1" class="btn btn-link text-warning p-1" style="font-size: .8rem;">
                                                        <i class="fas fa-save"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Action Section -->
                                <div class="mt-auto">
                                    <form action="{{ route('admin.flash_sales.update', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" name="toggle_status" value="1"
                                                class="btn btn-sm w-100 rounded-pill fw-bold shadow-sm {{ $product->is_flash_sale ? 'btn-outline-secondary border-opacity-25' : 'btn-ddh-orange' }}" 
                                                style="font-size: .7rem; padding: 8px 0;">
                                            @if($product->is_flash_sale)
                                                <i class="fas fa-power-off me-1"></i>Tắt
                                            @else
                                                <i class="fas fa-bolt me-1"></i>Bật Sale
                                            @endif
                                        </button>
                                    </form>
                                </div>
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
@endsection
@section('styles')
<style>
    .flash-pulse { animation: flashPulse 1.5s infinite; }
    @keyframes flashPulse {
        0%   { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.6); }
        70%  { box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
        100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
    }

    /* PREMIUM DATE & TIME PICKER STYLING */
    .flash-date-input, .flash-time-input {
        border: 1px solid #e2e8f0;
        border-radius: 10px !important;
        padding: 8px 12px;
        font-weight: 600;
        color: #1e293b;
        background-color: #f8fafc;
        transition: all 0.3s ease;
        font-size: 0.82rem;
        cursor: pointer;
    }
    .flash-date-input:focus, .flash-time-input:focus {
        border-color: var(--ddh-orange);
        background-color: #fff;
        box-shadow: 0 0 0 3px rgba(247, 148, 30, 0.15);
        outline: none;
    }

    /* Disabled state */
    .flash-date-input:disabled, .flash-time-input:disabled {
        background-color: #f1f5f9;
        color: #94a3b8;
        border-color: #e2e8f0;
        cursor: not-allowed;
    }

    /* FLATPICKR CUSTOM THEME */
    .flatpickr-calendar {
        background: #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 12px !important;
        font-family: 'Inter', sans-serif !important;
    }
    .flatpickr-day.selected {
        background: var(--ddh-orange) !important;
        border-color: var(--ddh-orange) !important;
    }
    .flatpickr-day.today {
        border-color: var(--ddh-orange) !important;
    }
    .flatpickr-day:hover {
        background: #fff0db !important;
    }
    .flatpickr-months .flatpickr-month {
        background: #fff !important;
        color: #1e293b !important;
    }
    .flatpickr-current-month .flatpickr-monthDropdown-months {
        font-weight: 700 !important;
    }

    @media (max-width: 768px) {
        .card-body.p-4 { padding: 1.25rem !important; }
        .bg-warning.rounded-circle { width: 40px !important; height: 40px !important; }
        .bg-warning.rounded-circle i { font-size: 1.2rem !important; }
        h6.text-white { font-size: 0.9rem; }
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/vn.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Date Picker
        flatpickr(".flash-date-input", {
            locale: "vn",
            dateFormat: "Y-m-d",
            minDate: "today",
            disableMobile: "true"
        });

        // Initialize Time Picker
        flatpickr(".flash-time-input", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            disableMobile: "true"
        });
        
        // Validation logic
        const dateInputs = document.querySelectorAll('.flash-date-input');
        const timeInputs = document.querySelectorAll('.flash-time-input');
        
        function validateDateTime(dateInput, timeInput) {
            if (!dateInput.value || !timeInput.value) return;
            
            const selectedDateTime = new Date(dateInput.value + 'T' + timeInput.value);
            const now = new Date();
            
            if (selectedDateTime < now) {
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi thời gian',
                    text: 'Thời gian kết thúc không được ở trong quá khứ!',
                    borderRadius: '16px',
                    confirmButtonColor: '#f7941e'
                });
                
                const today = new Date();
                const year = today.getFullYear();
                const month = String(today.getMonth() + 1).padStart(2, '0');
                const day = String(today.getDate()).padStart(2, '0');
                const hours = String(today.getHours()).padStart(2, '0');
                const minutes = String(today.getMinutes()).padStart(2, '0');
                
                dateInput._flatpickr.setDate(`${year}-${month}-${day}`);
                timeInput._flatpickr.setDate(`${hours}:${minutes}`);
            }
        }

        dateInputs.forEach((dateInput, index) => {
            const timeInput = timeInputs[index];
            if(dateInput && timeInput) {
                dateInput.addEventListener('change', () => validateDateTime(dateInput, timeInput));
                timeInput.addEventListener('change', () => validateDateTime(dateInput, timeInput));
            }
        });
    });
</script>
<script>
    function confirmStopAll() {
        Swal.fire({
            title: 'DỪNG TẤT CẢ SALE?',
            text: 'Hành động này sẽ tắt chế độ Flash Sale của toàn bộ sản phẩm đang kích hoạt.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b',
            confirmButtonText: '<i class="fas fa-power-off me-2"></i>Dừng ngay lập tức',
            cancelButtonText: 'Hủy bỏ',
            reverseButtons: true,
            borderRadius: '16px',
            customClass: {
                popup: 'rounded-4 shadow-lg border-0',
                confirmButton: 'rounded-pill px-4 py-2 fw-bold',
                cancelButton: 'rounded-pill px-4 py-2 fw-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Đang xử lý...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                        document.getElementById('stopAllForm').submit();
                    }
                });
            }
        });
    }
</script>
@endsection
