@extends('layouts.admin')

@section('page-title', 'Quản lý Danh mục')
@section('page-icon', 'images/icon/categories.png')

@section('styles')
<style>
    @media (max-width: 991.98px) {
        .card-body h6 { font-size: 0.9rem !important; }
        .form-label { font-size: 0.7rem !important; margin-bottom: 4px !important; margin-top: 10px !important; }
        .form-control-sm, .form-control { font-size: 0.85rem !important; padding: 8px 12px !important; }
        .btn-ddh-primary, .btn-danger { padding: 8px !important; font-size: 0.8rem !important; }
        .form-check-label { font-size: 0.75rem !important; }
    }
</style>
@endsection

@section('content')
<div class="container-fluid px-0">
    <div class="row g-4">
        <!-- List -->
        <div class="col-lg-8 animate-in">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <!-- Desktop Table View -->
                        <table class="table table-hover align-middle mb-0 d-none d-lg-table">
                            <thead>
                                <tr>
                                    <th class="ps-4">Tên danh mục</th>
                                    <th>Cấu hình bộ lọc</th>
                                    <th>Số sản phẩm</th>
                                    <th class="text-end pe-4">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $category->name }}</div>
                                        <code style="font-size: .7rem; color: var(--ddh-muted);">{{ $category->slug }}</code>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap gap-1">
                                            @php $filters = $category->filters ?? []; @endphp
                                            @forelse($filters as $f)
                                                <span class="badge bg-light text-dark border fw-normal" style="font-size: 10px;">{{ ucfirst($f) }}</span>
                                            @empty
                                                <span class="text-muted small">Chưa cấu hình</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge rounded-pill fw-bold" style="background: rgba(13, 110, 253, 0.1); color: #0d6efd; font-size: 11px; padding: 5px 12px;">
                                            {{ $category->products_count }} SP
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 me-1" 
                                                data-bs-toggle="modal" data-bs-target="#editModal{{ $category->id }}" style="font-size: .78rem;">
                                            <i class="fas fa-edit me-1"></i>Sửa
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" style="font-size: .78rem;" 
                                                onclick='confirmDelete("{{ $category->id }}", {!! json_encode($category->name) !!})'>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $category->id }}" action="{{ route('admin.categories.delete', $category->id) }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Mobile Card View -->
                        <div class="d-lg-none p-3">
                            @foreach($categories as $category)
                            <div class="card mb-3 rounded-4 border-0 shadow-sm elite-mobile-card">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <div class="fw-bold text-dark fs-6">{{ $category->name }}</div>
                                            <code class="d-block mt-1" style="font-size: .65rem; color: #94a3b8;">{{ $category->slug }}</code>
                                        </div>
                                        <span class="badge rounded-pill fw-bold" style="background: rgba(13, 110, 253, 0.08); color: #0d6efd; font-size: 10px; padding: 4px 10px;">
                                            {{ $category->products_count }} SP
                                        </span>
                                    </div>

                                    <div class="filter-chips-mobile mt-3 mb-4">
                                        <div class="text-muted x-small mb-1" style="font-size: 0.65rem; text-transform: uppercase; font-weight: 700; letter-spacing: 0.5px;">Bộ lọc active</div>
                                        <div class="d-flex flex-wrap gap-1">
                                            @forelse($category->filters ?? [] as $f)
                                                <span class="badge bg-light text-dark border-0 fw-medium" style="font-size: 9px; background: #f1f5f9 !important;">{{ ucfirst($f) }}</span>
                                            @empty
                                                <span class="text-muted" style="font-size: 11px;">Chưa có cấu hình</span>
                                            @endforelse
                                        </div>
                                    </div>

                                    <div class="d-flex gap-2 pt-2 border-top">
                                        <button type="button" class="btn btn-sm btn-outline-warning rounded-pill flex-fill py-2" 
                                                data-bs-toggle="modal" data-bs-target="#editModal{{ $category->id }}" style="font-size: .75rem; font-weight: 700;">
                                            <i class="fas fa-edit me-1"></i> Chỉnh sửa
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-2" 
                                                onclick='confirmDelete("{{ $category->id }}", {!! json_encode($category->name) !!})' style="font-size: .75rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Elite Pagination -->
                    @if($categories->hasPages())
                    <div class="pagination-elite-wrapper px-4 py-3 border-top bg-light bg-opacity-50">
                        {{ $categories->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Create Form -->
        <div class="col-lg-4 animate-in delay-1">
            <div class="card">
                <div class="card-body p-3 p-lg-4">
                    <h6 class="fw-bold mb-3"><i class="fas fa-plus-circle me-2" style="color: var(--ddh-orange);"></i>Thêm danh mục</h6>
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Tên danh mục</label>
                            <input type="text" name="name" class="form-control" placeholder="VD: Bàn phím cơ" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Icon 3D (Sidebar)</label>
                            <input type="file" name="icon" class="form-control form-control-sm">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase">Ảnh nền (Background)</label>
                            <input type="file" name="image" class="form-control form-control-sm">
                        </div>

                        <div class="row mb-3">
                            <div class="col-7">
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="show_on_sidebar" id="sidebar_toggle" value="1" checked>
                                    <label class="form-check-label fw-bold small" for="sidebar_toggle">Hiện ở Sidebar</label>
                                </div>
                            </div>
                            <div class="col-5">
                                <label class="form-label fw-bold small text-uppercase mb-0">Thứ tự</label>
                                <input type="number" name="order_index" class="form-control form-control-sm" value="0">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-ddh-primary w-100 rounded-pill">
                            <i class="fas fa-save me-1"></i> Lưu danh mục
                        </button>
                    </form>
                </div>
            </div>

            <!-- Special Sidebar Config -->
            <div class="card mt-4 border-warning shadow-sm animate-in delay-2">
                <div class="card-body p-3 p-lg-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold mb-0 text-danger"><i class="fas fa-bolt me-2"></i>Mục 10 Sidebar</h6>
                        <span class="badge bg-danger flash-pulse" style="font-size: 10px;">Cố định</span>
                    </div>
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase mb-1">Tên hiển thị</label>
                            <input type="text" class="form-control form-control-sm bg-light" value="SĂN DEAL HOT" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-uppercase mb-1">Đường dẫn liên kết (Link)</label>
                            <input type="text" name="flash_sale_sidebar_link" class="form-control border-danger-subtle shadow-sm" 
                                   value="{{ $settings['flash_sale_sidebar_link'] ?? '#' }}" placeholder="Dán link event/flash sale tại đây...">
                        </div>
                        <button type="submit" class="btn btn-danger w-100 rounded-pill fw-bold">
                            <i class="fas fa-link me-1"></i> Cập nhật Link Deal
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Category Modals (Moved outside table to fix backdrop issue) -->
@foreach($categories as $category)
<div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-light p-4">
                <h5 class="modal-title fw-black"><i class="fas fa-cog text-warning me-2"></i>Cấu hình Danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="{{ $category->id }}">
                <div class="modal-body p-4 text-start">
                    <div class="row g-4 mb-4">
                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase">Tên danh mục</label>
                            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                        </div>
                        
                        <div class="col-6">
                            <label class="form-label fw-bold small text-uppercase">Icon 3D (Sidebar)</label>
                            @if($category->icon)
                                <div class="mb-2"><img src="{{ asset($category->icon) }}" style="height: 40px; object-fit: contain;" class="rounded border p-1 border-light bg-light"></div>
                            @endif
                            <input type="file" name="icon" class="form-control form-control-sm">
                        </div>

                        <div class="col-6">
                            <label class="form-label fw-bold small text-uppercase">Ảnh nền (Background)</label>
                            @if($category->image)
                                <div class="mb-2"><img src="{{ asset($category->image) }}" style="height: 40px; width: 60px; object-fit: cover;" class="rounded border"></div>
                            @endif
                            <input type="file" name="image" class="form-control form-control-sm">
                        </div>

                        <div class="col-6">
                            <div class="form-check form-switch mt-1">
                                <input class="form-check-input" type="checkbox" name="show_on_sidebar" id="edit_sidebar_{{ $category->id }}" value="1" {{ $category->show_on_sidebar ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold small" for="edit_sidebar_{{ $category->id }}">Hiện ở Sidebar</label>
                            </div>
                        </div>

                        <div class="col-6">
                            <label class="form-label fw-bold small text-uppercase mb-0">Thứ tự hiển thị</label>
                            <input type="number" name="order_index" class="form-control form-control-sm" value="{{ $category->order_index }}">
                        </div>
                    </div>
                    
                    <div class="mb-2 border-bottom pb-2">
                        <label class="form-label fw-bold small text-uppercase text-warning">Kích hoạt các bộ lọc</label>
                    </div>
                    <div class="row g-3">
                        @php
                            $availableFilters = [
                                'price' => 'Khoảng giá',
                                'brand' => 'Thương hiệu',
                                'layout' => 'Layout / Kích thước',
                                'connection' => 'Kiểu kết nối',
                                'cpu' => 'Vi xử lý (CPU)',
                                'gpu' => 'Đồ họa (GPU)',
                                'ram' => 'Bộ nhớ RAM',
                                'ssd' => 'Ổ cứng SSD',
                                'resolution' => 'Độ phân giải',
                                'panel' => 'Tấm nền',
                                'weight' => 'Trọng lượng',
                                'size' => 'Kích thước Pad',
                                'surface' => 'Bề mặt pad',
                                'material' => 'Chất liệu Keycap',
                                'profile' => 'Profile Keycap',
                                'frame' => 'Khung vỏ'
                            ];
                            $filters = $category->filters ?? [];
                        @endphp
                        @foreach($availableFilters as $val => $label)
                        <div class="col-6">
                            <div class="form-check custom-elite-check">
                                <input class="form-check-input" type="checkbox" name="filters[]" value="{{ $val }}" id="filter_{{ $category->id }}_{{ $val }}" {{ in_array($val, $filters) ? 'checked' : '' }}>
                                <label class="form-check-label small fw-bold" for="filter_{{ $category->id }}_{{ $val }}">{{ $label }}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-warning rounded-pill px-4 fw-bold">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@endsection

@section('scripts')
<script>
function confirmDelete(id, name) {
    console.log('Confirm Delete called for:', id, name);
    Swal.fire({
        title: 'Xác nhận xóa?',
        text: `Bạn có chắc chắn muốn xóa danh mục "${name}" không? Hành động này không thể hoàn tác!`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
        confirmButtonText: '<i class="fas fa-trash me-2"></i>Đúng, xóa nó!',
        cancelButtonText: 'Hủy bỏ',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-4 border-0 shadow-lg',
            confirmButton: 'rounded-pill px-4 fw-bold',
            cancelButton: 'rounded-pill px-4 fw-bold'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>
@endsection
