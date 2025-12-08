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
                            <li class="breadcrumb-item active" aria-current="page">Main Category</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{ route('MainCategories.index') }}" class="btn btn-primary">All Categories</a>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Update Main Categories</h5>
                            <form action="{{ route('MainCategories.update', $category->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row mb-3">
                                    <label for="categoryName" class="col-sm-3 col-form-label">Category Name</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                            class="form-control @error('categoryName') is-invalid @enderror"
                                            id="categoryName" name="categoryName" value="{{ $category->categoryName }}"
                                            placeholder="Enter your category name">
                                        @error('categoryName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                @if ($category->categoryImg)
                                    <div class="row mb-3">
                                        <label class="col-sm-3 col-form-label">Current Image</label>
                                        <div class="col-sm-9">
                                            <img src="{{ asset('storage/' . $category->categoryImg) }}"
                                                alt="Current Category Image" width="120">
                                        </div>
                                    </div>
                                @endif
                                <div class="row mb-3">
                                    <label for="categoryImg" class="col-sm-3 col-form-label">Category Image</label>
                                    <div class="col-sm-9">

                                        <input type="file"
                                            class="form-control @error('categoryImg') is-invalid @enderror" id="categoryImg"
                                            name="categoryImg">
                                        @error('categoryImg')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror

                                    </div>

                                </div>
                                <div class="row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                            <button type="submit" class="btn btn-primary px-4">Update</button>
                                            <a href="{{ route('MainCategories.index') }}" class="btn btn-light px-4">Cancel</a>
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
