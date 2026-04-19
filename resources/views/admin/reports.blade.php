@extends('layouts.admin')

@section('page-title', 'Báo cáo doanh thu')
@section('page-icon', 'images/icon/chart_icon.png')

@section('content')
<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4 animate-in">
        <div>
            <h5 class="fw-bold mb-1">Báo cáo tổng hợp</h5>
            <p class="text-muted mb-0" style="font-size: .82rem;">Phân tích doanh thu và sản phẩm bán chạy năm {{ date('Y') }}</p>
        </div>
        <a href="{{ route('admin.reports.export') }}" class="btn btn-ddh-primary rounded-pill px-4">
            <i class="fas fa-file-csv me-2"></i>Xuất CSV
        </a>
    </div>

    <div class="row g-4">
        <!-- Revenue Chart -->
        <div class="col-lg-8 animate-in delay-1">
            <div class="card h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="fw-bold mb-0"><i class="fas fa-chart-bar me-2" style="color: var(--ddh-blue);"></i>Doanh thu theo tháng</h6>
                        <span class="badge-outline" style="border-color: var(--ddh-success); color: var(--ddh-success);">{{ date('Y') }}</span>
                    </div>
                    <div style="height: 380px;">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Selling Products -->
        <div class="col-lg-4 animate-in delay-2">
            <div class="card h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-4"><i class="fas fa-trophy me-2" style="color: var(--ddh-orange);"></i>Top sản phẩm bán chạy</h6>
                    <div class="d-flex flex-column gap-2">
                        @foreach($top_products as $item)
                        <div class="d-flex align-items-center gap-3 p-2 rounded-3" style="background: {{ $loop->iteration <= 3 ? 'rgba(247,148,30,.04)' : 'transparent' }};">
                            <span class="fw-bold d-flex align-items-center justify-content-center rounded-circle flex-shrink-0"
                                  style="width: 28px; height: 28px; font-size: .72rem;
                                         {{ $loop->iteration <= 3 ? 'background: linear-gradient(135deg, var(--ddh-orange), #e8850a); color: #fff;' : 'background: var(--ddh-bg); color: var(--ddh-muted);' }}">
                                {{ $loop->iteration }}
                            </span>
                            <div class="flex-grow-1 min-w-0">
                                <div class="fw-bold text-truncate" style="font-size: .82rem;">{{ $item->product ? $item->product->name : 'Đã xóa' }}</div>
                                <div style="font-size: .7rem; color: var(--ddh-muted);">Đã bán: <span class="fw-bold" style="color: var(--ddh-danger);">{{ $item->total_sold }}</span> chiếc</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
    const monthlyData = @json($monthly_revenue);
    const monthNames = ["Th. 1", "Th. 2", "Th. 3", "Th. 4", "Th. 5", "Th. 6", "Th. 7", "Th. 8", "Th. 9", "Th. 10", "Th. 11", "Th. 12"];
    const labels = monthNames.slice(0, new Date().getMonth() + 1);
    const values = labels.map((m, i) => {
        const found = monthlyData.find(d => d.month === (i + 1));
        return found ? found.total : 0;
    });

    const gradient = ctxMonthly.createLinearGradient(0, 0, 0, 380);
    gradient.addColorStop(0, 'rgba(0, 86, 150, 0.3)');
    gradient.addColorStop(1, 'rgba(0, 86, 150, 0.0)');

    new Chart(ctxMonthly, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: values,
                backgroundColor: gradient,
                borderColor: '#005696',
                borderWidth: 1.5,
                borderRadius: 8,
                borderSkipped: false,
                hoverBackgroundColor: 'rgba(247, 148, 30, 0.7)',
            }]
        },
        options: {
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#0d2137', titleColor: '#F7941E', bodyColor: '#fff',
                    padding: 12, cornerRadius: 10, displayColors: false,
                    callbacks: { label: ctx => ctx.parsed.y.toLocaleString('vi-VN') + ' VNĐ' }
                }
            },
            scales: {
                y: { beginAtZero: true, ticks: { callback: v => v.toLocaleString() + ' VNĐ', color: '#94a3b8', font: { size: 11 } }, grid: { color: 'rgba(0,0,0,.04)', drawBorder: false } },
                x: { ticks: { color: '#94a3b8', font: { size: 11, weight: 600 } }, grid: { display: false } }
            }
        }
    });
</script>
@endsection
