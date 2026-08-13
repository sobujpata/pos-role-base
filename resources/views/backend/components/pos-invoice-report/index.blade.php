<div class="page-wrapper">
    <div class="page-content">
        <!-- start-content -->
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Report Page</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">POS Invoice Reports</li>
                    </ol>
                </nav>
            </div>
            {{-- <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ url('/point-of-sales') }}" class="float-end btn m-0 bg-primary text-white">Create Sale</a>
                </div>
            </div> --}}
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="card px-md-2 py-4">
                    <div class="row justify-content-between ">
                        {{-- // session message --}}
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="align-items-center col">
                            <form action="{{ route('invoiceReports') }}" method="POST"
                                class="d-flex align-items-center">
                                @csrf
                                <div class="form-group me-3">
                                    <label for="from-date">From Date</label>
                                    <input type="date" name="from-date" class="form-control" placeholder=""
                                        value="{{ request('from-date') }}">
                                </div>
                                <div class="form-group me-3">
                                    <label for="to-date">To Date</label>
                                    <input type="date" name="to-date" class="form-control" placeholder=""
                                        value="{{ request('to-date') }}">
                                </div>
                                <button type="submit" class="btn btn-primary mt-4">Filter</button>
                            </form>


                        </div>
                        <div class="align-items-center col">
                            
                        </div>
                    </div>
                    <hr class="bg-dark " />
                    <div class="float-right">
                        <button onclick="PrintPage()" class="btn bg-success">Print</button>
                    </div>
                    <div class="card-body" id="print">
                        <div class="row justify-content-between">
                            <div class="col-md-6 col-sm-12 col-lg-6">
                                <h5 class="card-title">POS Invoice Reports</h5>
                            </div>
                            <div class="col-md-6 col-sm-12 col-lg-6">
                                <div class="d-flex justify-content-end">
                                    <div class="me-3">
                                        <strong>Total Invoices:</strong> {{ $totalInv }}
                                    </div>
                                    <div class="me-3">
                                        <strong>Total Amount:</strong> {{ number_format($totalAmount, 2) }}
                                    </div>
                                    <div class="me-3">
                                        <strong>Total Paid:</strong> {{ number_format($totalPaidAmount, 2) }}
                                    </div>
                                    <div class="me-3">
                                        <strong>Total Earned:</strong> {{ number_format($totalProfit, 2) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="bg-dark " />
                        <div class="table-responsive">
                            @if ($responseData !== null)

                                <table id="invoiceReportTable" class="table table-striped table-bordered"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="vertical-align: middle; text-align: center;">Invoice No</th>
                                            <th style="vertical-align: middle; text-align: center;">Total Amount</th>
                                            <th style="vertical-align: middle; text-align: center;">Paid Amount</th>
                                            <th style="vertical-align: middle; text-align: center;">Earned Amount</th>
                                            <th style="vertical-align: middle; text-align: center;">Created By</th>
                                            <th style="vertical-align: middle; text-align: center;">Created At</th>
                                        </tr>
                                    </thead>
                                    {{-- @dd($responseData) --}}
                                    <tbody>
                                        @forelse ($responseData as $data)
                                            <tr>
                                                <td style="vertical-align: middle; text-align: center;">
                                                    {{ $data['invoice']->id }}</td>

                                                <td style="vertical-align: middle; text-align: center;">
                                                    {{ number_format($data['invoice']->total, 2) }}
                                                </td>

                                                <td style="vertical-align: middle; text-align: center;">
                                                    {{ number_format($data['invoice']->payable, 2) }}
                                                </td>
                                                <td style="vertical-align: middle; text-align: center;">
                                                    {{ number_format($data['invoice']->payable - $data['totalBuyPrice'], 2) }}
                                                </td>
                                                <td style="vertical-align: middle; text-align: center;">
                                                    {{ $data['invoice']->user->name ?? 'N/A' }}
                                                </td>

                                                <td style="vertical-align: middle; text-align: center;">
                                                    {{ $data['invoice']->created_at->format('d-m-Y h:i A') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center">
                                                    No invoices found.
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Total Inv: {{ $totalInv }}</td>
                                            <td>Total Amount: {{ $totalAmount }}</td>
                                            <td>Total Paid: {{ $totalPaidAmount }}</td>
                                            <td>Total Earn: {{ $totalProfit }}</td>
                                            <td colspan="2"></td>

                                        </tr>
                                    </tfoot>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- end-content -->
        </div>
    </div>
       
<script>
    function PrintPage() {
        var printContents = document.getElementById('print').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>