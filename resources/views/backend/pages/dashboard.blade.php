@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <!-- start-content -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                <div class="col">
                    <div class="card radius-10 border-start border-4 border-info">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Orders By POS</p>
                                    <h4 class="my-1 text-info">{{ $totalPosInvoice }}</h4>
                                    @if ($percentChange >= 0)
                                        <p class="mb-0 font-13 text-success">+{{ number_format($percentChange, 2) }}% from last week</p>
                                    @else
                                        <p class="mb-0 font-13 text-danger">{{ number_format($percentChange, 2) }}% from last week</p>
                                    @endif
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-blues text-white ms-auto"><i
                                        class='bx bxs-cart'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-4 border-danger">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Total Income By POS</p>
                                    <h4 class="my-1 text-danger">{{ number_format($totalPosSales,2) }}</h4>
                                    @if ($percentChangeSales >= 0)
                                        <p class="mb-0 font-13 text-success">+{{ number_format($percentChangeSales, 2) }}% from last week</p>
                                    @else
                                        <p class="mb-0 font-13 text-danger">{{ number_format($percentChangeSales, 2) }}% from last week</p>
                                    @endif
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-burning text-white ms-auto">
                                    <i class='bx bxs-wallet'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-4 border-success">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Today Order By POS</p>
                                    <h4 class="my-1 text-success">{{$totalPosInvoiceToday}}</h4>
                                    @if ($yesterdayTotalPercentChange >= 0)
                                        <p class="mb-0 font-13 text-success">+{{ number_format($yesterdayTotalPercentChange,2) }}% from yesterday</p>
                                    @else
                                        <p class="mb-0 font-13 text-danger">{{ number_format($yesterdayTotalPercentChange,2) }}% from yesterday</p>
                                    @endif
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                    <i class='bx bxs-bar-chart-alt-2'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card radius-10 border-start border-4 border-warning">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <p class="mb-0 text-secondary">Today Income By POS</p>
                                    <h4 class="my-1 text-warning">{{ number_format($totalPosSalesToday,2) }}</h4>
                                    @if ($yesterdayPercentChange >= 0)
                                        <p class="mb-0 font-13 text-success">+{{ number_format($yesterdayPercentChange,2) }}% from yesterday</p>
                                    @else
                                        <p class="mb-0 font-13 text-danger">{{ number_format($yesterdayPercentChange,2) }}% from yesterday</p>
                                    @endif
                                </div>
                                <div class="widgets-icons-2 rounded-circle bg-gradient-orange text-white ms-auto">
                                    <i class='bx bxs-group'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection
