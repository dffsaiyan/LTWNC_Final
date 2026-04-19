@extends('layouts.admin')
@section('page-icon', 'fas fa-pen-nib')
@section('page-title', 'Viết bài mới')

@section('content')
<div class="container-fluid px-0">
    <div class="mb-4 animate-in">
        <a href="{{ route('admin.posts') }}" class="text-decoration-none text-muted small fw-bold">
            <i class="fas fa-arrow-left me-1"></i> Trở lại danh sách
        </a>
    </div>

    <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card animate-in">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase" style="letter-spacing: 1px;">Tiêu đề bài viết</label>
                            <input type="text" name="title" class="form-control rounded-4 p-3 fw-bold @error('title') is-invalid @enderror" placeholder="VD: Đánh giá chi tiết bàn phím cơ Custom 2026..." required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold small text-uppercase" style="letter-spacing: 1px;">Tóm tắt ngắn (Summary)</label>
                            <textarea name="summary" class="form-control rounded-4 p-3 @error('summary') is-invalid @enderror" rows="3" placeholder="Nhập tóm tắt thu hút người đọc..."></textarea>
                            @error('summary') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-0">
                            <label class="form-label fw-bold small text-uppercase" style="letter-spacing: 1px;">Nội dung chi tiết</label>
                            <!-- Ta sử dụng textarea đơn giản, sau này có thể tích hợp CKEditor hoặc Quill -->
                            <textarea name="content" class="form-control rounded-4 p-3 @error('content') is-invalid @enderror" rows="15" placeholder="Viết nội dung bài viết của bạn tại đây..."></textarea>
                            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card animate-in delay-1 mb-4">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 border-bottom pb-2">Ảnh đại diện (Thumbnail)</h6>
                        
                        <div class="mb-4">
                            <label class="form-label small text-muted">Tải ảnh lên</label>
                            <input type="file" name="thumbnail_file" class="form-control rounded-3" accept="image/*" onchange="previewImage(this)">
                        </div>

                        <div class="text-center mb-4">
                            <div class="rounded-4 border-dashed overflow-hidden bg-light d-flex align-items-center justify-content-center" style="aspect-ratio: 16/10; border: 2px dashed #ddd;">
                                <img id="imagePreview" src="https://via.placeholder.com/400x250?text=Thumbnail+Preview" class="w-100 h-100 object-fit-cover shadow-sm">
                            </div>
                        </div>

                        <div class="mb-0">
                            <label class="form-label small text-muted">Hoặc dùng URL ảnh</label>
                            <input type="text" name="thumbnail_url" id="thumbnail_url_input" class="form-control rounded-3" placeholder="https://example.com/image.jpg" oninput="previewUrl(this.value)">
                        </div>
                    </div>
                </div>

                <div class="card animate-in delay-2">
                    <div class="card-body p-4">
                        <h6 class="fw-bold mb-3 border-bottom pb-2">Cài đặt xuất bản</h6>
                        <div class="form-check form-switch mb-4">
                            <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" checked>
                            <label class="form-check-label fw-semibold" for="is_published">Đăng ngay lập tức</label>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-3 fw-bold shadow-sm">
                            <i class="fas fa-paper-plane me-2"></i>XUẤT BẢN BÀI VIẾT
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
            document.getElementById('thumbnail_url_input').value = '';
        }
    }

    function previewUrl(url) {
        if (url) {
            document.getElementById('imagePreview').src = url;
        }
    }
</script>
@endsection
