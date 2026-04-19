@extends('layouts.admin')
@section('page-title', 'Quản lý Bài viết')
@section('page-icon', 'images/icon/newspaper_icon.png')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4 animate-in">
        <div>
            <h5 class="fw-bold mb-1">Danh sách bài viết</h5>
            <p class="text-muted mb-0" style="font-size: .82rem;">Quản lý tin tức công nghệ trên hệ thống</p>
        </div>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary rounded-pill px-4" style="font-size: .85rem; font-weight: 700;">
            <i class="fas fa-plus me-2"></i>Viết bài mới
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 p-3 mb-4 animate-in">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        </div>
    @endif

    <div class="card animate-in delay-1 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Bài viết</th>
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
                                <div class="d-flex align-items-center gap-3 py-1">
                                    <div class="rounded-3 overflow-hidden shadow-sm" style="width: 80px; aspect-ratio: 16/10;">
                                        <img src="{{ $post->thumbnail ? (Str::startsWith($post->thumbnail, 'http') ? $post->thumbnail : asset($post->thumbnail)) : 'https://via.placeholder.com/160x100' }}" class="w-100 h-100 object-fit-cover">
                                    </div>
                                    <div style="max-width: 350px;">
                                        <div class="fw-bold text-dark text-truncate" style="font-size: .88rem;">{{ $post->title }}</div>
                                        <div class="text-muted text-truncate" style="font-size: .75rem;">{{ $post->summary }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: .6rem; font-weight: 800;">
                                        {{ mb_strtoupper(mb_substr($post->user->name, 0, 1)) }}
                                    </div>
                                    <span class="fw-semibold" style="font-size: .8rem;">{{ $post->user->name }}</span>
                                </div>
                            </td>
                            <td style="font-size: .8rem; color: var(--ddh-muted);">{{ $post->created_at->format('d/m/Y H:i') }}</td>
                            <td class="text-center">
                                @if($post->is_published)
                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3" style="font-size: .65rem;">Đã đăng</span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary rounded-pill px-3" style="font-size: .65rem;">Bản nháp</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-light rounded-pill px-3" style="font-size: .75rem;">
                                        <i class="fas fa-edit me-1"></i>Sửa
                                    </a>
                                    <form action="{{ route('admin.posts.delete', $post->id) }}" method="POST" onsubmit="return confirm('Xóa bài viết này?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" style="font-size: .75rem;">
                                            <i class="fas fa-trash me-1"></i>Xóa
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
        </div>
        @if($posts->hasPages())
        <div class="card-footer bg-white border-0 py-3">{{ $posts->links() }}</div>
        @endif
    </div>
</div>
@endsection
