@php
    $currentStatus = $order->status;
    $config = [
        'pending' => ['label' => 'Chờ xác nhận', 'class' => 'status-btn-pending', 'icon' => 'fas fa-clock'],
        'processing' => ['label' => 'Đang xử lý', 'class' => 'status-btn-processing', 'icon' => 'fas fa-spinner fa-spin'],
        'shipping' => ['label' => 'Đang vận chuyển', 'class' => 'status-btn-shipping', 'icon' => 'fas fa-truck'],
        'completed' => ['label' => 'Đã nhận hàng', 'class' => 'status-btn-completed', 'icon' => 'fas fa-check-circle'],
        'cancelled' => ['label' => 'Hủy đơn', 'class' => 'status-btn-cancelled', 'icon' => 'fas fa-times-circle'],
    ];
    $current = $config[$currentStatus] ?? ['label' => $currentStatus, 'class' => 'btn-secondary', 'icon' => 'fas fa-question'];
    $is_mobile = $is_mobile ?? false;
@endphp

<div class="dropdown dropdown-status-elite {{ !$is_mobile ? 'd-flex justify-content-end' : '' }}">
    <button class="btn {{ $current['class'] }} btn-status dropdown-toggle {{ $is_mobile ? 'w-100' : '' }}" 
            type="button" 
            data-bs-toggle="dropdown" 
            data-bs-boundary="viewport"
            aria-expanded="false"
            style="{{ $is_mobile ? 'padding-top: 10px; padding-bottom: 10px;' : '' }}"
            {{ $currentStatus == 'completed' ? 'disabled' : '' }}>
        <i class="{{ $current['icon'] }}"></i>
        {{ $current['label'] }}
        @if($currentStatus != 'completed')
            <i class="fas fa-chevron-down ms-1" style="font-size: 8px;"></i>
        @endif
    </button>
    
    @if($currentStatus != 'completed')
    <ul class="dropdown-menu border-0 shadow-lg" style="z-index: 9999; min-width: 200px;">
        @foreach($config as $key => $item)
            <li>
                <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="{{ $key }}">
                    <button type="submit" class="dropdown-item {{ $currentStatus == $key ? 'active-status' : '' }}">
                        <i class="{{ $item['icon'] }} {{ $key == $currentStatus ? '' : 'text-muted' }}"></i>
                        {{ $item['label'] }}
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
    @endif
</div>
