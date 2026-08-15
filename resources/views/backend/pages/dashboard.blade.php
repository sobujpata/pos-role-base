@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!-- start-content -->
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card radius-10 border-start border-4 border-info">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Total Invoices</p>
                                            <h4 class="my-1 text-info">{{ $totalPosInvoice }}</h4>
                                            @if ($percentChange >= 0)
                                                <p class="mb-0 font-13 text-success">
                                                    +{{ number_format($percentChange, 2) }}% from last week</p>
                                            @else
                                                <p class="mb-0 font-13 text-danger">{{ number_format($percentChange, 2) }}%
                                                    from last week</p>
                                            @endif
                                        </div>
                                        <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i
                                                class='bx bxs-cart'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card radius-10 border-start border-4 border-danger">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Total Sales</p>
                                            <h4 class="my-1 text-danger">{{ number_format($totalPosSales, 2) }}</h4>
                                            @if ($percentChangeSales >= 0)
                                                <p class="mb-0 font-13 text-success">
                                                    +{{ number_format($percentChangeSales, 2) }}% from last week</p>
                                            @else
                                                <p class="mb-0 font-13 text-danger">
                                                    {{ number_format($percentChangeSales, 2) }}% from last week</p>
                                            @endif
                                        </div>
                                        <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto">
                                            <i class='bx bxs-wallet'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card radius-10 border-start border-4 border-success">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Today Invices</p>
                                            <h4 class="my-1 text-success">{{ $totalPosInvoiceToday }}</h4>
                                            @if ($yesterdayTotalPercentChange >= 0)
                                                <p class="mb-0 font-13 text-success">
                                                    +{{ number_format($yesterdayTotalPercentChange, 2) }}% from yesterday
                                                </p>
                                            @else
                                                <p class="mb-0 font-13 text-danger">
                                                    {{ number_format($yesterdayTotalPercentChange, 2) }}% from yesterday</p>
                                            @endif
                                        </div>
                                        <div
                                            class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                            <i class='bx bxs-bar-chart-alt-2'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card radius-10 border-start border-4 border-warning">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="mb-0 text-secondary">Today Sales</p>
                                            <h4 class="my-1 text-warning">{{ number_format($totalPosSalesToday, 2) }}</h4>
                                            @if ($yesterdayPercentChange >= 0)
                                                <p class="mb-0 font-13 text-success">
                                                    +{{ number_format($yesterdayPercentChange, 2) }}% from yesterday</p>
                                            @else
                                                <p class="mb-0 font-13 text-danger">
                                                    {{ number_format($yesterdayPercentChange, 2) }}% from yesterday</p>
                                            @endif
                                        </div>
                                        <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto">
                                            <i class='bx bxs-group'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h2>Daily Sales</h2>
                                    <div class="sales-chart-wrap">
                                        <canvas id="salesChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h2>Recent Sales</h2>
                            <table class="table table-striped" id="tableData">
                                <thead>
                                    <tr>
                                        <th>Inv No</th>
                                        <th style="text-align: left;">Total Payable</th>
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody id="tableList"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('backend.components.pos-invoice.invoice-details')
@endsection
@push('script')
    <script src="{{ asset('js/chart.js') }}" type="javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
    <style>
        .sales-chart-wrap {
            position: relative;
            width: 100%;
            height: 300px;
            max-height: 300px;
            overflow: hidden;
        }

        .sales-chart-wrap canvas {
            display: block;
            width: 100% !important;
            height: 100% !important;
            max-height: 300px;
        }
    </style>
    <script>
        getList();

        async function getList() {
            try {
                let res = await axios.get('/invoice-select-dashboard');
                let tableList = $('#tableList');
                let tableData = $('#tableData');

                if ($.fn.DataTable.isDataTable('#tableData')) {
                    tableData.DataTable().destroy();
                }

                tableList.empty();

                res.data.data.forEach(function(item) {
                    let row = `
                        <tr>
                            <td class="text-center">${item['invoice'].id}</td>
                            <td style="text-align: left;">${item['invoice'].payable}</td>
                            <td>
                                <button data-id="${item['invoice'].id}" data-user_id="${item['invoice'].user_id}" class="viewBtn btn btn-outline-info text-sm px-3 py-1 btn-sm m-0">
                                    <i class="fa text-sm fa-eye"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tableList.append(row);
                });
            } catch (error) {
                console.error(error);
                alert('An error occurred while fetching data. Please try again later.');
            }

            $('.viewBtn').on('click', async function() {
                let inv_id = $(this).data('id');
                let user_id = $(this).data('user_id');
                await InvoiceDetails(inv_id, user_id);
            });

            new DataTable('#tableData', {
                order: [[0, 'desc']],
                lengthMenu: [10, 20, 30, 50, 100, 500]
            });
        }

        let salesChart = null;

        async function getDashboardData() {
            try {
                if (typeof Chart === 'undefined') {
                    console.error('Chart.js is not loaded.');
                    return;
                }

                if (window.ChartDataLabels) {
                    Chart.register(ChartDataLabels);
                }

                const res = await axios.get('/dashboard-data');
                const salesData = Array.isArray(res.data?.dailySalesData) ? res.data.dailySalesData : [];
                const chartCanvas = document.getElementById('salesChart');

                if (!chartCanvas) return;

                const fixedHeight = 300;
                const chartWrap = chartCanvas.closest('.sales-chart-wrap');

                if (chartWrap) {
                    chartWrap.style.height = fixedHeight + 'px';
                    chartWrap.style.maxHeight = fixedHeight + 'px';
                }

                chartCanvas.height = fixedHeight;
                chartCanvas.style.height = fixedHeight + 'px';
                chartCanvas.style.maxHeight = fixedHeight + 'px';

                if (!salesData.length) {
                    return;
                }

                const labels = salesData.map(item => item.day || '');
                const values = salesData.map(item => Number(item.total_sales || 0));
                const colors = [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40', '#8BC34A', '#E91E63',
                    '#00BCD4', '#9C27B0', '#795548', '#607D8B', '#F44336', '#2196F3', '#FFC107', '#009688',
                    '#673AB7', '#FF5722', '#4CAF50', '#3F51B5', '#CDDC39', '#FF9800', '#03A9F4', '#9E9E9E',
                    '#8E44AD', '#16A085', '#D35400', '#2ECC71', '#3498DB', '#E74C3C', '#1ABC9C'
                ];
                const barColors = values.map((_, index) => colors[index % colors.length]);

                if (salesChart) {
                    salesChart.destroy();
                }

                salesChart = new Chart(chartCanvas.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Daily Sales',
                            data: values,
                            backgroundColor: barColors,
                            borderColor: barColors,
                            borderWidth: 1,
                            borderRadius: 5,
                            barPercentage: 0.7,
                            categoryPercentage: 0.8,
                            datalabels: {
                                anchor: 'end',
                                align: 'top',
                                offset: 4,
                                formatter: (value) => '৳ ' + Number(value).toLocaleString(),
                                color: '#333',
                                font: {
                                    weight: 'bold',
                                    size: 10
                                }
                            }
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: false,
                        layout: {
                            padding: { top: 10, right: 10, bottom: 0, left: 0 }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { autoSkip: true, maxTicksLimit: 10 }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return '৳ ' + Number(value).toLocaleString();
                                    }
                                }
                            }
                        },
                        plugins: {
                            legend: { display: true },
                            tooltip: {
                                callbacks: {
                                    title: function(context) {
                                        return 'Date: ' + salesData[context[0].dataIndex]?.date;
                                    },
                                    label: function(context) {
                                        return 'Sales: ৳ ' + Number(context.raw).toLocaleString();
                                    }
                                }
                            },
                            datalabels: {
                                display: true
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Dashboard data error:', error);
            }
        }

        getDashboardData();
    </script>
@endpush
