@extends('backend.layouts.app')
@section('title', 'Barcode Generate Pages')
@section('content')
    <style>
        input,
        select {
            border: 2px solid #a9fac4 !important;
        }
    </style>
    <div class="page-wrapper app-container">
        <div class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Tables</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Product Barcode Generate Table</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!--end breadcrumb-->

            <h6 class="mb-0 text-uppercase">Product Barcode List</h6>
            <hr>

            <div class="card">
                <div class="card-body">
                    <h6 class="mb-3 text-uppercase">Product Barcode List</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="myTable">
                            <thead class="bg-light">
                                <tr>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Name & SKU</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Discount</th>
                                    <th class="text-center">Discount Price</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center" width="80">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products ?? [] as $product)
                                    <tr>
                                        <td>
                                            @if ($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}" width="70"
                                                    alt="{{ $product->title }}">
                                            @else
                                                <span class="text-muted">No image</span>
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            {{ $product->title }} <br>
                                            <small class="text-muted">{{ $product->sku ?? 'N/A' }}</small>
                                        </td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            {{ number_format($product->price, 2) }}</td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            {{ $product->discount}}%</td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            {{ number_format($product->discount_price, 2) }}</td>
                                        <td style="vertical-align: middle; text-align: center;">{{ $product->stock }}</td>
                                        <td class="text-center" style="vertical-align: middle; text-align: center;">


                                            <a href="{{ route('barcode.print', $product->id) }}" target="_blank"
                                                class="btn btn-sm btn-warning" title="Print POS Label">
                                                <i class="fa fa-print"></i>
                                            </a>                                            

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No products found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    
@endsection
@push('script')
    <script>
        let table = new DataTable('#myTable', {
            "pageLength": 10,
            "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
        });
    </script>
@endpush