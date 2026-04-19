@extends('layouts.app')

@section('content')
<div class="container py-5 mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/" class="text-decoration-none text-muted">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('posts.index') }}" class="text-decoration-none text-muted">Tin tức</a></li>
                    <li class="breadcrumb-item active fw-bold text-dark" aria-current="page">{{ Str::limit($post->title, 30) }}</li>
                </ol>
            </nav>

            <article class="animate-fade-in">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-danger rounded-pill px-3">{{ $post->created_at->translatedFormat('d F, Y') }}</span>
                    <span class="text-muted small">|</span>
                    <span class="text-muted small">Bởi <strong class="text-dark">{{ $post->user->name }}</strong></span>
                </div>

                <h1 class="fw-bold mb-4 lh-base" style="font-size: 36px; letter-spacing: -1.5px;">{{ $post->title }}</h1>
                
                <p class="lead fw-bold text-muted mb-4 py-1" style="font-size: 20px;">
                    {{ $post->summary }}
                </p>

                @if($post->thumbnail)
                <div class="rounded-4 overflow-hidden mb-5 shadow-sm">
                    <img src="{{ Str::startsWith($post->thumbnail, 'http') ? $post->thumbnail : asset($post->thumbnail) }}" class="w-100 h-100 object-fit-cover" alt="{{ $post->title }}">
                </div>
                @endif

                <div class="post-content lh-lg" style="font-size: 18px; color: #333;">
                    {!! nl2br(e($post->content)) !!}
                </div>

                <div class="mt-5 pt-5 border-top">
                    <div class="d-flex align-items-center justify-content-center">
                        <a href="{{ route('posts.index') }}" class="btn btn-outline-danger btn-sm rounded-pill px-4 fw-bold">Xem tin khác</a>
                    </div>
                </div>
            </article>
        </div>

        <!-- Sidebar / Tin liên quan -->
        <div class="col-lg-4 mt-5 mt-lg-0 d-flex flex-column h-100">
            <div class="sticky-top mb-5" style="top: 100px;">
                <h5 class="fw-bold mb-4 text-uppercase" style="letter-spacing: 1px;">Tin tức liên quan</h5>
                <div class="d-flex flex-column gap-4">
                    @foreach($relatedPosts as $rp)
                    <div class="d-flex gap-3 align-items-center">
                        <div class="rounded-3 overflow-hidden flex-shrink-0 shadow-sm" style="width: 100px; aspect-ratio: 16/10;">
                            <img src="{{ $rp->thumbnail ? (Str::startsWith($rp->thumbnail, 'http') ? $rp->thumbnail : asset($rp->thumbnail)) : 'https://via.placeholder.com/150x100' }}" class="w-100 h-100 object-fit-cover" alt="{{ $rp->title }}">
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1 small lh-base">
                                <a href="{{ route('posts.show', $rp->slug) }}" class="text-dark text-decoration-none hover-text-danger">{{ $rp->title }}</a>
                            </h6>
                            <span class="text-muted" style="font-size: 11px;">{{ $rp->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .post-content p { margin-bottom: 1.5rem; }
    .breadcrumb-item + .breadcrumb-item::before { content: "\f105"; font-family: "Font Awesome 6 Free"; font-weight: 900; font-size: 10px; color: #ccc; }
    .hover-text-danger:hover { color: #ef4444 !important; }
</style>
@endsection
