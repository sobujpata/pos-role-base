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
                            <li class="breadcrumb-item active" aria-current="page">Subscrib page setting</li>
                        </ol>
                    </nav>
                </div>
                {{-- @dd('fgdgd') --}}
                @can('color-create')
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{ route('subscribe-notice.create') }}" class="btn btn-primary">Create Page</a>
                    </div>
                </div>
                @endcan
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Pages List</h6>
            <hr>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5">
                            <table id="myTable" class="display table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>short_des</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @dd($pages) --}}
                                    @foreach ($pages as $key=>$item)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><img src="{{ asset('storage/'.$item->image) }}" style="width:70px; height: 80px;" alt=""></td>
                                        <td>{{ $item->title }}</td>
                                        <td>{{ $item->short_des }}</td>
                                        <td >
                                            <span class="d-flex gap-2">
                                            @can('edit')
                                                <a href="{{route('subscribe-notice.edit', $item->id)}}" class="btn btn-primary p-1"><i class='bx bx-pen'></i></a>
                                            @endcan
                                            @can('delete')
                                            <form action="{{ route('subscribe-notice.destroy', $item->id) }}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger p-1"><i class='bx bx-trash'></i></button>
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
