@extends('backend.layouts.app')
@section('content')
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <!-- start-content -->

            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Tables</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="/dashboard"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Brand</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{ route('brand.index') }}" class="btn btn-primary">All Categories</a>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Update Brand</h5>
                            <form action="{{ route('brand.update', $brand->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row mb-3">
                                    <label for="brandName" class="col-sm-3 col-form-label">brand Name</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                            class="form-control @error('brandName') is-invalid @enderror"
                                            id="brandName" name="brandName" value="{{ $brand->brandName }}"
                                            placeholder="Enter your brand name">
                                        @error('brandName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                @if ($brand->brandImg)
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Current Image</label>
                                        <div class="col-sm-9">
                                            <img src="{{ asset('storage/' . $brand->brandImg) }}"
                                                alt="Current brand Image" width="120">
                                        </div>
                                    </div>
                                @endif
                                <div class="row mb-3">
                                    <label for="brandImg" class="col-sm-3 col-form-label">brand Image</label>
                                    <div class="col-sm-9">

                                        <input type="file"
                                            class="form-control @error('brandImg') is-invalid @enderror" id="brandImg"
                                            name="brandImg">
                                        @error('brandImg')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                    </div>

                                </div>
                                <div class="row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                            <button type="submit" class="btn btn-primary px-4">Update</button>
                                            <a href="{{ route('brand.index') }}" class="btn btn-light px-4">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- end-content -->
        </div>
    </div>
    <!--end page wrapper -->
@endsection
