@extends('backend.layouts.app')
@section('title', 'Product Create')
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
                            <h5 class="mb-4">Create Products</h5>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('post')
                                <div class="row">
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="title" class="col-form-label">Product Name</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                value="{{ old('title') }}" placeholder="Product Name">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="short_des" class="col-form-label">Short Des(Optional)</label>
                                            <input type="text" class="form-control" id="short_des" name="short_des"
                                                value="{{ old('short_des') }}" placeholder="Product Short Description">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="original_price" class="col-form-label">Buy Price</label>
                                            <input type="text" class="form-control" id="original_price" name="original_price"
                                                value="{{ old('original_price') }}"placeholder="Product buy price">
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="price" class="col-form-label">Sale Price</label>
                                            <input type="text" class="form-control" id="price" name="price"
                                                value="{{ old('price') }}"placeholder="Product price">
                                        </div>
                                    </div>
                                    <div class="col-sm-1 mb-3">
                                        <div class="form-group">
                                            <label for="discount" class="col-form-label">Dis (%)</label>
                                            <input type="text" class="form-control" id="percent" name="discount"
                                                value="{{ old('discount') ?? 0 }}" placeholder="Product dicount">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 mb-3">
                                        <div class="form-group">
                                            <label for="discount_price" class="col-form-label">Discount Price</label>
                                            <input type="text" class="form-control" id="discount_price"
                                                name="discount_price" value="{{ old('discount_price') }}" placeholder="Discount Price" readonly>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="stock" class="col-form-label">Stock</label>
                                            <input type="number" class="form-control" id="stock" name="stock"
                                                value="{{ old('stock') }}" placeholder="Product Stock">
                                        </div>
                                    </div>                                   
                                    
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="category_id" class="col-form-label">Product Category</label>
                                            <select name="category_id"
                                                class="form-select form-control @error('category_id') is-invalid @enderror">
                                                <option value="" disabled
                                                    {{ old('category_id', $product->category_id ?? '') == '' ? 'selected' : '' }}>
                                                    Select Category
                                                </option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
                                                        {{ $category->categoryName }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>
                                    <div class="col-sm-3 mb-3">
                                        <div class="form-group">
                                            <label for="brand_id" class="col-form-label">Brand</label>
                                            <select name="brand_id" id="" class="form-control form-select">
                                                <option value=""disabled>Select Brand</option>
                                                @foreach ($brands as $brand)
                                                    <option value="{{ $brand->id }}">
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
                                                        oninput="document.getElementById('previewimage').src = window.URL.createObjectURL(this.files[0])">
                                                </div>
                                                <div class="col-6">
                                                    <img id="previewimage"
                                                        src="{{ asset('images/product_defuels.jpg') }}" alt=""
                                                        style="width: 115px; border: #00FFFF solid 1px; border-radius: 5px;">
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
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300
            });
        });
    </script>
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
