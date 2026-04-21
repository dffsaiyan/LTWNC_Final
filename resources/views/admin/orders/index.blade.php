@extends('layouts.admin')
@section('page-title', 'Danh sách Đơn hàng')
@section('page-icon', 'images/icon/invoice_icon.webp')

@section('content')
<div class="container-fluid px-0">
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 animate-in">
        <div class="card-header bg-white border-0 py-3 px-3 px-md-4">
            <form action="{{ route('admin.orders') }}" method="GET" id="search-form">
                <div class="row align-items-center g-3">
                    <div class="col-12 col-md-6">
                        <h5 class="fw-bold mb-0">Danh sách Khách hàng</h5>
                        <p class="text-muted mb-0 d-none d-md-block" style="font-size: .8rem;">Quản lý và xem lịch sử mua hàng của từng khách</p>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="input-group input-group-sm elite-search-group position-relative">
                            <span class="input-group-text bg-light border-0 ps-3"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="search" id="search-input" value="{{ request('search') }}" 
                                   class="form-control bg-light border-0 py-2" placeholder="Tìm tên hoặc email..." autocomplete="off">
                            <div id="search-spinner" class="position-absolute end-0 top-50 translate-middle-y me-5 d-none">
                                <div class="spinner-border spinner-border-sm text-navy-light" role="status"></div>
                            </div>
                            <button type="submit" class="btn btn-navy-light text-white px-3 fw-bold">Tìm kiếm</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="card-body p-0" id="customer-results">
            @include('admin.orders.partials.customer_list')
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const resultsContainer = document.getElementById('customer-results');
        const spinner = document.getElementById('search-spinner');
        const searchForm = document.getElementById('search-form');
        let debounceTimer;

        // Xử lý khi gõ phím (Live Search)
        searchInput.addEventListener('input', function() {
            clearTimeout(debounceTimer);
            const query = this.value;

            // Hiển thị loading
            spinner.classList.remove('d-none');

            debounceTimer = setTimeout(() => {
                fetchResults(query);
            }, 400); // Đợi 400ms sau khi ngừng gõ mới gửi request
        });

        // Hàm lấy kết quả qua AJAX
        function fetchResults(query) {
            const url = `{{ route('admin.orders') }}?search=${encodeURIComponent(query)}`;
            
            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                resultsContainer.innerHTML = html;
                spinner.classList.add('d-none');
                
                // Cập nhật lại URL trình duyệt mà không load lại trang
                const newUrl = query ? url : '{{ route('admin.orders') }}';
                window.history.pushState({path: newUrl}, '', newUrl);
            })
            .catch(error => {
                console.error('Lỗi tìm kiếm:', error);
                spinner.classList.add('d-none');
            });
        }

        // Ngăn form submit truyền thống
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            fetchResults(searchInput.value);
        });
    });
</script>
@endsection
@endsection
