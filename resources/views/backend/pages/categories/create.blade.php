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
                        <a href="{{ route('categories.index') }}" class="btn btn-primary">All Product</a>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Create categories</h5>
                            <form action="{{ route('categories.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <div class="row mb-3">
                                    <label for="categoryName" class="col-sm-3 col-form-label">Category Name</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                            class="form-control @error('categoryName') is-invalid @enderror"
                                            id="categoryName" name="categoryName" value="{{ old('categoryName') }}"
                                            placeholder="Enter your category name">
                                        @error('categoryName')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
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
                                <div class="row mb-3">
                                    <label for="mainCategory" class="col-sm-3 col-form-label">Main Category</label>
                                    <div class="col-sm-9">
                                        <select class="form-select @error('mainCategory') is-invalid @enderror" id="mainCategory" name="mainCategory">
                                            <option value="">Select Main Category</option>
                                            @foreach ($mainCategories as $mainCat)
                                                <option value="{{ $mainCat->id }}" {{ old('mainCategory') == $mainCat->id ? 'selected' : '' }}>{{ $mainCat->categoryName }}</option>
                                            @endforeach
                                        </select>
                                        @error('mainCategory')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                            <button type="submit" class="btn btn-primary px-4">Save</button>
                                            <button type="reset" class="btn btn-light px-4">Reset</button>
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
@endsection
