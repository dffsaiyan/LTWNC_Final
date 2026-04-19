@extends('layouts.admin')

@section('page-title', 'Quản lý Người dùng')
@section('page-icon', 'images/icon/user_icon.webp')

@section('content')
<div class="container-fluid px-0">
    <div class="mb-4 animate-in">
        <h5 class="fw-bold mb-1">Danh sách người dùng</h5>
        <p class="text-muted mb-0" style="font-size: .82rem;">Tổng cộng {{ $users->total() }} tài khoản đã đăng ký</p>
    </div>

    <div class="card animate-in delay-1">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Người dùng</th>
                            <th>Email</th>
                            <th>Tham gia</th>
                            <th class="text-center">Vai trò</th>
                            <th class="text-end pe-4">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('images/favicon.jpg') }}" class="rounded-circle" width="38" height="38" style="border: 2px solid {{ $user->is_admin ? 'var(--ddh-orange)' : 'var(--ddh-border)' }};">
                                    <div>
                                        <div class="fw-bold" style="font-size: .88rem;">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                                <span class="badge bg-info bg-opacity-10 text-info ms-1" style="font-size: .65rem;">Bạn</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-size: .85rem; color: var(--ddh-muted);">{{ $user->email }}</td>
                            <td style="font-size: .78rem; color: var(--ddh-muted);">{{ $user->created_at->format('d/m/Y') }}</td>
                            <td class="text-center">
                                @if($user->is_admin)
                                    <span class="badge rounded-pill px-3 py-1" style="background: linear-gradient(135deg, var(--ddh-orange), #e8850a); font-size: .72rem; font-weight: 700;">Administrator</span>
                                @else
                                    <span class="badge-outline" style="border-color: var(--ddh-border); color: var(--ddh-muted); font-size: .72rem;">Customer</span>
                                @endif
                                
                                @if($user->can_write_posts || $user->email === 'admin@ddh.com')
                                    <div class="mt-1">
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1" style="font-size: .6rem;">
                                            <i class="fas fa-edit me-1"></i>Writer
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                @if($user->email !== 'admin@ddh.com')
                                <div class="d-flex flex-column gap-1 align-items-end">
                                    <form action="{{ route('admin.users.toggle_admin', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="button" class="btn btn-sm rounded-pill px-3 {{ $user->is_admin ? 'btn-outline-danger' : 'btn-outline-success' }} confirm-elite" 
                                            style="font-size: .78rem;" 
                                            data-prompt="{{ $user->is_admin ? 'Gỡ quyền Quản trị viên của người dùng này?' : 'Cấp quyền Quản trị viên cho người dùng này?' }}"
                                            data-type="{{ $user->is_admin ? 'danger' : 'warning' }}"
                                            data-btn-text="{{ $user->is_admin ? 'Gỡ quyền' : 'Cấp quyền' }}">
                                            <i class="fas {{ $user->is_admin ? 'fa-user-minus' : 'fa-user-plus' }} me-1"></i>
                                            {{ $user->is_admin ? 'Gỡ Admin' : 'Cấp Admin' }}
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.toggle_write', $user->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="button" class="btn btn-sm rounded-pill px-3 {{ $user->can_write_posts ? 'btn-outline-warning' : 'btn-outline-info' }} confirm-elite" 
                                            style="font-size: .78rem;"
                                            data-prompt="{{ $user->can_write_posts ? 'Gỡ quyền viết bài của người dùng này?' : 'Cấp quyền viết bài cho người dùng này?' }}"
                                            data-type="warning"
                                            data-btn-text="Xác nhận">
                                            <i class="fas {{ $user->can_write_posts ? 'fa-pen-slash' : 'fa-pen' }} me-1"></i>
                                            {{ $user->can_write_posts ? 'Gỡ quyền viết' : 'Cấp quyền viết' }}
                                        </button>
                                    </form>
                                </div>
                                @else
                                <span class="badge bg-dark text-warning border border-warning py-2 px-3 rounded-pill" style="font-size: .7rem;">
                                    <i class="fas fa-crown me-1"></i> Super Admin
                                </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
        <div class="card-footer bg-white border-0 py-3 px-4">{{ $users->links() }}</div>
        @endif
    </div>
</div>
@endsection
