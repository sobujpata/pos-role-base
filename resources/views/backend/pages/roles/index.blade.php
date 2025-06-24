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
                            <li class="breadcrumb-item active" aria-current="page">Roles Table</li>
                        </ol>
                    </nav>
                </div>
                @can('role-create')
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{ route('role.create') }}" class="btn btn-primary">Create Role</a>
                    </div>
                </div>
                @endcan
            </div>
            <!--end breadcrumb-->
            <h6 class="mb-0 text-uppercase">Role and Permissions</h6>
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
                                        <th>Permissions</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $key=>$role)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            @foreach($role->permissions as $permission)
                                            <span class="badge bg-danger">{{ $permission->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="d-flex gap-2">
                                            @can('role-edit')
                                            <a href="{{ route('role.edit', $role->id) }}" class="btn btn-primary btn-small">edit</a>
                                            @endcan
                                            @can('role-delete')
                                            <form action="{{ route('role.destroy', $role->id) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="btn btn-danger btn-small">delete</button>
                                            </form>
                                            @endcan
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
