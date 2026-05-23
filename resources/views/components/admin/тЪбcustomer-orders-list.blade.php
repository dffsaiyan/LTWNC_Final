<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Order;

new class extends Component
{
    use WithPagination;

    public $userId;
    public $statusFilter = '';

    public function mount($userId)
    {
        $this->userId = $userId;
    }

    public function updateStatus($orderId, $status)
    {
        $order = Order::findOrFail($orderId);
        $order->status = $status;
        $order->save();

        session()->flash('success', 'Đã cập nhật trạng thái đơn hàng #DDH-' . $orderId);
    }

    public function with()
    {
        $customer = User::findOrFail($this->userId);
        $query = Order::where('user_id', $this->userId)->with('user');

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $orders = $query->latest()->paginate(15);

        return [
            'customer' => $customer,
            'orders' => $orders
        ];
    }
};
?>

<div>
    <!-- Stats for this user -->
    <div class="row g-3 mb-4 animate-in delay-1" wire:loading.class="opacity-50">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="text-muted x-small mb-1">Email liên hệ</div>
                <div class="fw-bold text-dark">{{ $customer->email }}</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="text-muted x-small mb-1">Tổng đơn hàng</div>
                <div class="fw-bold text-primary">{{ $orders->total() }} đơn</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                <div class="text-muted x-small mb-1">ID Khách hàng</div>
                <div class="fw-bold text-muted">#USR-{{ str_pad($customer->id, 4, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="mb-4 d-flex justify-content-end">
        <select wire:model.live="statusFilter" class="form-select form-select-sm rounded-pill px-3 shadow-sm border-0 w-auto" style="height: 38px; font-size: .8rem;">
            <option value="">Tất cả trạng thái</option>
            <option value="pending">Chờ xác nhận</option>
            <option value="processing">Đang xử lý</option>
            <option value="shipping">Đang vận chuyển</option>
            <option value="completed">Hoàn thành</option>
            <option value="cancelled">Đã hủy</option>
        </select>
    </div>

    <!-- Orders Table -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0" wire:loading.class="opacity-50">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="bg-light bg-opacity-50">
                        <tr>
                            <th class="ps-4 border-0 py-3 small fw-bold">Mã đơn</th>
                            <th class="border-0 py-3 small fw-bold">Ngày đặt</th>
                            <th class="border-0 py-3 small fw-bold">Tổng tiền</th>
                            <th class="text-center border-0 py-3 small fw-bold">Trạng thái</th>
                            <th class="text-end pe-4 border-0 py-3 small fw-bold">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr wire:key="order-{{ $order->id }}">
                            <td class="ps-4 fw-bold text-dark">#DDH-{{ $order->id }}</td>
                            <td class="text-muted small">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <div class="fw-bold text-danger">{{ number_format($order->total_price, 0, ',', '.') }} VNĐ</div>
                                <div class="xx-small text-muted">{{ $order->payment_method == 'cod' ? 'Thanh toán COD' : 'Chuyển khoản' }}</div>
                            </td>
                            <td class="text-center">
                                <select class="form-select form-select-sm rounded-pill px-3 fw-bold border-0 shadow-sm" 
                                    style="font-size: .7rem; width: 140px; background-color: #f8fafc;"
                                    wire:change="updateStatus({{ $order->id }}, $event.target.value)">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xác nhận</option>
                                    <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                    <option value="shipping" {{ $order->status == 'shipping' ? 'selected' : '' }}>Đang vận chuyển</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                </select>
                            </td>
                            <td class="text-end pe-4">
                                <a href="#" class="btn btn-outline-dark btn-sm rounded-pill px-3 shadow-sm border" style="font-size: .75rem;">
                                    <i class="fas fa-eye me-1"></i> Xem chi tiết
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-5 text-center text-muted">Không tìm thấy đơn hàng nào.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3 px-4 border-top">
            {{ $orders->links() }}
        </div>
    </div>
</div>