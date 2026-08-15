@extends('backend.layouts.app')
@section('content')
    <div class="page-wrapper">
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
                            <li class="breadcrumb-item active" aria-current="page">Brand Table</li>
                        </ol>
                    </nav>
                </div>
                @can('brand-create')
                    <div class="ms-auto">
                        <div class="btn-group">
                            <a href="{{ route('brand.create') }}" class="btn btn-primary">Create Brand</a>
                        </div>
                    </div>
                @endcan
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Brand List</h6>
            <hr>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5">
                            <table id="myTable" class="display table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @dd($brands) --}}
                                    @foreach ($brands as $key => $brand)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $brand->brandName }}</td>
                                            <td><img src="{{ 'storage/' . $brand->brandImg }}"
                                                    alt="{{ $brand->brandName }}" width="40"> </td>
                                            <td>
                                                <span class="d-flex gap-2">
                                                    @can('brand-edit')
                                                        <a href="{{ route('brand.edit', $brand->id) }}"
                                                            class="btn btn-primary p-1"><i class='bx bx-pen'></i></a>
                                                    @endcan
                                                    @can('brand-delete')
                                                        <form action="{{ route('brand.destroy', $brand->id) }}"
                                                            method="post" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-danger p-1"><i
                                                                    class='bx bx-trash'></i></button>
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