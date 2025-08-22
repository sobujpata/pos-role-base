@extends('backend.layouts.app')
@section('title', 'Product Edit')
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
                        <a href="{{ route('products.index') }}" class="btn btn-primary">All Product</a>
                    </div>
                </div>
            </div>
            <!--end breadcrumb-->
            <div class="row">
                <div class="col-lg-12 mx-auto">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-4">Update Products</h5>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('products.update', $product->id) }}" method="post"  enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="title" class="col-form-label">Product Name</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                value="{{ $product->title }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <div class="form-group">
                                            <label for="short_des" class="col-form-label">Short Description</label>
                                            <input type="text" class="form-control" id="short_des" name="short_des"
                                                value="{{ $product->short_des }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mb-3">
                                        <div class="form-group">
                                            <label for="price" class="col-form-label">Price</label>
                                            <input type="text" class="form-control" id="price" name="price"
                                                value="{{ $product->price }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-1 mb-3">
                                        <div class="form-group">
                                            <label for="discount" class="col-form-label">Dis (%)</label>
                                            <input type="text" class="form-control" id="discount" name="discount"
                                                value="{{ $product->discount }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mb-3">
                                        <div class="form-group">
                                            <label for="discount_price" class="col-form-label">Discount Price</label>
                                            <input type="text" class="form-control" id="discount_price"
                                                name="discount_price" value="{{ $product->discount_price }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mb-3">
                                        <div class="form-group">
                                            <label for="stock" class="col-form-label">Stock</label>
                                            <input type="text" class="form-control" id="stock" name="stock"
                                                value="{{ $product->stock }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mb-3">
                                        <div class="form-group">
                                            <label for="star" class="col-form-label">Star</label>
                                            <input type="text" class="form-control" id="star" name="star"
                                                value="{{ $product->star }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mb-3">
                                        <div class="form-group">
                                            <label for="remark" class="col-form-label">Remarks</label>
                                            <input type="text" class="form-control" id="remark" name="remark"
                                                value="{{ $product->remark }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mb-3">
                                        <div class="form-group">
                                            <label for="category_id" class="col-form-label">Category</label>
                                            <select name="category_id" id="" class="form-select form-control">
                                                <option value="" disabled selected>Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        @if ($product->category_id == $category->id) selected @endif>
                                                        {{ $category->categoryName }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm-2 mb-3">
                                        <div class="form-group">
                                            <label for="brand_id" class="col-form-label">Brand</label>
                                            <select name="brand_id" id="" class="form-control form-select">
                                                <option value=""disabled>Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}"
                                                        @if ($product->brand_id == $brand->id) selected @endif>
                                                        {{ $brand->brandName }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mb-3">
                                        <div class="form-group">
                                            <label for="color" class="col-form-label">Colors</label>
                                            <input type="text" class="form-control" id="color" name="color"
                                                value="{{ $product->productDetail->color ?? null }}{{ old('color') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-1 mb-3">
                                        <div class="form-group">
                                            <label for="size" class="col-form-label">Sizes</label>
                                            <input type="text" class="form-control" id="size" name="size"
                                                value="{{ $product->productDetail->size ?? null }}{{ old('size') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-1 mb-3">
                                        <div class="form-group">
                                            <label for="capacity" class="col-form-label">Capacity</label>
                                            <input type="text" class="form-control" id="capacity" name="capacity"
                                                value="{{ $product->capacity ?? null }}{{ old('capacity') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mb-3">
                                        <div class="form-group">
                                            <label for="sku" class="col-form-label">SKU</label>
                                            <input type="text" class="form-control" id="sku" name="sku"
                                                value="{{ $product->sku ?? null }}{{ old('sku') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mb-3">
                                        <div class="form-group">
                                            <label for="tags" class="col-form-label">Tags</label>
                                            <input type="text" class="form-control" id="tags" name="tags"
                                                value="{{ $product->tags ?? null }}{{ old('tags') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mb-3">
                                        <div class="form-group">
                                            <label for="water_resistance" class="col-form-label">Water Resistance</label>
                                            <input type="text" class="form-control" id="water_resistance"
                                                name="water_resistance"
                                                value="{{ $product->water_resistance ?? null }}{{ old('water_resistance') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mb-3">
                                        <div class="form-group">
                                            <label for="material" class="col-form-label">Material</label>
                                            <input type="text" class="form-control" id="material" name="material"
                                                value="{{ $product->material ?? null }}{{ old('material') }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="img1" class="col-form-label">Image 1</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="file" class="form-control" id="img1"
                                                        name="img1"
                                                        oninput="document.getElementById('previewImg1').src = window.URL.createObjectURL(this.files[0])">
                                                </div>
                                                <div class="col-6">
                                                    <img id="previewImg1"
                                                        src="{{ asset($product->productDetail->img1) ?? '' }}"
                                                        alt="{{ $product->title }}" style="width: 115px;">
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="img2" class="col-form-label">Image 2</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="file" class="form-control" id="img2"
                                                        name="img2"
                                                        oninput="document.getElementById('previewImg2').src = window.URL.createObjectURL(this.files[0])">
                                                </div>
                                                <div class="col-6">
                                                    <img id="previewImg2"
                                                        src="{{ asset($product->productDetail->img2) ?? '' }}"
                                                        alt="{{ $product->title }}" style="width: 115px;">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="img3" class="col-form-label">Image 3</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="file" class="form-control" id="img3"
                                                        name="img3"
                                                        oninput="document.getElementById('previewImg3').src = window.URL.createObjectURL(this.files[0])">
                                                </div>
                                                <div class="col-6">
                                                    <img id="previewImg3"
                                                        src="{{ asset($product->productDetail->img3) ?? '' }}"
                                                        alt="{{ $product->title }}" style="width: 115px;">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="img4" class="col-form-label">Image 4</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="file" class="form-control" id="img4"
                                                        name="img4"
                                                        oninput="document.getElementById('previewImg4').src = window.URL.createObjectURL(this.files[0])">
                                                </div>
                                                <div class="col-6">
                                                    <img id="previewImg4"
                                                        src="{{ asset($product->productDetail->img4) ?? '' }}"
                                                        alt="{{ $product->title }}" style="width: 115px;">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-sm-12 mb-3">
                                        <div class="form-group">
                                            <label for="des" class="col-form-label">Product Description</label>
                                            <textarea name="des" id="summernote" rows="4" class="form-control">{{ $product->productDetail->des ?? null }}</textarea>

                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-3" style="margin:0 auto;">
                                        <div class="d-md-flex d-grid align-items-center gap-3">
                                            <button type="submit" class="btn btn-primary px-4">Save Change</button>
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
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300
            });
        });
    </script>
@endsection
