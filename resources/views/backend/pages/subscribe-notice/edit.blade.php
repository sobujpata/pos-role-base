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
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Data Table</li>
                        </ol>
                    </nav>
                </div>
                <div class="ms-auto">
                    <div class="btn-group">
                        <a href="{{ route('subscribe-notice.index') }}" class="btn btn-primary">All pages</a>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Update pages</h5>
                            <form action="{{ route('subscribe-notice.update', $page->id) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row mb-3">
                                    <label for="title" class="col-sm-3 col-form-label">page Name</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                            class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ $page->title }}"
                                            placeholder="Enter your title name">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <label for="short_des" class="col-sm-3 col-form-label mt-2">Short Des</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                            class="form-control mt-2 @error('short_des') is-invalid @enderror"
                                            id="short_des" name="short_des" value="{{ $page->short_des }}"
                                            placeholder="Enter your short des name">
                                        @error('short_des')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <label for="image" class="col-sm-3 col-form-label mt-2">Image</label>
                                    <div class="col-sm-9">
                                        <input type="file"
                                            class="form-control mt-2 @error('image') is-invalid @enderror"
                                            id="image" name="image" value="{{ $page->image }}"
                                            placeholder="Enter your short des name">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                </div>
                                
                                
                                
                                <div class="row">
                                    <label class="col-sm-3 col-form-label"></label>
                                    <div class="col-sm-9">
                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                            <button type="submit" class="btn btn-primary px-4">Update</button>
                                            <a href="{{ route('subscribe-notice.index') }}" class="btn btn-light px-4">Cancel</a>
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
