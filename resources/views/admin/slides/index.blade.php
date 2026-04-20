@extends('layouts.admin')

@section('page-title', 'Quản lý Slide')
@section('page-icon', 'images/icon/slide_icon.png')

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4">
        <!-- Slide Form -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 100px;">
                <div class="card-body p-3 p-lg-4">
                    <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                        <i class="fas fa-plus-circle text-orange"></i>
                        <span>Thêm Slide mới</span>
                    </h5>
                    
                    <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Hình ảnh (1920x800)</label>
                            <div class="upload-zone p-3 p-lg-4 border-2 border-dashed rounded-4 text-center transition-all bg-light hover-bg-white border-light hover-border-orange" 
                                 onclick="document.getElementById('slideImage').click()">
                                <input type="file" name="image" id="slideImage" class="d-none" onchange="previewSlide(this)" required>
                                <div id="pre-upload">
                                    <i class="fas fa-cloud-upload-alt display-5 text-muted mb-2"></i>
                                    <p class="small text-muted mb-0">Click để chọn ảnh slide</p>
                                </div>
                                <div id="post-upload" class="d-none">
                                    <img id="imgPreview" src="#" class="img-fluid rounded-3 shadow-sm mb-3">
                                    <p class="small text-orange fw-bold mb-0">Cập nhật ảnh</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 mb-lg-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Link liên kết (URL)</label>
                            <div class="input-group search-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-link"></i></span>
                                <input type="url" name="link" class="form-control border-start-0 ps-0" placeholder="https://example.com/khuyen-mai">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-muted text-uppercase">Thứ tự hiển thị (1-10)</label>
                            <div class="input-group search-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-sort-numeric-down"></i></span>
                                <input type="number" name="order" class="form-control border-start-0 ps-0" value="1" min="1" max="10">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-orange w-100 rounded-pill py-2 fw-bold text-uppercase shadow-orange-sm transition-all hover-translate-y">
                            <i class="fas fa-save me-2"></i> Lưu Slide
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Slide List -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-3 p-lg-4">
                    <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                        <i class="fas fa-images text-orange"></i>
                        <span>Danh sách Slide</span>
                    </h5>

                    <div class="table-responsive rounded-3 overflow-hidden">
                        <!-- Desktop Table View -->
                        <table class="table table-hover align-middle mb-0 d-none d-lg-table">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 px-4 py-3 small fw-bold text-muted text-uppercase">Slide</th>
                                    <th class="border-0 px-4 py-3 small fw-bold text-muted text-uppercase">Thông tin</th>
                                    <th class="border-0 px-4 py-3 small fw-bold text-muted text-uppercase text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($slides as $slide)
                                <tr>
                                    <td class="px-4 py-3">
                                        <div class="position-relative" style="width: 200px;">
                                            <img src="{{ asset($slide->image) }}" class="img-fluid rounded-3 shadow-sm">
                                            <span class="position-absolute top-0 start-0 badge bg-dark opacity-75 rounded-pill m-1">#{{ $slide->order }}</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="fw-bold text-dark mb-1">Link:</div>
                                        <div class="small text-muted text-break" style="max-width: 200px;">
                                            {{ $slide->link ?: 'Trống' }}
                                        </div>
                                        <div class="mt-2">
                                            @if($slide->status)
                                                <span class="badge bg-success-soft text-success rounded-pill px-3">Đang hiện</span>
                                            @else
                                                <span class="badge bg-secondary-soft text-secondary rounded-pill px-3">Đang ẩn</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button type="button" class="btn btn-sm btn-light text-warning rounded-circle shadow-sm hover-bg-warning hover-text-white transition-all scale-up me-1" style="width: 32px; height: 32px;" data-bs-toggle="modal" data-bs-target="#editSlideModal{{ $slide->id }}">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <form action="{{ route('admin.slides.delete', $slide->id) }}" method="POST" class="d-inline" id="delete-form-{{ $slide->id }}">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-light text-danger rounded-circle shadow-sm hover-bg-danger hover-text-white transition-all scale-up" style="width: 32px; height: 32px;" onclick="confirmDelete(event, {{ $slide->id }})">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editSlideModal{{ $slide->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 rounded-4 shadow-xl">
                                            <div class="modal-header bg-dark text-white p-4 border-bottom-0 rounded-top-4">
                                                <h5 class="modal-title fw-bold">Chỉnh sửa Slide #{{ $slide->id }}</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-4 text-start">
                                                <form action="{{ route('admin.slides.update', $slide->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-4 text-center">
                                                        <label class="form-label d-block fw-bold text-muted small text-uppercase">Hình ảnh hiện tại</label>
                                                        <img id="editPreview-{{ $slide->id }}" src="{{ asset($slide->image) }}" class="img-fluid rounded-3 shadow-sm mb-3" style="max-height: 150px;">
                                                        <input type="file" name="image" class="form-control form-control-sm border-0 shadow-sm" onchange="previewEditSlide(this, {{ $slide->id }})">
                                                        <div class="small text-muted mt-2">Để trống nếu không muốn đổi ảnh</div>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="form-label fw-bold small text-muted text-uppercase">Link liên kết</label>
                                                        <div class="input-group search-group">
                                                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-link"></i></span>
                                                            <input type="url" name="link" class="form-control border-start-0 ps-0" value="{{ $slide->link }}" placeholder="https://...">
                                                        </div>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="form-label fw-bold small text-muted text-uppercase">Thứ tự hiển thị (1-10)</label>
                                                        <div class="input-group search-group">
                                                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-sort-numeric-down"></i></span>
                                                            <input type="number" name="order" class="form-control border-start-0 ps-0" value="{{ $slide->order }}" min="1" max="10">
                                                        </div>
                                                    </div>

                                                    <button type="submit" class="btn btn-orange w-100 rounded-pill py-2 fw-bold text-uppercase shadow-orange-sm">
                                                        Cập nhật ngay
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Mobile Card List View -->
                        <div class="d-lg-none">
                            @foreach($slides as $slide)
                            <div class="card mb-4 rounded-4 border-0 shadow-sm elite-slide-card overflow-hidden">
                                <div class="position-relative">
                                    <img src="{{ asset($slide->image) }}" class="w-100" style="height: 180px; object-fit: cover;">
                                    <div class="position-absolute top-0 start-0 p-2">
                                        <span class="badge bg-dark bg-opacity-75 rounded-pill px-3 py-2 fw-bold">#{{ $slide->order }}</span>
                                    </div>
                                    <div class="position-absolute bottom-0 end-0 p-2">
                                        @if($slide->status)
                                            <span class="badge bg-success rounded-pill px-3 py-2 fw-bold shadow-sm">Đang hiện</span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill px-3 py-2 fw-bold shadow-sm">Đang ẩn</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body p-3">
                                    <div class="mb-3">
                                        <div class="text-muted x-small text-uppercase fw-bold mb-1" style="font-size: 10px; letter-spacing: 0.5px;">Link liên kết</div>
                                        <div class="small text-dark text-truncate fw-medium">{{ $slide->link ?: 'Trống' }}</div>
                                    </div>
                                    <div class="d-flex gap-2 pt-2 border-top">
                                        <button class="btn btn-light text-warning rounded-pill flex-fill py-2 fw-bold" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#editSlideModal{{ $slide->id }}">
                                            <i class="fas fa-edit me-1"></i> Chỉnh sửa
                                        </button>
                                        <form action="{{ route('admin.slides.delete', $slide->id) }}" method="POST" class="flex-fill">
                                            @csrf
                                            <button type="button" class="btn btn-outline-danger rounded-pill w-100 py-2" style="font-size: 0.75rem;" onclick="confirmDelete(event, {{ $slide->id }})">
                                                <i class="fas fa-trash-alt me-1"></i> Xóa
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.text-orange { color: #f39c12; }
.btn-orange { background: linear-gradient(135deg, #f39c12, #e67e22); color: white; border: none; }
.btn-orange:hover { background: linear-gradient(135deg, #e67e22, #d35400); color: white; }
.bg-success-soft { background-color: rgba(46, 204, 113, 0.1); }
.shadow-orange-sm { box-shadow: 0 4px 10px rgba(243, 156, 18, 0.2); }
.hover-border-orange:hover { border-color: #f39c12 !important; cursor: pointer; }
.hover-bg-white:hover { background-color: white !important; }
.upload-zone { cursor: pointer; transition: all 0.3s ease; }
</style>

<script>
function previewSlide(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imgPreview').src = e.target.result;
            document.getElementById('pre-upload').classList.add('d-none');
            document.getElementById('post-upload').classList.remove('d-none');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function previewEditSlide(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('editPreview-' + id).src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function confirmDelete(event, id) {
    event.preventDefault();
    Swal.fire({
        title: 'Xóa Slide này?',
        text: "Hành động này không thể hoàn tác!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e67e22',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Xóa ngay',
        cancelButtonText: 'Hủy',
        borderRadius: '15px'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>
@endsection
