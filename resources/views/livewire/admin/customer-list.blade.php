<?php

use Livewire\Volt\Component;
use App\Models\User;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function with()
    {
        $query = User::whereHas('orders');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $customers = $query->withCount('orders')
            ->withSum('orders', 'total_amount')
            ->latest()
            ->paginate(10);

        return [
            'customers' => $customers,
        ];
    }
};
?>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-0 py-3 px-4">
        <div class="row align-items-center g-3">
            <div class="col-md-6">
                <h5 class="fw-bold mb-0">Danh sách Khách hàng</h5>
            </div>
            <div class="col-md-6">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" wire:model.live.debounce.300ms="search" class="form-control bg-light border-0" placeholder="Tìm tên hoặc email...">
                </div>
            </div>
        </div>
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
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px;">
                                    {{ substr($customer->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark">{{ $customer->name }}</div>
                                    <div class="text-muted x-small">{{ $customer->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark border">{{ $customer->orders_count }} đơn</span>
                        </td>
                        <td class="text-center fw-bold text-primary">
                            {{ number_format($customer->orders_sum_total_amount ?? 0, 0, ',', '.') }} VNĐ
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success small px-3">Hoạt động</span>
                        </td>
                        <td class="text-end pe-4">
                            <a href="{{ route('admin.orders.customer', $customer->id) }}" class="btn btn-white btn-sm shadow-sm border rounded-pill px-3" wire:navigate>
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
    <div class="card-footer bg-white border-0 py-3 px-4">
        {{ $customers->links() }}
    </div>
</div>
