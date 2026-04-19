@extends('layouts.admin')
@section('page-title', 'Quản lý Đơn hàng')
@section('page-icon', 'images/icon/invoice_icon.webp')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4">
            <form action="{{ route('admin.orders') }}" method="GET">
                <div class="row align-items-center g-3">
                    <div class="col-md-6">
                        <h5 class="fw-bold mb-0">Danh sách Khách hàng</h5>
                    </div>
                    <div class="col-md-6">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-0" placeholder="Tìm tên hoặc email...">
                            <button type="submit" class="btn btn-secondary btn-sm">Tìm kiếm</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Khách hàng</th>
                            <th class="text-center">Số đơn</th>
                            <th class="text-center">Tổng chi tiêu</th>
                            <th class="text-center">Trạng thái</th>
                            <th class="text-end pe-4">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                     <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold overflow-hidden shadow-sm" style="width: 42px; height: 42px; background: #f8fafc; border: 2px solid #fff;">
                                         @if($customer->avatar)
                                             <img src="{{ asset($customer->avatar) }}" class="w-100 h-100 object-fit-cover">
                                         @elseif($customer->social_avatar)
                                             <img src="{{ $customer->social_avatar }}" class="w-100 h-100 object-fit-cover">
                                         @else
                                             <div class="bg-primary bg-opacity-10 text-primary w-100 h-100 d-flex align-items-center justify-content-center">
                                                 {{ mb_strtoupper(mb_substr($customer->name, 0, 1)) }}
                                             </div>
                                         @endif
                                     </div>
                                     <div>
                                         <div class="fw-bold text-dark">{{ $customer->name }}</div>
                                         <div class="text-muted x-small">{{ $customer->email }}</div>
                                     </div>
                                 </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="badge bg-light text-dark border mb-1">{{ $customer->orders_count }} đơn tổng</span>
                                    @if($customer->active_orders_count > 0)
                                        <span class="badge bg-warning bg-opacity-10 text-warning border-warning border-opacity-25 small" style="font-size: 10px;">
                                            {{ $customer->active_orders_count }} đơn cần xử lý
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center fw-bold text-primary">
                                {{ number_format($customer->total_spent ?? 0, 0, ',', '.') }} VNĐ
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-success bg-opacity-10 text-success small px-3">Hoạt động</span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.orders.customer', $customer->id) }}" class="btn btn-white btn-sm shadow-sm border rounded-pill px-3">
                                    <i class="fas fa-eye me-1"></i> Đơn hàng
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-5 text-center text-muted">
                                Không tìm thấy khách hàng nào.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3 px-4 pagination-elite-wrapper">
            {{ $customers->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
