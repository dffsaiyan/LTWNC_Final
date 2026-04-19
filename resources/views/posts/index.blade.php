@extends('layouts.app')

@section('content')
<div class="container py-5 mt-4">
    <div class="d-flex align-items-center gap-3 mb-5 animate-slide-in-left">
        <div class="bg-danger rounded-pill" style="width: 8px; height: 40px;"></div>
        <div>
            <h1 class="fw-bold mb-0 text-uppercase h2" style="letter-spacing: -1px;">Tin tức công nghệ</h1>
            <p class="text-muted mb-0 small fw-bold text-uppercase">Cập nhật xu hướng & đánh giá mới nhất</p>
        </div>
    </div>

    <div class="row g-4">
        @forelse($posts as $post)
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card border-0 h-100 bg-transparent post-card-elite">
                <div class="rounded-4 overflow-hidden mb-3 shadow-sm position-relative" style="aspect-ratio: 16/10;">
                    <img src="{{ $post->thumbnail ? (Str::startsWith($post->thumbnail, 'http') ? $post->thumbnail : asset($post->thumbnail)) : 'https://via.placeholder.com/500x310?text=News' }}" class="w-100 h-100 object-fit-cover transition-all hover-zoom-slow" alt="{{ $post->title }}">
                    <div class="position-absolute top-0 end-0 m-3">
                        <span class="badge bg-danger rounded-pill px-3 py-2 shadow-sm" style="font-size: 10px;">{{ $post->created_at->format('d/m') }}</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <span class="text-danger small fw-bold text-uppercase mb-2 d-block">{{ $post->created_at->translatedFormat('d F, Y') }}</span>
                    <h5 class="fw-bold mb-2 lh-base" style="font-size: 18px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-dark text-decoration-none transition-all hover-text-danger">{{ $post->title }}</a>
                    </h5>
                    <p class="text-muted small mb-3" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $post->summary }}</p>
                    <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-outline-dark btn-sm rounded-pill px-3 fw-bold" style="font-size: 11px;">Đọc tiếp <i class="fas fa-arrow-right ms-1"></i></a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="mb-3"><i class="fas fa-newspaper fa-4x text-light"></i></div>
            <h3 class="fw-bold text-muted">Chưa có tin tức nào</h3>
            <p class="text-muted">Chúng tôi đang chuẩn bị những nội dung thú vị cho bạn.</p>
            <a href="/" class="btn btn-danger rounded-pill px-4 fw-bold">Quay lại trang chủ</a>
        </div>
        @endforelse
    </div>

    @if($posts->hasPages())
    <div class="d-flex justify-content-center mt-5">
        {{ $posts->links() }}
    </div>
    @endif
</div>

<style>
    .hover-zoom-slow { transition: transform 0.8s cubic-bezier(0.165, 0.84, 0.44, 1); }
    .post-card-elite:hover .hover-zoom-slow { transform: scale(1.1); }
    .hover-text-danger:hover { color: #ef4444 !important; }
    
    .pagination { gap: 8px; }
    .page-link { 
        border: none !important; 
        border-radius: 12px !important; 
        width: 45px; height: 45px; 
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; color: #666;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }
    .page-item.active .page-link { background: #ef4444 !important; color: white !important; }
</style>
@endsection
