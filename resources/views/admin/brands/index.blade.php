@extends('layouts.admin')

@section('title', 'Quản lý Thương hiệu')
@section('page-title', 'Quản lý Thương hiệu')
@section('page-icon', 'images/icon/brand_icon.png')

@section('content')
<div class="animate-in">
    <div class="row g-4">
        <!-- Brand Form -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 100px;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                        <i class="fas fa-plus-circle text-orange"></i>
                        <span id="formTitle">Thêm hãng mới</span>
                    </h5>
                    
                    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" id="brandForm">
                        @csrf
                        <input type="hidden" name="id" id="brandId">
                        
                        <div class="mb-4">
                            <label class="form-label">Tên thương hiệu</label>
                            <input type="text" name="name" id="brandName" class="form-control form-control-lg bg-light border-0" placeholder="VD: Logitech, Razer..." required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Logo thương hiệu</label>
                            <div class="border-2 border-dashed border-light rounded-4 p-4 text-center hover-bg-light transition" style="cursor: pointer;" onclick="document.getElementById('brandLogo').click()">
                                <div id="previewContainer" class="d-none mb-3 position-relative d-inline-block">
                                    <img id="logoPreview" src="#" class="img-fluid rounded-3 shadow-sm" style="max-height: 80px;">
                                    <button type="button" id="btnRemoveLogo" class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle shadow-sm" style="transform: translate(30%, -30%); padding: 2px 7px;" onclick="handleDeleteLogo(event)">
                                        <i class="fas fa-times" style="font-size: 10px;"></i>
                                    </button>
                                </div>
                                <div id="uploadPlaceholder">
                                    <i class="fas fa-cloud-upload-alt fs-2 text-muted mb-2"></i>
                                    <p class="small text-muted mb-0">Tải ảnh lên (PNG, JPG)</p>
                                </div>
                                <input type="file" name="logo" id="brandLogo" class="d-none" onchange="previewImage(this)">
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-ddh-orange py-3">
                                <i class="fas fa-save me-2"></i> LƯU THƯƠNG HIỆU
                            </button>
                            <button type="button" id="btnReset" class="btn btn-light py-2 rounded-3 d-none" onclick="resetForm()">
                                <i class="fas fa-times me-1"></i> Hủy chỉnh sửa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Brands List -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="table-responsive">
                    <!-- Desktop Table View -->
                    <table class="table table-hover align-middle mb-0 d-none d-lg-table">
                        <thead>
                            <tr>
                                <th class="ps-4">Logo</th>
                                <th>Tên hãng</th>
                                <th>Số sản phẩm</th>
                                <th class="text-end pe-4">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($brands as $brand)
                            <tr>
                                <td class="ps-4">
                                    <div class="bg-light rounded-3 p-2 d-inline-block border" style="width: 60px; height: 45px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                        @if($brand->logo)
                                            <img src="{{ asset('storage/'.$brand->logo) }}" alt="{{ $brand->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @else
                                            <i class="fas fa-image text-muted opacity-25"></i>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $brand->name }}</div>
                                    <div class="text-muted small">slug: {{ $brand->slug }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-soft-primary text-primary px-3 rounded-pill">{{ $brand->products_count }} SP</span>
                                </td>
                                <td class="text-end pe-4">
                                    <button class="btn btn-sm btn-light rounded-pill px-3 me-1" onclick="editBrand({{ $brand->id }}, '{{ addslashes($brand->name) }}', '{{ $brand->logo ? asset('storage/'.$brand->logo) : '' }}')">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.brands.delete', $brand->id) }}" method="POST" class="d-inline confirm-elite" data-prompt="Xóa hãng này và gỡ bỏ khỏi toàn bộ sản phẩm?" data-type="danger">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Mobile Card View -->
                    <div class="d-lg-none p-3">
                        @foreach($brands as $brand)
                        <div class="card mb-3 rounded-4 border-0 shadow-sm elite-mobile-card" style="background: #fff; border: 1px solid rgba(0,0,0,0.02) !important;">
                            <div class="card-body p-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="bg-light rounded-3 p-2 d-flex align-items-center justify-content-center border" style="width: 65px; height: 50px; flex-shrink: 0;">
                                        @if($brand->logo)
                                            <img src="{{ asset('storage/'.$brand->logo) }}" alt="{{ $brand->name }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @else
                                            <i class="fas fa-image text-muted opacity-25"></i>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold text-dark fs-6">{{ $brand->name }}</div>
                                        <div class="text-muted" style="font-size: 0.7rem;">{{ $brand->slug }}</div>
                                    </div>
                                    <div class="text-end">
                                        <span class="badge bg-soft-primary text-primary px-2 py-1 rounded-pill" style="font-size: 10px;">{{ $brand->products_count }} SP</span>
                                    </div>
                                </div>
                                <div class="d-flex gap-2 mt-3 pt-2 border-top">
                                    <button class="btn btn-sm btn-light rounded-pill flex-fill py-2 fw-bold" onclick="editBrand({{ $brand->id }}, '{{ addslashes($brand->name) }}', '{{ $brand->logo ? asset('storage/'.$brand->logo) : '' }}')" style="font-size: 0.75rem;">
                                        <i class="fas fa-edit me-1"></i> Sửa
                                    </button>
                                    <form action="{{ route('admin.brands.delete', $brand->id) }}" method="POST" class="flex-fill confirm-elite" data-prompt="Xóa hãng này?" data-type="danger">
                                        @csrf
                                        <button class="btn btn-sm btn-outline-danger rounded-pill w-100 py-2" style="font-size: 0.75rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Elite Pagination -->
                @if($brands->hasPages())
                <div class="pagination-elite-wrapper px-4 py-3 border-top bg-light bg-opacity-50">
                    {{ $brands->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background: rgba(0, 86, 150, 0.1); }
    .hover-bg-light:hover { background: rgba(0, 0, 0, 0.02); }

    @media (max-width: 991.98px) {
        .card-body.p-4 { padding: 1.25rem !important; }
        .form-label { font-size: 0.75rem !important; font-weight: 700 !important; margin-bottom: 6px !important; }
        .form-control-lg { height: 45px !important; font-size: 0.95rem !important; }
        .btn-ddh-orange { padding: 12px !important; font-size: 0.9rem !important; }
        
    }
</style>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logoPreview').src = e.target.result;
                document.getElementById('previewContainer').classList.remove('d-none');
                document.getElementById('uploadPlaceholder').classList.add('d-none');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function editBrand(id, name, logo) {
        document.getElementById('brandId').value = id;
        document.getElementById('brandName').value = name;
        document.getElementById('formTitle').innerText = 'Chỉnh sửa hãng: ' + name;
        document.getElementById('btnReset').classList.remove('d-none');
        
        if (logo) {
            document.getElementById('logoPreview').src = logo;
            document.getElementById('previewContainer').classList.remove('d-none');
            document.getElementById('uploadPlaceholder').classList.add('d-none');
        } else {
            resetLogoPreview();
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function resetForm() {
        document.getElementById('brandId').value = '';
        document.getElementById('brandForm').reset();
        document.getElementById('formTitle').innerText = 'Thêm hãng mới';
        document.getElementById('btnReset').classList.add('d-none');
        resetLogoPreview();
    }

    function resetLogoPreview() {
        document.getElementById('previewContainer').classList.add('d-none');
        document.getElementById('uploadPlaceholder').classList.remove('d-none');
        document.getElementById('logoPreview').src = '#';
        document.getElementById('brandLogo').value = '';
    }

    function handleDeleteLogo(event) {
        event.stopPropagation();
        const brandId = document.getElementById('brandId').value;
        const fileInput = document.getElementById('brandLogo');
        
        if (fileInput.value) {
            resetLogoPreview();
            return;
        }

        if (brandId) {
            Swal.fire({
                title: 'Xóa logo này?',
                text: "Bạn có chắc chắn muốn gỡ bỏ logo của thương hiệu này?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff4d4d',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="fas fa-trash me-2"></i>Đúng, xóa nó!',
                cancelButtonText: 'Hủy',
                reverseButtons: true,
                background: '#fff',
                borderRadius: '1.25rem',
                customClass: {
                    popup: 'rounded-4 shadow-lg border-0',
                    confirmButton: 'rounded-pill px-4 py-2 fw-bold',
                    cancelButton: 'rounded-pill px-4 py-2 fw-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/admin/brands/${brandId}/delete-logo`;
                    
                    const csrfToken = document.querySelector('input[name="_token"]').value;
                    const tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = '_token';
                    tokenInput.value = csrfToken;
                    
                    form.appendChild(tokenInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    }
</script>
@endsection
