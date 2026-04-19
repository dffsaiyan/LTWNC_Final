@extends('layouts.admin')

@section('page-title', 'Người đăng ký nhận tin')
@section('page-icon', 'images/icon/subcription_icon.png')

@section('content')
<div class="container-fluid">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Người đăng ký nhận tin</h1>
        <div class="badge bg-primary px-3 py-2 rounded-pill shadow-sm">
            Tổng cộng: {{ $subscribers->total() }}
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow border-0 rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 border-0 py-3" style="width: 80px;">ID</th>
                            <th class="border-0 py-3">Địa chỉ Email</th>
                            <th class="border-0 py-3">Ngày đăng ký</th>
                            <th class="pe-4 border-0 py-3 text-end" style="width: 150px;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscribers as $sub)
                        <tr>
                            <td class="ps-4 text-muted fw-bold">#{{ $sub->id }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-envelope text-primary opacity-50"></i>
                                    </div>
                                    <span class="fw-bold text-dark">{{ $sub->email }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted small fw-bold">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $sub->created_at->format('d/m/Y H:i') }}
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <a href="{{ route('admin.subscribers.delete', $sub->id) }}" class="btn btn-outline-danger btn-sm rounded-pill px-3 shadow-none border-0" onclick="return confirm('Bạn có chắc muốn xóa email này không?')">
                                    <i class="fas fa-trash-alt me-1"></i> Xóa
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="mb-3"><i class="fas fa-users-slash fa-3x text-light"></i></div>
                                <p class="text-muted fw-bold">Chưa có ai đăng ký nhận tin.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $subscribers->links() }}
    </div>
</div>
@endsection
