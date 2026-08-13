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
                            <form action="{{ route('products.update', $product->id) }}" method="post"
                                enctype="multipart/form-data">
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
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="short_des" class="col-form-label">Short Des (Optional)</label>
                                            <input type="text" class="form-control" id="short_des" name="short_des"
                                                value="{{ $product->short_des }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="original_price" class="col-form-label">Original Price</label>
                                            <input type="text" class="form-control" id="original_price" name="original_price"
                                                value="{{ $product->original_price }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="price" class="col-form-label">Sales Price</label>
                                            <input type="text" class="form-control" id="price" name="price"
                                                value="{{ $product->price }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-1 mb-3">
                                        <div class="form-group">
                                            <label for="discount" class="col-form-label">Dis (%)</label>
                                            <input type="text" class="form-control" id="percent" name="discount"
                                                value="{{ $product->discount }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mb-3">
                                        <div class="form-group">
                                            <label for="discount_price" class="col-form-label">Discount Price</label>
                                            <input type="text" class="form-control" id="discount_price"
                                                name="discount_price" value="{{ $product->discount_price }}" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="stock" class="col-form-label">Stock</label>
                                            <input type="text" class="form-control" id="stock" name="stock"
                                                value="{{ $product->stock }}">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb-3">
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
                                    <div class="col-sm-3 mb-3">
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
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="image" class="col-form-label">Image</label>
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="file" class="form-control" id="image"
                                                        name="image"
                                                        oninput="document.getElementById('previewImage').src = window.URL.createObjectURL(this.files[0])">
                                                </div>
                                                <div class="col-6">
                                                    <img id="previewImage"
                                                        src="{{ asset('storage/' . $product->image) ?? '' }}"
                                                        alt="{{ $product->title }}" style="width: 115px;">
                                                </div>
                                            </div>


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
        function calculateDiscount() {
            let price = parseFloat(document.getElementById("price").value) || 0;
            let percent = parseFloat(document.getElementById("percent").value) || 0;

            let discountAmount = price * (percent / 100);
            let finalPrice = price - discountAmount;

            document.getElementById("discount_price").value = finalPrice.toFixed(2);
        }

        document.getElementById("price").addEventListener("input", calculateDiscount);
        document.getElementById("percent").addEventListener("input", calculateDiscount);
    </script>    
@endsection
