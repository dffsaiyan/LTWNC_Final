@extends('layouts.admin')

@section('page-title', 'Quản lý Banner')
@section('page-icon', 'images/icon/banner_icon.png')

@section('content')
<div class="container-fluid py-4">
    <div class="row g-4">
        <!-- Banner Grid -->
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                        <i class="fas fa-ad text-orange"></i>
                        <span>Quản lý Banner quảng cáo</span>
                    </h5>

                    <div class="row g-4">
                        @foreach($banners as $banner)
                        @php
                            $positionLabel = match($banner->position) {
                                'right_1' => 'Bên phải Slide (Top)',
                                'right_2' => 'Bên phải Slide (Middle)',
                                'right_3' => 'Bên phải Slide (Bottom)',
                                'horizontal_middle' => 'Banner Ngang giữa trang',
                                default => $banner->position
                            };
                        @endphp
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 rounded-4 shadow-sm transition-all hover-translate-y bg-light p-3">
                                <div class="text-center mb-3">
                                    <h6 class="fw-black text-orange text-uppercase mb-3" style="font-size: 13px; letter-spacing: 1px;">
                                        <i class="fas fa-thumbtack me-1"></i> {{ $positionLabel }}
                                    </h6>
                                    <div class="banner-preview rounded-3 overflow-hidden shadow-sm mb-3 position-relative" style="height: {{ $banner->position == 'horizontal_middle' ? '100px' : '180px' }};">
                                        <img src="{{ asset($banner->image) }}" class="w-100 h-100 {{ $banner->position == 'horizontal_middle' ? 'object-fit-fill' : 'object-fit-cover' }}" id="bannerPreviewImg-{{ $banner->id }}">
                                    </div>
                                </div>

                                <form action="{{ route('admin.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="position" value="{{ $banner->position }}">
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Link liên kết</label>
                                        <div class="input-group search-group input-group-sm">
                                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-link"></i></span>
                                            <input type="text" name="link" class="form-control border-start-0 ps-0" placeholder="https://..." value="{{ $banner->link }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold small text-muted text-uppercase">Thay đổi ảnh</label>
                                        <input type="file" name="image" class="form-control form-control-sm border-0 shadow-sm" onchange="previewBanner(this, {{ $banner->id }})">
                                    </div>

                                    <button type="submit" class="btn btn-orange w-100 rounded-pill py-2 fw-bold text-uppercase shadow-orange-sm transition-all hover-translate-y">
                                        <i class="fas fa-save me-2"></i> Lưu thay đổi
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
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
.shadow-orange-sm { box-shadow: 0 4px 10px rgba(243, 156, 18, 0.2); }
.aspect-ratio-16-9 { width: 100%; height: 180px; }
</style>

<script>
function previewBanner(input, id) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('bannerPreviewImg-' + id).src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
