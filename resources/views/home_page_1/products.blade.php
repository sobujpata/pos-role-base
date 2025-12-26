@extends('layouts.app1')
@section('title', 'Products view')
@section('content')
    <style>
        .categoryFilter.active {
            font-weight: bold;
            color: #ff0000;
            /* বা আপনার চাইতে থাকা color */
        }
    </style>
    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section bg_gray page-title-mini" style="padding: 40px 0;">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1><span id="categoryName">All</span> Products</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Products</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START MAIN CONTENT -->
    <div class="main_content">
        {{-- @dd($products) --}}
        <!-- START SECTION SHOP -->
        <div class="section" style="padding: 50px 0;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row align-items-center mb-4 pb-1">
                            <div class="col-12">
                                <div class="product_header">
                                    <div class="product_header_left">
                                        <!-- Sorting -->
                                        <div class="custom_select">
                                            <select class="form-control form-control-sm" id="sortSelect">
                                                <option value="order">Default sorting</option>
                                                <option value="popular">Sort by popularity</option>
                                                <option value="date">Sort by newness</option>
                                                <option value="price">Sort by price: low to high</option>
                                                <option value="price-desc">Sort by price: high to low</option>
                                            </select>
                                        </div>

                                        <!-- Hidden input for sorting -->
                                        <input type="hidden" id="sortInput" value="order">

                                    </div>
                                    <div class="product_header_right">
                                        <div class="products_view">
                                            <a href="javascript:;" class="shorting_icon grid active"><i
                                                    class="ti-view-grid"></i></a>
                                            <a href="javascript:;" class="shorting_icon list"><i
                                                    class="ti-layout-list-thumb"></i></a>
                                        </div>
                                        <!-- Showing Per Page -->
                                        <div class="custom_select">
                                            <select class="form-control form-control-sm" id="perPageSelect">
                                                <option value="9">9</option>
                                                <option value="12">12</option>
                                                <option value="18">18</option>
                                            </select>
                                        </div>

                                        <!-- Hidden input for perPage -->
                                        <input type="hidden" id="perPageInput" value="9">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <span id="productList">
                            <div class="row shop_container">
                                @include('home_page_1.partials.product-list')
                            </div>
                        </span>
                    </div>
                    <div class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
                        <div class="sidebar">
                            <form id="filterForm">
                                @csrf

                                <!-- CATEGORY -->
                                <div class="widget">
                                    <h4 class="widget_title">Filters</h4>
                                    <h5 class="widget_title">Categories</h5>
                                    <ul class="widget_categories">
                                        @foreach ($categories as $category)
                                            <li>
                                                <a href="javascript:void(0)" class="categoryFilter"
                                                    data-id="{{ $category->id }}">
                                                    <span class="categories_name">{{ $category->categoryName }}</span>
                                                    <span class="categories_num">(9)</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <input type="hidden" name="category" id="categoryInput" value="">
                                </div>

                                <!-- PRICE -->
                                <div class="widget">
                                    <h5 class="widget_title">Price</h5>
                                    <div class="filter_price">
                                        <div id="price_filter" data-min="0" data-max="{{ $maxPrice }}"
                                            data-min-value="0" data-max-value="{{ $maxPrice }}" data-price-sign="$">
                                        </div>
                                        <div class="price_range">
                                            <span>Price: <span id="flt_price"></span></span>
                                            <input type="hidden" name="min_price" id="price_first" value="0">
                                            <input type="hidden" name="max_price" id="price_second"
                                                value="{{ $maxPrice }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- BRAND -->
                                <div class="widget">
                                    <h5 class="widget_title">Brand</h5>
                                    <ul class="list_brand">
                                        @foreach ($brands as $brand)
                                            <li>
                                                <div class="custome-checkbox">
                                                    <input type="checkbox" name="brand[]" class="brandFilter"
                                                        value="{{ $brand->id }}" id="brand{{ $brand->id }}">
                                                    <label
                                                        for="brand{{ $brand->id }}"><span>{{ $brand->brandName }}</span></label>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <!-- SIZE -->
                                <div class="widget">
                                    <h5 class="widget_title">Size</h5>
                                    <div class="product_size_switch">
                                        @foreach (['xs', 's', 'm', 'l', 'xl', '2xl', '3xl'] as $size)
                                            <span class="sizeFilter"
                                                data-size="{{ $size }}">{{ $size }}</span>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="size" id="sizeInput" value="">
                                </div>

                                <!-- COLOR -->
                                <div class="widget">
                                    <h5 class="widget_title">Color</h5>
                                    <div class="product_color_switch">
                                        @foreach (['#87554B', '#333333', '#DA323F', '#2F366C', '#B5B6BB', '#B9C2DF', '#5FB7D4', '#2F366C'] as $color)
                                            <span class="colorFilter" data-color="{{ $color }}"
                                                style="background-color: {{ $color }};"></span>
                                        @endforeach
                                    </div>
                                    <input type="hidden" name="color" id="colorInput" value="">
                                </div>
                            </form>


                            <div class="widget">
                                <div class="shop_banner">
                                    <div class="banner_img overlay_bg_20">
                                        <img src="{{ asset('images/sidebar_banner_img.jpg') }}" alt="sidebar_banner_img">
                                    </div>
                                    <div class="shop_bn_content2 text_white">
                                        <h5 class="text-uppercase shop_subtitle">New Collection</h5>
                                        <h3 class="text-uppercase shop_title">Sale 30% Off</h3>
                                        <a href="#" class="btn btn-white rounded-0 btn-sm text-uppercase">Shop
                                            Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SECTION SHOP -->

    </div>
@endsection
@push('scripts')
    <script>
    
        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            // console.log(urlParams); // পুরো URL parameter object
            const categoryId = urlParams.get("categoryId"); // navbar থেকে আসা category id
            // console.log(categoryId); // categoryId দেখাবে

            if (categoryId) {
                // Hidden input এ set
                $('#categoryInput').val(categoryId);

                // Category heading update
                let selectedCategory = document.querySelector(`.categoryFilter[data-id='${categoryId}']`);
                if(selectedCategory) {
                    let categoryName = selectedCategory.querySelector('.categories_name').textContent;
                    $('#categoryName').text(categoryName);
                    selectedCategory.classList.add('active');
                }
            }

            // প্রথমবার load এ products fetch করো
            fetchProducts(1);

            // --- Category Filter ---
            $('.categoryFilter').on('click', function() {
                // Remove active from all categories
                $('.categoryFilter').removeClass('active');

                // Get Category Name and set to heading
                let categoryName = $(this).find('.categories_name').text();
                $('#categoryName').text(categoryName);

                // Add active class
                $(this).addClass('active');

                // Set hidden input
                var catId = $(this).data('id');
                $('#categoryInput').val(catId);

                // Trigger AJAX
                fetchProducts(1);
            });

            // --- Initialize jQuery UI Slider ---
            var $slider = $('#price_filter');
            var minVal = parseInt($slider.data('min-value'));
            var maxVal = parseInt($slider.data('max-value'));
            var minRange = parseInt($slider.data('min'));
            var maxRange = parseInt($slider.data('max'));
            var currency = $slider.data('price-sign');

            $slider.slider({
                range: true,
                min: minRange,
                max: maxRange,
                values: [minVal, maxVal],
                slide: function(event, ui) {
                    $("#flt_price").html(currency + ui.values[0] + " - " + currency + ui.values[1]);
                    $("#price_first").val(ui.values[0]);
                    $("#price_second").val(ui.values[1]);
                },
                change: function(event, ui) {
                    fetchProducts(1);
                }
            });

            // Initial Price Show
            $("#flt_price").html(currency + $slider.slider("values", 0) + " - " + currency + $slider.slider(
                "values", 1));
            $("#price_first").val($slider.slider("values", 0));
            $("#price_second").val($slider.slider("values", 1));

            // --- Brand Filter ---
            $(document).on('change', '.brandFilter', function() {
                fetchProducts(1);
            });

            // --- Size Filter ---
            $('.sizeFilter').on('click', function() {
                $('.sizeFilter').removeClass('active');
                $(this).addClass('active');
                $('#sizeInput').val($(this).data('size'));
                fetchProducts(1);
            });

            // --- Color Filter ---
            $('.colorFilter').on('click', function() {
                $('.colorFilter').removeClass('active');
                $(this).addClass('active');
                $('#colorInput').val($(this).data('color'));
                fetchProducts(1);
            });

            // --- Pagination click ---
            $(document).on('click', '.pagination a', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                fetchProducts(page);
            });

            // --- Per Page Filter ---
            $('#perPageSelect').on('change', function() {
                var perPage = $(this).val();
                $('#perPageInput').val(perPage);
                fetchProducts(1); // আবার প্রথম পেজ থেকে ডেটা দেখাবে
            });

            // --- Sorting Change Event ---
            $('#sortSelect').on('change', function() {
                var sortBy = $(this).val();
                $('#sortInput').val(sortBy);
                fetchProducts(1); // আবার প্রথম পেজ থেকে ডেটা লোড হবে
            });

            // --- AJAX Filter Function Update ---
            function fetchProducts(page = 1) {
                var data = {
                    _token: '{{ csrf_token() }}',
                    category: $('#categoryInput').val(),
                    brands: $('.brandFilter:checked').map(function() {
                        return $(this).val();
                    }).get().join(','),
                    size: $('#sizeInput').val(),
                    color: $('#colorInput').val(),
                    min_price: $('#price_first').val(),
                    max_price: $('#price_second').val(),
                    perPage: $('#perPageInput').val(),
                    sort: $('#sortInput').val(), // 🔥 নতুন sorting parameter
                    page: page
                };

                $.ajax({
                    url: '{{ route('products.filter') }}',
                    method: 'GET',
                    data: data,
                    beforeSend: function() {
                        $("#productList").html('<p>Loading...</p>');
                    },
                    success: function(res) {
                        $("#productList").html(res);
                    },
                    error: function(err) {
                        console.error(err);
                    }
                });
            }

        });
    </script>
@endpush
@push('scripts')
    <script>
        // Use delegation to bind event after DOM is ready
        $(document).on('click', '.addToCartBtnAll', function(e) {
            e.preventDefault();

            let formData = new FormData();
            formData.append('id', $(this).data('id'));
            formData.append('name', $(this).data('name'));
            formData.append('price', $(this).data('price'));
            formData.append('image', $(this).data('image'));
            axios.post("/cart/add", formData)
                .then(res => {
                    if (res.data.success) {
                        // alert('Product added to cart!');
                    }
                    updateCartCount();
                }).catch(err => {
                    console.error(err);
                    alert('Error adding to cart');
                });
        });
    </script>
    <script>
        function updateCartCount() {
            axios.get('/cart/count').then(res => {
                document.getElementById('cart-count').textContent = res.data.count;
                // console.log(res.data.cart);

                res.data.cart.forEach(item => {
                    let cartItem = `<li>
                    <a href="/cart/remove/${item.id}" class="item_remove"><i class="ion-close"></i></a>
                    <a href="#"><img src="storage/${item.image}" alt="${item.name}">${item.name}</a>
                    <span class="cart_quantity">${item.quantity}  x
                    <span class="cart_amount"> <span class="price_symbole">Tk ${item.price}</span></span></span>
                    </li>
                    `;
                    $("#cartProductList").append(cartItem);
                });
                //subtotal 
                document.getElementById('subtotalHeader').textContent = res.data.subtotal;


            });


        }
    </script>
@endpush
