<?php

use Livewire\Volt\Component;
use App\Models\Order;
use App\Models\User;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $userId;
    public $status = '';

    public function mount($userId)
    {
        $this->userId = $userId;
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updateOrderStatus($orderId, $newStatus)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->update(['status' => $newStatus]);
            $this->dispatch('swal:alert', [
                'type' => 'success',
                'title' => 'Thành công',
                'text' => 'Trạng thái đơn hàng #' . $order->order_id . ' đã được cập nhật!',
            ]);
        }
    }

    public function with()
    {
        $query = Order::where('user_id', $this->userId);

        if ($this->status) {
            $query->where('status', $this->status);
        }

        $orders = $query->latest()->paginate(10);
        $customer = User::find($this->userId);

        return [
            'orders' => $orders,
            'customer' => $customer,
        ];
    }
};
?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-0 py-3 px-4">
        <div class="row align-items-center g-3">
            <div class="col-md-6">
                <h6 class="fw-bold mb-0">Lịch sử đặt hàng</h6>
            </div>
            <div class="col-md-6">
                <select wire:model.live="status" class="form-select form-select-sm bg-light border-0">
                    <option value="">Tất cả trạng thái</option>
                    <option value="pending">Chờ xử lý</option>
                    <option value="processing">Đang xử lý</option>
                    <option value="completed">Hoàn thành</option>
                    <option value="cancelled">Đã hủy</option>
                </select>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Mã đơn</th>
                        <th class="text-center">Ngày đặt</th>
                        <th class="text-center">Giá trị</th>
                        <th class="text-center">Trạng thái</th>
                        <th class="text-end pe-4">Cập nhật nhanh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr wire:key="order-{{ $order->id }}">
                        <td class="ps-4 fw-bold text-dark">#{{ $order->order_id }}</td>
                        <td class="text-center text-muted small">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-center fw-bold">{{ number_format($order->total_amount, 0, ',', '.') }} VNĐ</td>
                        <td class="text-center">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-warning text-dark',
                                    'processing' => 'bg-primary text-white',
                                    'completed' => 'bg-success text-white',
                                    'cancelled' => 'bg-danger text-white'
                                ];
                                $statusLabels = [
                                    'pending' => 'Chờ xử lý',
                                    'processing' => 'Đang xử lý',
                                    'completed' => 'Hoàn thành',
                                    'cancelled' => 'Đã hủy'
                                ];
                            @endphp
                            <span class="badge rounded-pill {{ $statusClasses[$order->status] ?? 'bg-secondary' }} px-3">
                                {{ $statusLabels[$order->status] ?? $order->status }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <select class="form-select form-select-sm border shadow-sm d-inline-block w-auto rounded-pill" 
                                    style="font-size: 11px;"
                                    wire:change="updateOrderStatus({{ $order->id }}, $event.target.value)">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Hủy đơn</option>
                            </select>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-5 text-center text-muted">Không có đơn hàng nào.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3 px-4">
        {{ $orders->links() }}
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('swal:alert', (data) => {
                const eventData = Array.isArray(data) ? data[0] : data;
                Swal.fire({
                    title: eventData.title,
                    text: eventData.text,
                    icon: eventData.type,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        });
    </script>
</div>
