@extends('layouts.admin')
@section('page-icon', 'fas fa-tags')
@section('page-title', 'Mã giảm giá')

@section('content')
<div class="container-fluid px-0">
    <div class="row g-4">
        <!-- List -->
        <div class="col-lg-8 animate-in">
            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <!-- Desktop Table -->
                    <div class="table-responsive d-none d-lg-block">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr class="bg-light">
                                    <th class="ps-4 py-3">Mã CODE</th>
                                    <th class="py-3">Loại / Giá trị</th>
                                    <th class="py-3">Tối thiểu</th>
                                    <th class="py-3">Lượt dùng</th>
                                    <th class="py-3">Áp dụng</th>
                                    <th class="py-3">Hạn dùng</th>
                                    <th class="text-end pe-4 py-3">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coupons as $coupon)
                                <tr>
                                    <td class="ps-4">
                                        <code class="fw-bold fs-6" style="color: var(--ddh-blue); background: rgba(0,86,150,.06); padding: 4px 12px; border-radius: 6px;">{{ $coupon->code }}</code>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold text-danger">{{ $coupon->type == 'percent' ? $coupon->value . '%' : number_format($coupon->value, 0, ',', '.') . ' VNĐ' }}</span>
                                            <span class="text-muted xx-small uppercase">{{ $coupon->type == 'percent' ? 'Giảm %' : 'Giảm tiền mặt' }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="text-dark small fw-bold">{{ number_format($coupon->min_order_value, 0, ',', '.') }} VNĐ</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-bold small">{{ $coupon->used_count }} / {{ $coupon->max_uses ?? '♾️' }}</span>
                                            <div class="progress mt-1" style="height: 4px; width: 60px;">
                                                @php 
                                                    $progress = 0;
                                                    if($coupon->max_uses) {
                                                        $progress = ($coupon->used_count / $coupon->max_uses) * 100;
                                                    }
                                                @endphp
                                                <div class="progress-bar bg-{{ $progress >= 100 ? 'danger' : 'success' }}" role="progressbar" style="width: {{ $progress }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($coupon->category)
                                            <span class="badge bg-light text-dark border rounded-pill px-2" style="font-size: 10px;">
                                                <i class="fas fa-folder-open me-1 opacity-50"></i>{{ $coupon->category->name }}
                                            </span>
                                        @else
                                            <span class="badge bg-dark text-white rounded-pill px-2" style="font-size: 10px;">Tất cả SP</span>
                                        @endif
                                    </td>
                                    <td style="font-size: .82rem; color: var(--ddh-muted);">
                                        {{ $coupon->expiry_date ? \Carbon\Carbon::parse($coupon->expiry_date)->format('d/m/Y') : 'Vô hạn' }}
                                    </td>
                                    <td class="text-end pe-4">
                                        <form action="{{ route('admin.coupons.delete', $coupon->id) }}" method="POST" class="d-inline confirm-elite" data-prompt="Xóa mã giảm giá này?" data-type="danger">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 shadow-none border-0">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="7" class="text-center py-5 text-muted fw-bold">Chưa có mã giảm giá nào được tạo.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Cards -->
                    <div class="d-lg-none p-3">
                        <div class="row g-3">
                            @forelse($coupons as $coupon)
                            <div class="col-12">
                                <div class="card border shadow-sm rounded-4 bg-white p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <code class="fw-bold" style="color: var(--ddh-blue); background: rgba(0,86,150,.06); padding: 4px 12px; border-radius: 6px;">{{ $coupon->code }}</code>
                                        <form action="{{ route('admin.coupons.delete', $coupon->id) }}" method="POST" class="d-inline confirm-elite" data-prompt="Xóa mã giảm giá này?" data-type="danger">
                                            @csrf
                                            <button type="submit" class="btn btn-link text-danger p-0 border-0">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="text-muted x-small uppercase">Giá trị</div>
                                            <div class="fw-bold text-danger">{{ $coupon->type == 'percent' ? $coupon->value . '%' : number_format($coupon->value, 0, ',', '.') . ' VNĐ' }}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted x-small uppercase">Tối thiểu</div>
                                            <div class="fw-bold text-dark" style="font-size: .85rem;">{{ number_format($coupon->min_order_value, 0, ',', '.') }} VNĐ</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted x-small uppercase">Lượt dùng</div>
                                            <div class="fw-bold small">{{ $coupon->used_count }} / {{ $coupon->max_uses ?? '♾️' }}</div>
                                        </div>
                                        <div class="col-6">
                                            <div class="text-muted x-small uppercase">Hạn dùng</div>
                                            <div class="fw-bold" style="font-size: .82rem;">{{ $coupon->expiry_date ? \Carbon\Carbon::parse($coupon->expiry_date)->format('d/m/Y') : 'Vô hạn' }}</div>
                                        </div>
                                        <div class="col-12 mt-2 pt-2 border-top">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="text-muted x-small uppercase">Áp dụng:</span>
                                                @if($coupon->category)
                                                    <span class="badge bg-light text-dark border rounded-pill px-2" style="font-size: 10px;">{{ $coupon->category->name }}</span>
                                                @else
                                                    <span class="badge bg-dark text-white rounded-pill px-2" style="font-size: 10px;">Tất cả SP</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="col-12 text-center py-4 text-muted fw-bold">Chưa có mã giảm giá.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Form -->
        <div class="col-lg-4 animate-in delay-1">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4 d-flex align-items-center">
                        <span class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                            <i class="fas fa-plus text-warning"></i>
                        </span>
                        Tạo mã giảm giá mới
                    </h6>
                    <form action="{{ route('admin.coupons.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase" style="letter-spacing: 0.5px;">Mã CODE <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control rounded-3" placeholder="VD: ELITE2026" required style="text-transform: uppercase; font-weight: 700;">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Loại giảm giá</label>
                                <select name="type" class="form-select rounded-3">
                                    <option value="percent">Giảm phần trăm (%)</option>
                                    <option value="fixed">Giảm tiền (VNĐ)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Giá trị <span class="text-danger">*</span></label>
                                <input type="number" name="value" class="form-control rounded-3" placeholder="10 hoặc 50000" required>
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Đơn tối thiểu</label>
                                <input type="number" name="min_order_value" class="form-control rounded-3" placeholder="0" value="0">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-uppercase">Giới hạn lượt</label>
                                <input type="number" name="max_uses" class="form-control rounded-3" placeholder="♾️">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-uppercase">Áp dụng cho danh mục</label>
                            <select name="category_id" class="form-select rounded-3">
                                <option value="">Tất cả sản phẩm</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase">Ngày hết hạn</label>
                            <input type="text" name="expiry_date" id="expiry_date_picker" class="form-control rounded-3 bg-white" placeholder="Chọn ngày hết hạn..." readonly>
                        </div>

                        <button type="submit" class="btn btn-warning w-100 rounded-pill py-2 fw-bold text-dark shadow-sm">
                            <i class="fas fa-save me-2"></i> LƯU MÃ GIẢM GIÁ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#expiry_date_picker", {
            locale: "vn",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d/m/Y",
            minDate: "today", // Chặn ngày trong quá khứ
            disableMobile: true, // Chỉnh lại thành boolean true
            animate: true,
            allowInput: false, // Không cho phép gõ tay để tránh lỗi
            clickOpens: true
        });
    });
</script>
@endsection
