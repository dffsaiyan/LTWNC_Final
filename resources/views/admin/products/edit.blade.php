@extends('layouts.admin')
@section('page-icon', 'fas fa-pen')
@section('page-title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4 animate-in edit-header-mobile">
        <h5 class="fw-bold mb-0 page-title-text">Chỉnh sửa: {{ Str::limit($product->name, 50) }}</h5>
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
            
            .group-hover-parent { width: 65px !important; height: 65px !important; }
            .group-hover-parent img { min-width: 65px !important; }
            
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
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-4">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label class="form-label">Tên sản phẩm <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Mô tả sản phẩm</label>
                            <textarea name="description" class="form-control" rows="6">{{ old('description', $product->description) }}</textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Thông số kỹ thuật (Ví dụ: Thương hiệu: Corsair)</label>
                                <textarea name="specifications" class="form-control" rows="8" placeholder="Thương hiệu: Corsair&#10;Layout: TKL">{{ old('specifications', $product->specifications ? collect($product->specifications)->map(fn($v, $k) => "$k: $v")->implode("\n") : '') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Câu hỏi thường gặp (Ví dụ: Bảo hành? 12 tháng)</label>
                                <textarea name="faqs" class="form-control" rows="8" placeholder="Bảo hành? 12 tháng&#10;Giao hàng? Siêu tốc 2h">{{ old('faqs', $product->faqs ? collect($product->faqs)->map(fn($v, $k) => str_replace('?', '', $k) . "? $v")->implode("\n") : '') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-4">
                            <label class="form-label">Danh mục <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select" required>
                                <option value="">— Chọn danh mục —</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Thương hiệu <span class="text-danger">*</span></label>
                            <select name="brand_id" class="form-select" required>
                                <option value="">— Chọn thương hiệu —</option>
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
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
                                    <input type="text" name="layout" class="form-control form-control-sm" value="{{ old('layout', $product->layout) }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="connection" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Kết nối</label>
                                    <input type="text" name="connection" class="form-control form-control-sm" value="{{ old('connection', $product->connection) }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="cpu" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Vi xử lý (CPU)</label>
                                    <input type="text" name="cpu" class="form-control form-control-sm" value="{{ old('cpu', $product->cpu) }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="gpu" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Đồ họa (GPU)</label>
                                    <input type="text" name="gpu" class="form-control form-control-sm" value="{{ old('gpu', $product->gpu) }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="ram" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Bộ nhớ RAM</label>
                                    <input type="text" name="ram" class="form-control form-control-sm" value="{{ old('ram', $product->ram) }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="ssd" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Ổ cứng SSD</label>
                                    <input type="text" name="ssd" class="form-control form-control-sm" value="{{ old('ssd', $product->ssd) }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="resolution" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Độ phân giải</label>
                                    <input type="text" name="resolution" class="form-control form-control-sm" value="{{ old('resolution', $product->resolution) }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="panel" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Tấm nền</label>
                                    <input type="text" name="panel" class="form-control form-control-sm" value="{{ old('panel', $product->panel) }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="weight" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Trọng lượng</label>
                                    <input type="text" name="weight" class="form-control form-control-sm" value="{{ old('weight', $product->weight) }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="size" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Kích thước Pad</label>
                                    <input type="text" name="size" class="form-control form-control-sm" value="{{ old('size', $product->size) }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="surface" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Bề mặt Pad</label>
                                    <input type="text" name="surface" class="form-control form-control-sm" value="{{ old('surface', $product->surface) }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="material" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Chất liệu Keycap</label>
                                    <input type="text" name="material" class="form-control form-control-sm" value="{{ old('material', $product->material) }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="profile" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Profile Keycap</label>
                                    <input type="text" name="profile" class="form-control form-control-sm" value="{{ old('profile', $product->profile) }}">
                                </div>
                                <div class="col-6 filter-field" data-filter="frame" style="display:none;">
                                    <label class="small fw-bold text-muted mb-1">Khung vỏ</label>
                                    <input type="text" name="frame" class="form-control form-control-sm" value="{{ old('frame', $product->frame) }}">
                                </div>
                                <div id="noFilterAlert" class="col-12 text-center py-3 text-muted" style="display: none; font-size: 11px;">
                                    <i class="fas fa-info-circle me-1"></i> Danh mục này không có bộ lọc đặc thù.
                                </div>
                            </div>
                            <p class="text-muted mt-2 mb-0" style="font-size: 10px; opacity: 0.8;"><i class="fas fa-magic me-1"></i> Các ô nhập sẽ tự động hiển thị dựa trên Danh mục bạn chọn.</p>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Giá gốc (VNĐ) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-tag text-muted"></i></span>
                                    <input type="number" name="price" class="form-control" value="{{ old('price', (int)$product->price) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-orange-gradient">Giá khuyến mãi (VNĐ)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-percentage text-orange"></i></span>
                                    <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price', (int)$product->sale_price) }}" placeholder="Để 0 nếu không giảm giá">
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label class="form-label fw-bold">Tồn kho <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-boxes text-muted"></i></span>
                                    <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-bold">Trạng thái Flash Sale</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="is_flash_sale" id="isFlashSale" value="1" {{ old('is_flash_sale', $product->is_flash_sale) ? 'checked' : '' }}>
                                    <label class="form-check-label small fw-bold text-muted" for="isFlashSale">Kích hoạt Flash Sale</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Ảnh sản phẩm chính <span class="text-danger">*</span></label>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-link text-muted"></i></span>
                                <input type="text" name="image" id="productImageInput" class="form-control border-start-0" value="{{ old('image', $product->image) }}" placeholder="Dán URL ảnh vào đây...">
                            </div>
                            <div class="text-center my-2">
                                <span class="badge bg-light text-muted rounded-pill px-3 py-1" style="font-size: 10px;">HOẶC TẢI ẢNH LÊN</span>
                            </div>
                            <div class="file-upload-container">
                                <input type="file" name="image_file" id="productImageFile" class="form-control rounded-pill mb-2" onchange="previewFile(this)">
                                <div class="text-muted small ps-2"><i class="fas fa-info-circle me-1"></i> Hoặc chọn ảnh từ máy để thay thế URL trên.</div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label fw-bold mb-0">Ảnh bổ sung</label>
                                @if($product->images->count() > 0)
                                    <a href="{{ route('admin.products.delete-all-images', $product->id) }}" 
                                       class="text-danger small fw-bold text-decoration-none"
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa TOÀN BỘ ảnh bổ sung không?')">
                                        <i class="fas fa-trash-alt me-1"></i> Xóa tất cả
                                    </a>
                                @endif
                            </div>
                            
                            <!-- Premium Gallery Grid -->
                            @if($product->images->count() > 0)
                                <div class="p-3 rounded-4 mb-3" style="background: #f8f9fa; border: 1px solid #eee;">
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($product->images as $img)
                                            <div class="position-relative group-hover-parent" style="width: 80px; height: 80px;">
                                                <img src="{{ asset($img->image) }}" class="w-100 h-100 object-fit-cover rounded-3 border shadow-sm transition-all" style="min-width: 80px;">
                                                <a href="{{ route('admin.products.delete-image', $img->id) }}" 
                                                   class="position-absolute top-0 end-0 m-1 btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center p-0 shadow-sm opacity-0 transition-opacity" 
                                                   style="width: 22px; height: 22px; font-size: 10px;"
                                                   onclick="return confirm('Xóa ảnh này?')">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-link text-muted"></i></span>
                                <textarea name="additional_images" class="form-control border-start-0 ps-2" rows="2" placeholder="Dán link ảnh (Mỗi link 1 dòng)...">{{ old('additional_images') }}</textarea>
                            </div>
                            
                            <div class="text-center my-3">
                                <span class="badge bg-light text-muted rounded-pill px-3 py-1 fw-normal" style="font-size: 10px; letter-spacing: 1px;">HOẶC TẢI LÊN FILE MỚI</span>
                            </div>

                            <div class="file-upload-container mt-2">
                                <input type="file" name="additional_images_files[]" id="additionalImagesFiles" class="form-control rounded-pill mb-2" multiple onchange="previewMultipleFiles(this)">
                                <div class="text-muted small ps-2">
                                    <i class="fas fa-info-circle me-1"></i> Nhấn giữ <b>Ctrl</b> để chọn nhiều ảnh từ máy tính.
                                </div>
                            </div>
                            <div id="additionalPreview" class="d-flex flex-wrap gap-2 mt-3"></div>
                        </div>

                        <div class="mb-4 text-center p-3 rounded-4 border border-2 border-dashed position-relative d-flex align-items-center justify-content-center" style="background: #fbfbfb; min-height: 180px;">
                            <div id="imagePlaceholder" class="{{ $product->image ? 'd-none' : '' }} text-muted opacity-50">
                                <i class="fas fa-camera-retro fa-3x mb-2"></i>
                                <p class="small mb-0">Chưa có ảnh preview</p>
                            </div>
                            <img id="mainImagePreview" 
                                 src="{{ $product->image ? asset($product->image) : '' }}" 
                                 class="{{ $product->image ? '' : 'd-none' }} object-fit-contain rounded shadow-sm" 
                                 style="max-height: 160px; max-width: 100%; transition: all 0.3s ease;"
                                 onerror="handleImageError(this)">
                        </div>

                        <button type="submit" class="btn btn-ddh-orange w-100 rounded-pill py-3 fw-bold text-uppercase shadow-sm mt-2 transition-all hover-translate-y">
                            <i class="fas fa-save me-2"></i> Cập nhật sản phẩm
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const urlInput = document.getElementById('productImageInput');
    const previewImg = document.getElementById('mainImagePreview');
    const placeholder = document.getElementById('imagePlaceholder');

    // Xử lý khi nhập URL
    urlInput.addEventListener('input', function() {
        const val = this.value.trim();
        if (val) {
            updatePreview(val);
        } else {
            resetPreview();
        }
    });

    // Xử lý khi chọn File từ máy tính
    window.previewFile = function(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                updatePreview(e.target.result);
                urlInput.value = ''; // Xóa URL nếu đã chọn file
                // Đổi màu nút để báo hiệu đã chọn thành công
                const label = input.closest('label');
                label.classList.replace('btn-outline-dark', 'btn-success');
                label.innerHTML = '<i class="fas fa-check me-2"></i> Đã chọn ảnh: ' + input.files[0].name;
            }
            reader.readAsDataURL(input.files[0]);
        }
    };

    function updatePreview(src) {
        previewImg.src = src;
        previewImg.classList.remove('d-none');
        placeholder.classList.add('d-none');
        // Reset lại nội dung placeholder nếu trước đó bị lỗi
        placeholder.innerHTML = '<i class="fas fa-image fa-3x mb-2"></i><p class="small mb-0">Chưa có ảnh preview</p>';
    }

    function resetPreview() {
        previewImg.classList.add('d-none');
        previewImg.src = '';
        placeholder.classList.remove('d-none');
    }

    window.handleImageError = function(img) {
        if (!img.src || img.src === window.location.origin + '/' || img.src.length < 30) return;
        img.classList.add('d-none');
        placeholder.classList.remove('d-none');
        placeholder.innerHTML = '<i class="fas fa-exclamation-triangle fa-3x mb-2 text-danger"></i><p class="small mb-0 text-danger">URL ảnh không hợp lệ hoặc lỗi tải</p>';
    };

    window.previewMultipleFiles = function(input) {
        const container = document.getElementById('additionalPreview');
        container.innerHTML = '';
        if (input.files) {
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'position-relative';
                    div.style.width = '80px';
                    div.style.height = '80px';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-100 h-100 object-fit-cover rounded-3 border shadow-sm">
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-25 rounded-3 d-flex align-items-center justify-content-center text-white" style="font-size: 10px; pointer-events: none;">
                            Mới
                        </div>
                    `;
                    container.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        }
    };
</script>

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
        
        // Khởi tạo trạng thái ban đầu dựa trên danh mục hiện tại của sản phẩm
        updateFilters();
    });
</script>
@endsection
