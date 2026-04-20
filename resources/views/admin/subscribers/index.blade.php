@extends('layouts.admin')

@section('page-title', 'Người đăng ký nhận tin')
@section('page-icon', 'images/icon/subcription_icon.png')

@section('content')
<div class="container-fluid px-0">
    <!-- 🏢 HEADER SECTION -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 animate-in gap-3">
        <div>
            <h5 class="fw-bold mb-1">Danh sách đăng ký</h5>
            <p class="text-muted mb-0" style="font-size: .82rem;">Quản lý danh sách email khách hàng đăng ký nhận tin</p>
        </div>
        <div class="badge bg-ddh-orange px-4 py-2 rounded-pill shadow-sm" style="background: linear-gradient(135deg, var(--ddh-orange), #e8850a); font-weight: 800; font-size: .85rem;">
            Tổng cộng: {{ $subscribers->total() }}
        </div>
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
                                <div class="d-flex align-items-center py-1">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm border" 
                                         style="width: 42px; height: 42px; background: #f8fafc;">
                                        <i class="fas fa-envelope text-navy opacity-50"></i>
                                    </div>
                                    <span class="fw-bold text-dark" style="font-size: .92rem; word-break: break-all;">{{ $sub->email }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="text-muted small fw-bold">
                                    <i class="far fa-calendar-alt me-1 text-orange"></i> {{ $sub->created_at->format('d/m/Y H:i') }}
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <form action="{{ route('admin.subscribers.delete', $sub->id) }}" method="POST" class="confirm-elite" data-prompt="Bạn có chắc muốn xóa email này khỏi danh sách?" data-type="danger">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3 fw-bold border-0" style="font-size: .75rem;">
                                        <i class="fas fa-trash-alt me-1"></i> Xóa
                                    </button>
                                </form>
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

            <!-- 📱 MOBILE LIST VIEW -->
            <div class="d-lg-none p-3 bg-light bg-opacity-50">
                <div class="row g-3">
                    @forelse($subscribers as $sub)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white p-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center shadow-sm border" 
                                         style="width: 40px; height: 40px; background: #f8fafc;">
                                        <i class="fas fa-envelope text-navy opacity-50"></i>
                                    </div>
                                    <div style="min-width: 0; flex: 1;">
                                        <div class="fw-bold text-dark mb-0" style="font-size: .8rem; word-break: break-all;">{{ $sub->email }}</div>
                                        <div class="text-muted x-small" style="font-size: .68rem;">
                                            <i class="far fa-calendar-alt me-1 text-orange"></i> {{ $sub->created_at->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <form action="{{ route('admin.subscribers.delete', $sub->id) }}" method="POST" class="confirm-elite" data-prompt="Xóa email này?" data-type="danger">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger p-2 border-0">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 py-5 text-center text-muted">
                        <i class="fas fa-users-slash fa-3x mb-3 opacity-20"></i>
                        <p class="mb-0 fw-bold">Trống danh sách</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        @if($subscribers->hasPages())
        <div class="card-footer bg-white border-0 py-3 px-4 pagination-elite-wrapper">
            {{ $subscribers->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
