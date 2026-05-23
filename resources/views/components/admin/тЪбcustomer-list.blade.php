<?php

use Livewire\Volt\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Order;

new class extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function with()
    {
        $query = User::whereHas('orders');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('email', 'like', "%{$this->search}%");
            });
        }

        $customers = $query->withCount(['orders', 'orders as pending_orders_count' => function($q) {
            $q->where('status', 'pending');
        }])->latest()->paginate(15);

        foreach ($customers as $customer) {
            $customer->total_spent = Order::where('user_id', $customer->id)->where('status', 'completed')->sum('total_price');
        }

        return [
            'customers' => $customers
        ];
    }
};
?>

<div>
    <div class="row align-items-center mb-4 animate-in">
        <div class="col-md-6">
            <h5 class="fw-bold mb-1">Quản lý theo khách hàng</h5>
            <p class="text-muted mb-0" style="font-size: .82rem;">Hiển thị khách hàng có đơn hàng hệ thống (AJAX Powered)</p>
        </div>
        <div class="col-md-6 mt-3 mt-md-0">
            <div class="d-flex justify-content-md-end">
                <div class="input-group shadow-sm rounded-pill overflow-hidden bg-white w-75" style="height: 42px;">
                    <span class="input-group-text border-0 bg-transparent ps-3">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control border-0 ps-1" placeholder="Tìm tên hoặc email khách..." style="font-size: .85rem;">
                    @if($search)
                        <button class="btn btn-white border-0 text-muted px-3" wire:click="$set('search', '')">
                            <i class="fas fa-times"></i>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0" wire:loading.class="opacity-50">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light bg-opacity-50">
                        <tr>
                            <th class="ps-4 border-0 py-3 small text-uppercase fw-bold text-muted">Khách hàng</th>
                            <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Số đơn hàng</th>
                            <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Đơn chờ xử lý</th>
                            <th class="border-0 py-3 small text-uppercase fw-bold text-muted">Tổng chi tiêu</th>
                            <th class="text-end pe-4 border-0 py-3 small text-uppercase fw-bold text-muted">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle bg-primary bg-opacity-10 text-primary fw-bold rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-size: .9rem;">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark" style="font-size: .88rem;">{{ $customer->name }}</div>
                                        <div class="text-muted xx-small">{{ $customer->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark rounded-pill px-3">{{ $customer->orders_count }} đơn</span>
                            </td>
                            <td>
                                @if($customer->pending_orders_count > 0)
                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 fw-bold">
                                        <i class="fas fa-exclamation-circle me-1"></i> {{ $customer->pending_orders_count }} đơn mới
                                    </span>
                                @else
                                    <span class="text-muted x-small">Không có đơn mới</span>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-danger" style="font-size: .85rem;">{{ number_format($customer->total_spent, 0, ',', '.') }} VNĐ</div>
                                <div class="text-muted xx-small">Chỉ tính đơn hoàn thành</div>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.orders.customer', $customer->id) }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold shadow-sm" wire:navigate>
                                    <i class="fas fa-boxes me-1"></i> Quản lý hàng
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @if($customers->isEmpty())
                        <tr>
                            <td colspan="5" class="py-5 text-center text-muted">Không tìm thấy khách hàng phù hợp.</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 py-3 px-4 border-top">
            {{ $customers->links() }}
        </div>
    </div>
</div>