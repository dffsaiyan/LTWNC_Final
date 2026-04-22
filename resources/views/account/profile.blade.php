@extends('layouts.app')

@section('title', 'Hồ sơ người dùng')

@push('styles')
<style>
    .account-sidebar {
        background: #fff;
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .account-menu-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 18px 25px;
        color: #64748b;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        border-bottom: 1px solid rgba(0,0,0,0.03);
    }
    .account-menu-item:last-child {
        border-bottom: none;
    }
    .account-menu-item:hover {
        background: #f8fafc;
        color: var(--primary-blue);
    }
    .account-menu-item.active {
        background: var(--primary-blue);
        color: #fff;
    }
    .account-menu-item.active i {
        color: #fff;
    }
    .account-menu-item i {
        font-size: 1.1rem;
        width: 20px;
        text-align: center;
    }
    .profile-card {
        background: #fff;
        border-radius: 20px;
        border: 1px solid rgba(0,0,0,0.05);
        padding: 40px;
    }
    .avatar-upload {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 30px;
    }
    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 30px;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .avatar-edit {
        position: absolute;
        bottom: -5px;
        right: -5px;
        width: 35px;
        height: 35px;
        background: var(--elite-orange, #fbbf24);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #000;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        transition: all 0.2s;
    }
    .avatar-edit:hover {
        transform: scale(1.1);
    }
    .form-section-title {
        font-size: 13px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #94a3b8;
        margin-bottom: 25px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .form-section-title::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }
    .ts-control {
        border-radius: 12px !important;
        padding: 10px 15px !important;
        border: 1px solid #dee2e6 !important;
    }
    .ts-wrapper.focus .ts-control {
        border-color: var(--elite-orange, #fbbf24) !important;
        box-shadow: 0 0 0 0.25rem rgba(251, 191, 36, 0.1) !important;
    }
    @media (max-width: 767px) {
        .container { padding-left: 15px; padding-right: 15px; }
        .sidebar-user-info { 
            display: flex !important; 
            flex-direction: column !important;
            text-align: center !important; 
            align-items: center !important; 
            padding: 25px 20px !important;
            gap: 5px;
        }
        .sidebar-user-info img { 
            width: 50px !important; 
            height: 50px !important; 
            margin-bottom: 0 !important;
            border-width: 2px !important;
        }
        .sidebar-user-info h6 { font-size: 13px !important; }
        .sidebar-user-info span { font-size: 10px !important; }
        .account-menu-item { padding: 12px 15px; font-size: 12px !important; }
        .account-menu-item i { font-size: 0.9rem; }

        /* Mới thêm: Giảm size Form Hồ sơ */
        .profile-card { padding: 25px 20px !important; }
        .avatar-preview { width: 100px !important; height: 100px !important; }
        .avatar-upload { margin-bottom: 30px !important; }
        .form-section-title { font-size: 15px !important; margin-bottom: 25px !important; }
        .form-label { font-size: 12px !important; }
        .form-control { padding: 8px 12px !important; font-size: 14px !important; }
        .btn-dark { width: 100%; padding: 12px !important; font-size: 14px !important; }
        .ts-control { padding: 8px 12px !important; min-height: 40px !important; }
    }
</style>
<!-- Tom Select CSS -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="container py-5 mt-4">
    <div class="row g-4">
        <div class="col-lg-3 animate-slide-in-left">
            <div class="account-sidebar shadow-sm">
                <div class="p-4 text-center border-bottom bg-light sidebar-user-info">
                    <img src="{{ $user->avatar ? asset($user->avatar) : ($user->social_avatar ?? asset('images/default-avatar.png')) }}" 
                         class="rounded-circle mb-3 shadow-sm border border-4 border-white mx-auto d-block" style="width: 80px; height: 80px; object-fit: cover;">
                    <div class="user-meta-elite">
                        <h6 class="fw-bold mb-0 text-dark">{{ str_replace('+', ' ', $user->name) }}</h6>
                        <span class="x-small text-muted fw-semibold">Thành viên Elite</span>
                    </div>
                </div>
                <div class="d-flex flex-column">
                    <a href="{{ route('account.profile') }}" class="account-menu-item active">
                        <i class="fas fa-user-circle"></i> Hồ sơ của tôi
                    </a>
                    <a href="{{ route('account.wishlist') }}" class="account-menu-item">
                        <i class="fas fa-heart"></i> Danh sách yêu thích
                    </a>
                    <a href="{{ route('account.orders') }}" class="account-menu-item">
                        <i class="fas fa-shopping-bag"></i> Đơn hàng đã mua
                    </a>
                    <a href="{{ route('posts.index') }}" class="account-menu-item">
                        <i class="fas fa-newspaper"></i> Đọc tin tức
                    </a>
                    @if(Auth::user()->can_write_posts || Auth::user()->email === 'admin@ddh.com')
                    <a href="{{ route('admin.posts') }}" class="account-menu-item">
                        <i class="fas fa-edit"></i> Viết bài mới
                    </a>
                    @endif
                    @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="account-menu-item text-primary">
                        <i class="fas fa-user-shield"></i> Quản trị hệ thống
                    </a>
                    @endif
                    <a href="{{ route('logout') }}" class="account-menu-item text-danger confirm-logout-app">
                        <i class="fas fa-sign-out-alt"></i> Đăng xuất
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9 animate-slide-in-right">
            <div class="profile-card shadow-sm">

                <form action="{{ route('account.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="avatar-upload">
                        <img id="avatarPreview" src="{{ $user->avatar ? asset($user->avatar) : ($user->social_avatar ?? asset('images/default-avatar.png')) }}" class="avatar-preview" alt="Avatar">
                        <label for="avatarInput" class="avatar-edit">
                            <i class="fas fa-camera"></i>
                        </label>
                        <input type="file" name="avatar" id="avatarInput" class="d-none" accept="image/*" onchange="previewImage(this)">
                    </div>

                    <div class="form-section-title">Thông tin cơ bản</div>
                    
                    <div class="row g-4 mb-5 justify-content-center">
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-dark">Họ và tên</label>
                            <input type="text" name="name" class="form-control rounded-3 py-2 px-3" value="{{ str_replace('+', ' ', old('name', $user->name)) }}" required>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-dark">Địa chỉ Email</label>
                            <input type="email" class="form-control rounded-3 py-2 px-3 bg-light" value="{{ $user->email }}" readonly>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-dark">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control rounded-3 py-2 px-3" value="{{ old('phone', $user->phone) }}" placeholder="VD: 0337xxxxxx">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-dark">Tỉnh / Thành phố</label>
                            <select name="province_id" id="province" class="form-select">
                                <option value="">Chọn Tỉnh/Thành phố</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-dark">Xã / Phường / Thị trấn</label>
                            <select name="district_id" id="district" class="form-select">
                                <option value="">Chọn Xã/Phường</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-dark">Địa chỉ cụ thể (Số nhà, tên đường)</label>
                            <textarea name="address" class="form-control rounded-3 py-2 px-3" rows="2" placeholder="VD: Số 123, Đường ABC...">{{ str_replace('+', ' ', old('address', $user->address)) }}</textarea>
                        </div>
                    </div>

                    <div class="form-section-title">Thay đổi mật khẩu</div>
                    
                    <div class="row g-4 mb-5 justify-content-center">
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-dark">Mật khẩu hiện tại</label>
                            <input type="password" name="current_password" class="form-control rounded-3 py-2 px-3" autocomplete="new-password">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-dark">Mật khẩu mới</label>
                            <input type="password" name="new_password" class="form-control rounded-3 py-2 px-3" autocomplete="new-password">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small fw-bold text-dark">Xác nhận mật khẩu</label>
                            <input type="password" name="new_password_confirmation" class="form-control rounded-3 py-2 px-3" autocomplete="new-password">
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-dark rounded-pill px-5 py-2 fw-bold text-uppercase shadow-lg">
                            Lưu thay đổi <i class="fas fa-save ms-2 text-warning"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // --- LOCATION HANDLER ---
    const provinceTS = new TomSelect('#province', {
        placeholder: 'Tìm kiếm Tỉnh/Thành...',
        allowEmptyOption: false,
    });

    const districtTS = new TomSelect('#district', {
        placeholder: 'Tìm kiếm Xã/Phường/Thị trấn...',
        allowEmptyOption: false,
    });

    // Fetch Provinces
    fetch('https://provinces.open-api.vn/api/v2/p/')
        .then(res => res.json())
        .then(provinces => {
            provinces.forEach(p => {
                provinceTS.addOption({value: p.code, text: p.name});
            });
            
            // Set saved province
            const savedProvince = "{{ $user->province_id }}";
            if (savedProvince) {
                provinceTS.setValue(savedProvince);
            }
        });

    provinceTS.on('change', function(pCode) {
        districtTS.clear();
        districtTS.clearOptions();
        
        if(!pCode) return;

        fetch(`https://provinces.open-api.vn/api/v2/w/?province=${pCode}`)
            .then(res => res.json())
            .then(data => {
                const wards = Array.isArray(data) ? data : (data.wards || []);
                wards.forEach(w => {
                    districtTS.addOption({value: w.name, text: w.name});
                });
                
                // Set saved district if it matches current province
                const savedDistrict = "{{ $user->district_id }}";
                if (savedDistrict) {
                    districtTS.setValue(savedDistrict);
                }
            });
    });
</script>
@endpush
@endsection
