@extends('backend.layouts.app')
@section('title', 'Barcode Generate Pages')
@section('content')
<style>
    input, select {
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
                    <table class="table table-bordered" id="tableData">
                        <thead class="bg-light">
                            <tr>
                                <th>Image</th>
                                <th>Name & SKU</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th width="80">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products ?? [] as $product)
                                <tr>
                                    <td>
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" width="70" alt="{{ $product->title }}">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $product->title }} <br>
                                        <small class="text-muted">{{ $product->sku ?? 'N/A' }}</small>
                                    </td>
                                    <td>{{ number_format($product->discount_price, 2) }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td class="text-center">
                                        {{-- <button class="btn btn-sm btn-outline-success"
                                            onclick="openBarcode({{ $product->id }})">
                                            <i class="fa fa-barcode"></i>
                                        </button> --}}
                                        <!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $product->id }}">
  <i class="fa fa-barcode"></i>
</button>
@include('backend.pages.barcode.barcode-generate')

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No products found</td>
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

