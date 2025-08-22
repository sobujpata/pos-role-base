@extends('layouts.app1')
@section('title', 'Products view')
@section('content')
    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Products</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
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
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="row align-items-center mb-4 pb-1">
                            <div class="col-12">
                                <div class="product_header">
                                    <div class="product_header_left">
                                        <div class="custom_select">
                                            <select class="form-control form-control-sm">
                                                <option value="order">Default sorting</option>
                                                <option value="popularity">Sort by popularity</option>
                                                <option value="date">Sort by newness</option>
                                                <option value="price">Sort by price: low to high</option>
                                                <option value="price-desc">Sort by price: high to low</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="product_header_right">
                                        <div class="products_view">
                                            <a href="javascript:;" class="shorting_icon grid active"><i
                                                    class="ti-view-grid"></i></a>
                                            <a href="javascript:;" class="shorting_icon list"><i
                                                    class="ti-layout-list-thumb"></i></a>
                                        </div>
                                        <div class="custom_select">
                                            <select class="form-control form-control-sm">
                                                <option value="">Showing</option>
                                                <option value="9">9</option>
                                                <option value="12">12</option>
                                                <option value="18">18</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row shop_container" id="productList">
                            @include('home_page_1.partials.product-list')

                        </div>
                        <div class="row">
                            
                            <div class="col-12">
                                {{ $products->links() }}
                                {{-- <ul class="pagination mt-3 justify-content-center pagination_style1">
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#"><i
                                                class="linearicons-arrow-right"></i></a></li>
                                </ul> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
                        <div class="sidebar">
                            <form id="filterForm">
                                @csrf

                                <!-- CATEGORY -->
                                <div class="widget">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let filterForm = document.getElementById('filterForm');
            let productList = document.getElementById('productList');

            // RUN AJAX FILTER
            function runFilter() {
                let formData = new FormData(filterForm);
                let params = new URLSearchParams(formData).toString();
                console.log("Filter params:", params);

                axios.get('{{ route('products.filter') }}?' + params)
                    .then(function(response) {
                        productList.innerHTML = response.data;
                    })
                    .catch(function(error) {
                        console.error(error);
                    });
            }

            // --- CATEGORY ---
            document.querySelectorAll('.categoryFilter').forEach(el => {
                el.addEventListener('click', function() {
                    document.getElementById('categoryInput').value = this.dataset.id;

                    // Active styling
                    document.querySelectorAll('.categoryFilter').forEach(c => c.classList.remove(
                        'active'));
                    this.classList.add('active');

                    runFilter();
                });
            });

            // --- PRICE SLIDER ---
            let priceSlider = document.getElementById('price_filter');
            if (priceSlider) {
                let minPrice = parseInt(priceSlider.dataset.min);
                let maxPrice = parseInt(priceSlider.dataset.max);
                let startMin = parseInt(priceSlider.dataset.minValue);
                let startMax = parseInt(priceSlider.dataset.maxValue);

                noUiSlider.create(priceSlider, {
                    start: [startMin, startMax],
                    connect: true,
                    step: 10,
                    range: {
                        'min': minPrice,
                        'max': maxPrice
                    }
                });

                priceSlider.noUiSlider.on('update', function(values) {
                    document.getElementById('price_first').value = Math.round(values[0]);
                    document.getElementById('price_second').value = Math.round(values[1]);
                    document.getElementById('flt_price').textContent =
                        `$${Math.round(values[0])} - $${Math.round(values[1])}`;
                });

                priceSlider.noUiSlider.on('change', function() {
                    runFilter(); // Works individually or combined
                });
            }

            // --- BRAND ---
            document.querySelectorAll('.brandFilter').forEach(el => {
                el.addEventListener('change', function() {
                    runFilter(); // brand filter triggers AJAX automatically
                });
            });

            // --- SIZE ---
            document.querySelectorAll('.sizeFilter').forEach(el => {
                el.addEventListener('click', function() {
                    document.getElementById('sizeInput').value = this.dataset.size;

                    document.querySelectorAll('.sizeFilter').forEach(s => s.classList.remove(
                        'active'));
                    this.classList.add('active');

                    runFilter();
                });
            });

            // --- COLOR ---
            document.querySelectorAll('.colorFilter').forEach(el => {
                el.addEventListener('click', function() {
                    document.getElementById('colorInput').value = this.dataset.color;
                    console.log(this.dataset.color);
                    document.querySelectorAll('.colorFilter').forEach(c => c.classList.remove(
                        'active'));
                    this.classList.add('active');

                    runFilter();
                });
            });

        });
    </script>
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
                    <a href="#"><img src="${item.image}" alt="${item.name}">${item.name}</a>
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
