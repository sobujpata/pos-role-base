@extends('backend.layouts.app')
@section('title', 'Products Pages')
@section('content')
    <div class="page-wrapper app-container">
        <div class="page-content">
            <!-- start-content -->

            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Tables</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Product Table</li>
                        </ol>
                    </nav>
                </div>
                @can('product-create')
                    <div class="ms-auto">
                        <div class="btn-group">
                            <a href="{{ route('products.create') }}" class="btn btn-primary">Create Product</a>
                        </div>
                    </div>
                @endcan
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Product List</h6>
            <hr>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5">
                            <table id="myTable" class="display table table-striped">
                                <thead>
                                    <tr class="table-dark text-center align-middle">
                                        <th class="text-center">Ser No</th>
                                        <th class="text-center">Image</th>
                                        <th class="text-center">Name & SKU</th>
                                        <th class="text-center">Original Price</th>
                                        <th class="text-center">Price</th>                                        
                                        <th class="text-center">Discount Price</th>                                        
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $key => $product)
                                        <tr>
                                            <td style="text-align: center; vertical-align: middle;">{{ $key + 1 }}</td>
                                            <td>
                                                <img src="{{asset('storage/'.$product->image)}}" alt="{{ $product->title }}" style="width: 80px;">
                                                
                                            </td>
                                            <td style="text-align: left; vertical-align: middle;">{{ $product->title }} <br><span style="color:red;"> {{$product->sku}}</span></td>
                                            <td style="text-align: center; vertical-align: middle;">{{ $product->original_price }}</td>
                                            <td style="text-align: center; vertical-align: middle;">{{ $product->price }}</td>                                            
                                            <td style="text-align: center; vertical-align: middle;">{{ $product->discount_price }}</td>
                                            <td style="text-align: center; vertical-align: middle;">{{ $product->stock }}</td>
                                            <td style="text-align: center; vertical-align: middle;">
                                                <span class="d-flex gap-2 align-middle">
                                                    @can('product-edit')
                                                        <a href="{{ route('products.edit', $product->id) }}"
                                                            class="btn btn-primary p-1"><i class='bx bx-pen'></i></a>
                                                    @endcan
                                                    @can('product-delete')
                                                        <form action="{{ route('products.destroy', $product->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-danger p-1"><i
                                                                    class="bx bx-trash "></i></button>
                                                        </form>
                                                    @endcan
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end-content -->
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