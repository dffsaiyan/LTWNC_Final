@extends('layouts.admin')
@section('page-title', 'Quản lý Bài viết')
@section('page-icon', 'images/icon/newspaper_icon.png')

@section('content')
<div class="container-fluid px-0">
    <!-- 🏢 HEADER SECTION -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 animate-in gap-3">
        <div>
            <h5 class="fw-bold mb-1">Danh sách bài viết</h5>
            <p class="text-muted mb-0" style="font-size: .82rem;">Quản lý tin tức công nghệ trên hệ thống</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-ddh-primary rounded-pill px-4 shadow-sm" style="font-size: .85rem; font-weight: 700;">
            <i class="fas fa-pen-nib me-2"></i>Viết bài mới
        </a>
    </div>

    @if(session('success'))
        <div class="admin-alert admin-alert-success animate-in">
            <i class="fas fa-check-circle"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card animate-in delay-1 border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <!-- 🖥️ DESKTOP TABLE VIEW -->
            <div class="table-responsive d-none d-lg-block">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3">Bài viết</th>
                            <th>Tác giả</th>
                            <th>Ngày đăng</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-end pe-4">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3 py-2">
                                    <div class="rounded-3 overflow-hidden shadow-sm border" style="width: 100px; aspect-ratio: 16/10; flex-shrink: 0; background: #f8fafc;">
                                        <img src="{{ $post->thumbnail ? (Str::startsWith($post->thumbnail, 'http') ? $post->thumbnail : asset($post->thumbnail)) : 'https://via.placeholder.com/160x100' }}" class="w-100 h-100 object-fit-cover">
                                    </div>
                                    <div style="max-width: 400px;">
                                        <div class="fw-bold text-dark mb-1" style="font-size: .88rem; line-height: 1.4;">{{ $post->title }}</div>
                                        <div class="text-muted text-truncate" style="font-size: .75rem;">{{ $post->summary }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-navy-light text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" 
                                         style="width: 28px; height: 28px; font-size: .65rem; background: var(--ddh-navy-light);">
                                        {{ mb_strtoupper(mb_substr($post->user->name, 0, 1)) }}
                                    </div>
                                    <span class="fw-semibold" style="font-size: .8rem; color: var(--ddh-navy);">{{ $post->user->name }}</span>
                                </div>
                            </td>
                            <td style="font-size: .8rem; color: var(--ddh-muted);">{{ $post->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                @if($post->is_published)
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1-5 fw-bold" style="font-size: .65rem;">
                                        <i class="fas fa-check-circle me-1"></i>Đã đăng
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3 py-1-5 fw-bold" style="font-size: .65rem;">
                                        <i class="fas fa-clock me-1"></i>Bản nháp
                                    </span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold" style="font-size: .75rem;">
                                        <i class="fas fa-edit me-1"></i>Sửa
                                    </a>
                                    <form action="{{ route('admin.posts.delete', $post->id) }}" method="POST" class="confirm-elite" data-prompt="Bạn có chắc chắn muốn xóa bài viết này?" data-type="danger">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" style="font-size: .75rem;">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-5 text-center text-muted">
                                <i class="fas fa-newspaper fa-3x mb-3 opacity-20"></i>
                                <p class="mb-0 fw-bold">Chưa có bài viết nào</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 📱 MOBILE CARD VIEW -->
            <div class="d-lg-none p-3 bg-light bg-opacity-50">
                <div class="row g-3">
                    @forelse($posts as $post)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                            <div class="position-relative">
                                <div style="aspect-ratio: 16/9; overflow: hidden; background: #f8fafc;">
                                    <img src="{{ $post->thumbnail ? (Str::startsWith($post->thumbnail, 'http') ? $post->thumbnail : asset($post->thumbnail)) : 'https://via.placeholder.com/160x100' }}" class="w-100 h-100 object-fit-cover">
                                </div>
                                <div class="position-absolute top-0 end-0 m-2">
                                    @if($post->is_published)
                                        <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm" style="font-size: .65rem; font-weight: 800;">ĐÃ ĐĂNG</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3 py-2 shadow-sm" style="font-size: .65rem; font-weight: 800;">BẢN NHÁP</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <div class="fw-bold text-dark mb-2" style="font-size: .95rem; line-height: 1.4;">{{ $post->title }}</div>
                                <div class="text-muted mb-3" style="font-size: .78rem; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    {{ $post->summary }}
                                </div>
                                
                                <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-navy text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" 
                                             style="width: 24px; height: 24px; font-size: .6rem; background: var(--ddh-navy);">
                                            {{ mb_strtoupper(mb_substr($post->user->name, 0, 1)) }}
                                        </div>
                                        <div class="x-small">
                                            <div class="fw-bold text-dark" style="font-size: .7rem;">{{ $post->user->name }}</div>
                                            <div class="text-muted" style="font-size: .65rem;">{{ $post->created_at->format('d/m/Y') }}</div>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-light border rounded-pill px-3 fw-bold" style="font-size: .75rem;">
                                            <i class="fas fa-edit me-1"></i>Sửa
                                        </a>
                                        <form action="{{ route('admin.posts.delete', $post->id) }}" method="POST" class="confirm-elite" data-prompt="Xóa bài viết này?" data-type="danger">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-2">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 py-5 text-center text-muted">
                        <i class="fas fa-newspaper fa-3x mb-3 opacity-20"></i>
                        <p class="mb-0 fw-bold">Chưa có bài viết nào</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        @if($posts->hasPages())
        <div class="card-footer bg-white border-0 py-3 px-4 pagination-elite-wrapper">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
