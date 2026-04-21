@extends('layouts.admin')
@section('page-icon', 'fas fa-plus')
@section('page-title', 'Thêm sản phẩm mới')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4 animate-in edit-header-mobile">
        <h5 class="fw-bold mb-0 page-title-text">Tạo sản phẩm mới</h5>
        <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary rounded-pill px-md-4 px-3 back-btn-elite" style="font-size: .85rem;">
            <i class="fas fa-arrow-left me-md-1"></i> <span class="d-none d-md-inline">Quay lại</span>
        </a>
    </div>

    <style>
        @media (max-width: 991.98px) {
            .edit-header-mobile { gap: 10px; margin-bottom: 1.5rem !important; }
            .page-title-text { font-size: 1rem !important; }
            .back-btn-elite { 
                padding: 0.5rem 0.8rem !important; 
                font-size: 0.75rem !important;
                display: flex;
                align-items: center;
                justify-content: center;
                min-width: 40px;
            }

            /* COMPACT FORM ON MOBILE */
            .card-body.p-4 { padding: 1.25rem !important; }
            .form-label { font-size: 0.82rem !important; margin-bottom: 0.4rem !important; font-weight: 700 !important; }
            .form-control, .form-select { font-size: 0.85rem !important; padding: 0.5rem 0.8rem !important; border-radius: 8px !important; }
            .mb-4 { margin-bottom: 1.2rem !important; }
            .row.g-4, .row.g-3 { --bs-gutter-y: 1rem !important; --bs-gutter-x: 1rem !important; }
            
            .style-filter-section { padding: 1rem !important; border-radius: 12px !important; }
            .style-filter-section label { font-size: 0.85rem !important; margin-bottom: 1rem !important; }
            .filter-field label { font-size: 0.75rem !important; }
            
            .btn-ddh-orange, .btn-ddh-primary { py: 0.8rem !important; font-size: 0.9rem !important; }
            .small.text-muted { font-size: 0.7rem !important; } /* REDUCE INFO TEXT SIZE */
        }
    </style>

    @if($errors->any())
        <div class="admin-alert admin-alert-error animate-in">
            <i class="fas fa-circle-xmark"></i>
            <ul class="mb-0 ps-3">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="card animate-in delay-1">
        <div class="card-body p-4">
            <form action="{{ route('admin.products.store') }}" method="POST">
                @csrf
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="VD: Bàn phím cơ Akko 3068" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Mô tả sản phẩm</label>
                            <textarea name="description" class="form-control" rows="6" placeholder="Nhập mô tả chi tiết cho sản phẩm...">{{ old('description') }}</textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Thông số kỹ thuật (Dòng 1: Giá trị 1)</label>
                                <textarea name="specifications" class="form-control" rows="8" placeholder="Thương hiệu: Corsair&#10;Layout: TKL">{{ old('specifications') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Câu hỏi thường gặp (Câu hỏi? Trả lời)</label>
                                <textarea name="faqs" class="form-control" rows="8" placeholder="Bảo hành? 12 tháng&#10;Giao hàng? Siêu tốc 2h">{{ old('faqs') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-4">
                            <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">— Chọn danh mục —</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Thương hiệu <span class="text-danger">*</span></label>
                            <select name="brand_id" class="form-select" required>
                                <option value="">— Chọn thương hiệu —</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4 p-3 rounded-4 style-filter-section border-warning-subtle shadow-sm" style="background: rgba(251, 191, 36, 0.03); border: 1px dashed #fbbf24;">
                            <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 mb-3">
                                <i class="fas fa-sliders-h text-warning"></i> THÔNG SỐ BỘ LỌC
                            </label>
                            <div id="filterFieldsContainer" class="row g-3">
                                <div class="col-6 filter-field" data-filter="layout" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Layout / Size</label>
                                    <input type="text" name="layout" class="form-control form-control-sm" placeholder="VD: TKL, 75%..." value="{{ old('layout') }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="connection" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Kết nối</label>
                                    <input type="text" name="connection" class="form-control form-control-sm" placeholder="VD: Wireless, Có dây..." value="{{ old('connection') }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="cpu" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Vi xử lý (CPU)</label>
                                    <input type="text" name="cpu" class="form-control form-control-sm" placeholder="VD: i7 13700H..." value="{{ old('cpu') }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="gpu" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Đồ họa (GPU)</label>
                                    <input type="text" name="gpu" class="form-control form-control-sm" placeholder="VD: RTX 4060..." value="{{ old('gpu') }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="ram" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Bộ nhớ RAM</label>
                                    <input type="text" name="ram" class="form-control form-control-sm" placeholder="VD: 16GB DDR5..." value="{{ old('ram') }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="ssd" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Ổ cứng SSD</label>
                                    <input type="text" name="ssd" class="form-control form-control-sm" placeholder="VD: 512GB NVMe..." value="{{ old('ssd') }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="resolution" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Độ phân giải</label>
                                    <input type="text" name="resolution" class="form-control form-control-sm" placeholder="VD: 2K, 144Hz..." value="{{ old('resolution') }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="panel" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Tấm nền</label>
                                    <input type="text" name="panel" class="form-control form-control-sm" placeholder="VD: IPS, VA, OLED..." value="{{ old('panel') }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="weight" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Trọng lượng</label>
                                    <input type="text" name="weight" class="form-control form-control-sm" placeholder="VD: 60g, 1.2kg..." value="{{ old('weight') }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="size" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Kích thước Pad</label>
                                    <input type="text" name="size" class="form-control form-control-sm" placeholder="VD: 900x400x4mm..." value="{{ old('size') }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="surface" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Bề mặt Pad</label>
                                    <input type="text" name="surface" class="form-control form-control-sm" placeholder="VD: Speed, Control..." value="{{ old('surface') }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="material" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Chất liệu Keycap</label>
                                    <input type="text" name="material" class="form-control form-control-sm" placeholder="VD: PBT Double-shot..." value="{{ old('material') }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="profile" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Profile Keycap</label>
                                    <input type="text" name="profile" class="form-control form-control-sm" placeholder="VD: Cherry, OEM, ASA..." value="{{ old('profile') }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="frame" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Khung vỏ</label>
                                    <input type="text" name="frame" class="form-control form-control-sm" placeholder="VD: Nhôm CNC, Nhựa ABS..." value="{{ old('frame') }}">
                                </div>
                                <div id="noFilterAlert" class="col-12 text-center py-3 text-muted" style="display: none; font-size: 11px;">
                                    <i class="fas fa-info-circle me-1"></i> Vui lòng chọn danh mục để hiển thị bộ lọc.
                                </div>
                            </div>
                            <p class="text-muted mt-2 mb-0" style="font-size: 10px; opacity: 0.8;"><i class="fas fa-magic me-1"></i> Các ô nhập sẽ tự động hiển thị dựa trên Danh mục bạn chọn.</p>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-tag text-muted"></i></span>
                                    <input type="number" name="price" class="form-control" value="{{ old('price') }}" placeholder="5100000" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-orange-gradient">Giá khuyến mãi (VNĐ)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-percentage text-orange"></i></span>
                                    <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price', 0) }}" placeholder="Để 0 nếu không giảm giá">
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label class="form-label fw-bold">Tồn kho <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-boxes text-muted"></i></span>
                                    <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold">Trạng thái Flash Sale</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_flash_sale" id="isFlashSale" value="1" {{ old('is_flash_sale') ? 'checked' : '' }}>
                                    <label class="form-check-label small fw-bold text-muted" for="isFlashSale">Kích hoạt Flash Sale</label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">URL ảnh sản phẩm (Ảnh chính)</label>
                            <input type="text" name="image" class="form-control" value="{{ old('image') }}" placeholder="https://... hoặc /images/...">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Ảnh bổ sung (Mỗi URL một dòng)</label>
                            <textarea name="additional_images" class="form-control" rows="4" placeholder="https://image1.jpg&#10;https://image2.jpg">{{ old('additional_images') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-ddh-primary w-100 rounded-pill py-2 mt-2">
                            <i class="fas fa-save me-2"></i> Lưu sản phẩm
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const categoryFilters = {!! $categories->mapWithKeys(function($cat) { return [$cat->id => $cat->filters ?? []]; })->toJson() !!};

    document.addEventListener('DOMContentLoaded', function() {
        const categorySelect = document.querySelector('select[name="category_id"]');
        const filterFields = document.querySelectorAll('.filter-field');
        const noFilterAlert = document.getElementById('noFilterAlert');

        function updateFilters() {
            const selectedId = categorySelect.value;
            const activeFilters = categoryFilters[selectedId] || [];

            let visibleCount = 0;
            filterFields.forEach(field => {
                const filterType = field.getAttribute('data-filter');
                if (activeFilters.includes(filterType)) {
                    field.style.display = 'block';
                    visibleCount++;
                } else {
                    field.style.display = 'none';
                }
            });

            if (selectedId === "") {
                noFilterAlert.style.display = 'block';
                noFilterAlert.innerHTML = '<i class="fas fa-info-circle me-1"></i> Vui lòng chọn danh mục để hiển thị bộ lọc.';
            } else if (visibleCount === 0) {
                noFilterAlert.style.display = 'block';
                noFilterAlert.innerHTML = '<i class="fas fa-info-circle me-1"></i> Danh mục này không có bộ lọc đặc thù.';
            } else {
                noFilterAlert.style.display = 'none';
            }
        }

        categorySelect.addEventListener('change', updateFilters);
        
        // Khởi tạo trang thái ban đầu
        updateFilters();
    });
</script>
@endsection
