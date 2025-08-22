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
                            <li class="breadcrumb-item active" aria-current="page">Data Table</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="user-index.html" class="btn btn-primary">All Users</a>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Create Products</h5>
                            <form action="{{ isset($menu) ? route('menus.update', $menu) : route('menus.store') }}"
                                method="POST">
                                @csrf
                                @if (isset($menu))
                                    @method('PUT')
                                @endif

                                <div class="mb-3">
                                    <label>Title</label>
                                    <input name="title" class="form-control"
                                        value="{{ old('title', $menu->title ?? '') }}">
                                </div>

                                <div class="mb-3">
                                    <label>URL</label>
                                    <input name="url" class="form-control" value="{{ old('url', $menu->url ?? '') }}">
                                </div>

                                <div class="mb-3">
                                    <label>Parent</label>
                                    <select name="parent_id" class="form-control">
                                        <option value="">-- None --</option>
                                        @foreach ($parents as $parent)
                                            <option value="{{ $parent->id }}"
                                                {{ old('parent_id', $menu->parent_id ?? '') == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Order</label>
                                    <input name="order" type="number" class="form-control"
                                        value="{{ old('order', $menu->order ?? 0) }}">
                                </div>

                                <button class="btn btn-primary">Save</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <!-- end-content -->
        </div>
    </div>
@endsection
