@extends('layouts.admin')

@section('page-title', 'Cài đặt hệ thống')
@section('page-icon', 'images/icon/setting_icon.png')

@section('content')
<div class="container-fluid px-0">
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-6 animate-in">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, var(--ddh-blue), var(--ddh-navy)); display: flex; align-items: center; justify-content: center; color: #fff; font-size: .85rem;">
                                <i class="fas fa-store"></i>
                            </div>
                            <h6 class="fw-bold mb-0">Thông tin cơ bản</h6>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tên website</label>
                            <input type="text" name="site_name" class="form-control" value="{{ $settings['site_name'] ?? 'DDH Electronics' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-danger fw-bold"><i class="fas fa-bolt me-1"></i> Link Sidebar: SĂN DEAL HOT</label>
                            <input type="text" name="flash_sale_sidebar_link" class="form-control border-danger-subtle" value="{{ $settings['flash_sale_sidebar_link'] ?? '#' }}" placeholder="Gắn link cho mục thú 10 trên Sidebar...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Slogan cửa hàng</label>
                            <input type="text" name="site_slogan" class="form-control" value="{{ $settings['site_slogan'] ?? 'Thế giới phụ kiện công nghệ' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tiêu đề SEO</label>
                            <input type="text" name="seo_title" class="form-control" value="{{ $settings['seo_title'] ?? '' }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Mô tả SEO meta</label>
                            <textarea name="seo_description" class="form-control" rows="3">{{ $settings['seo_description'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 animate-in delay-1">
                <div class="card h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: linear-gradient(135deg, var(--ddh-orange), #e8850a); display: flex; align-items: center; justify-content: center; color: #fff; font-size: .85rem;">
                                <i class="fas fa-headset"></i>
                            </div>
                            <h6 class="fw-bold mb-0">Liên hệ & Hỗ trợ</h6>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại Hotline</label>
                            <input type="text" name="contact_phone" class="form-control" value="{{ $settings['contact_phone'] ?? '0123.456.789' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email hỗ trợ</label>
                            <input type="email" name="contact_email" class="form-control" value="{{ $settings['contact_email'] ?? 'support@ddh.vn' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ cửa hàng</label>
                            <input type="text" name="contact_address" class="form-control" value="{{ $settings['contact_address'] ?? 'Hà Nội, Việt Nam' }}">
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Google Map Embed URL</label>
                            <input type="text" name="map_link" class="form-control" value="{{ $settings['map_link'] ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 animate-in delay-2">
                <button type="submit" class="btn btn-ddh-orange rounded-pill px-5 py-3 fw-bold">
                    <i class="fas fa-save me-2"></i> LƯU TẤT CẢ THAY ĐỔI
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
