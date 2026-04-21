<!-- 🖥️ DESKTOP TABLE VIEW -->
<div class="table-responsive d-none d-lg-block">
    <table class="table align-middle mb-0">
        <thead class="bg-light">
            <tr>
                <th class="ps-4 py-3">Khách hàng</th>
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
                         <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold overflow-hidden shadow-sm border" style="width: 44px; height: 44px; background: #f8fafc;">
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
                             <div class="text-muted x-small" style="word-break: break-all;">{{ $customer->email }}</div>
                         </div>
                     </div>
                </td>
                <td class="text-center">
                    <div class="d-flex flex-column align-items-center">
                        <span class="badge bg-light text-dark border mb-1 fw-bold px-3">{{ $customer->orders_count }} đơn tổng</span>
                        @if($customer->active_orders_count > 0)
                            <span class="badge bg-warning bg-opacity-10 text-warning border-warning border-opacity-25 small fw-bold" style="font-size: 10px;">
                                {{ $customer->active_orders_count }} đơn cần xử lý
                            </span>
                        @endif
                    </div>
                </td>
                <td class="text-center fw-bold text-navy">
                    {{ number_format($customer->total_spent ?? 0, 0, ',', '.') }} VNĐ
                </td>
                <td class="text-center">
                    <span class="badge rounded-pill bg-success bg-opacity-10 text-success small px-3 py-1-5 fw-bold">Hoạt động</span>
                </td>
                <td class="text-end pe-4">
                    <a href="{{ route('admin.orders.customer', $customer->id) }}" class="btn btn-white btn-sm shadow-sm border rounded-pill px-4 fw-bold">
                        <i class="fas fa-eye me-1"></i> Xem đơn
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="py-5 text-center text-muted">
                    <i class="fas fa-users-slash fa-3x mb-3 opacity-20"></i>
                    <p class="mb-0 fw-bold">Không tìm thấy khách hàng nào</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- 📱 MOBILE CARD VIEW -->
<div class="d-lg-none p-3 bg-light bg-opacity-50">
    <div class="row g-3">
        @forelse($customers as $customer)
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold overflow-hidden shadow-sm border" style="width: 48px; height: 48px; background: #f8fafc; flex-shrink: 0;">
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
                            <div style="min-width: 0; padding-right: 70px;">
                                <div class="fw-bold text-dark text-truncate" style="font-size: .9rem;">{{ $customer->name }}</div>
                                <div class="text-muted text-truncate" style="font-size: .68rem;">{{ $customer->email }}</div>
                            </div>
                        </div>
                        <div class="position-absolute" style="top: 15px; right: 15px;">
                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success small px-2 py-1 fw-bold" style="font-size: .6rem;">Hoạt động</span>
                        </div>
                    </div>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="bg-light rounded-3 p-2 text-center">
                                <div class="text-muted x-small mb-1">Tổng đơn</div>
                                <div class="fw-bold text-dark" style="font-size: .85rem;">{{ $customer->orders_count }}</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-light rounded-3 p-2 text-center">
                                <div class="text-muted x-small mb-1">Chi tiêu</div>
                                <div class="fw-bold text-navy" style="font-size: .85rem;">{{ number_format($customer->total_spent ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        @if($customer->active_orders_count > 0)
                        <div class="col-12">
                            <div class="bg-warning bg-opacity-10 rounded-3 p-2 text-center border border-warning border-opacity-25">
                                <span class="text-warning fw-bold small"><i class="fas fa-exclamation-circle me-1"></i>{{ $customer->active_orders_count }} đơn cần xử lý</span>
                            </div>
                        </div>
                        @endif
                    </div>

                    <a href="{{ route('admin.orders.customer', $customer->id) }}" class="btn btn-navy w-100 rounded-pill fw-bold text-white shadow-sm" style="font-size: .85rem; background-color: #0f172a; padding-top: 10px; padding-bottom: 10px;">
                        <i class="fas fa-eye me-1"></i> Xem danh sách đơn hàng
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 py-5 text-center text-muted">
            <i class="fas fa-users-slash fa-3x mb-3 opacity-20"></i>
            <p class="mb-0 fw-bold">Không tìm thấy khách hàng nào</p>
        </div>
        @endforelse
    </div>
</div>

@if($customers->hasPages())
<div class="card-footer bg-white border-0 py-3 px-4 pagination-elite-wrapper">
    {{ $customers->links() }}
</div>
@endif
