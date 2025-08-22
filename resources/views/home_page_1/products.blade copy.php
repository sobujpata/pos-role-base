@extends('layouts.app1')
@section('content')
    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Shop Left Sidebar</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active">Shop Left Sidebar</li>
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
                                <ul class="pagination mt-3 justify-content-center pagination_style1">
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#"><i
                                                class="linearicons-arrow-right"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 order-lg-first mt-4 pt-2 mt-lg-0 pt-lg-0">
                        <div class="sidebar">
                            <form id="filterForm">
    @csrf

    <!-- Categories -->
    <div class="widget">
        <h5 class="widget_title">Categories</h5>
        <ul class="widget_categories">
            @foreach($categories as $category)
            <li>
                <a href="javascript:void(0)" class="categoryFilter" data-id="{{ $category->id }}">
                    <span class="categories_name">{{ $category->categoryName }}</span>
                    <span class="categories_num">(9)</span>
                </a>
            </li>
            @endforeach
        </ul>
        <input type="hidden" name="category" id="categoryInput">
    </div>

    <!-- Price -->
    <div class="widget">
        <h5 class="widget_title">Filter</h5>
        <div class="filter_price">
            <div id="price_filter" data-min="0" data-max="{{ $maxPrice }}" data-min-value="50" data-max-value="{{ $maxPrice }}" data-price-sign="$"></div>
            <div class="price_range">
                <span>Price: <span id="flt_price"></span></span>
                <input type="hidden" name="min_price" id="price_first">
                <input type="hidden" name="max_price" id="price_second">
            </div>
        </div>
    </div>

    <!-- Brand -->
    {{-- <div class="widget">
        <h5 class="widget_title">Brand</h5>
        <ul class="list_brand">
            @foreach ($brands as $brand)
            <li>
                <div class="custome-checkbox">
                    <input class="form-check-input brandFilter" type="checkbox" value="{{ $brand->id }}">
                    <label class="form-check-label"><span>{{ $brand->brandName }}</span></label>
                </div>
            </li>
            @endforeach
        </ul>
        <input type="hidden" name="brands" id="brandsInput">
    </div>

    <!-- Size -->
    <div class="widget">
        <h5 class="widget_title">Size</h5>
        <div class="product_size_switch">
            @foreach(['xs','s','m','l','xl','2xl','3xl'] as $size)
                <span class="sizeFilter" data-size="{{ $size }}">{{ $size }}</span>
            @endforeach
        </div>
        <input type="hidden" name="size" id="sizeInput">
    </div>

    <!-- Color -->
    <div class="widget">
        <h5 class="widget_title">Color</h5>
        <div class="product_color_switch">
            @foreach(['#87554B','#333333','#DA323F','#2F366C','#B5B6BB','#B9C2DF','#5FB7D4','#2F366C'] as $color)
                <span class="colorFilter" data-color="{{ $color }}" style="background-color: {{ $color }}"></span>
            @endforeach
        </div>
        <input type="hidden" name="color" id="colorInput">
    </div> --}}
</form>

                            <div class="widget">
                                <div class="shop_banner">
                                    <div class="banner_img overlay_bg_20">
                                        <img src="{{asset('images/sidebar_banner_img.jpg')}}" alt="sidebar_banner_img">
                                    </div>
                                    <div class="shop_bn_content2 text_white">
                                        <h5 class="text-uppercase shop_subtitle">New Collection</h5>
                                        <h3 class="text-uppercase shop_title">Sale 30% Off</h3>
                                        <a href="#" class="btn btn-white rounded-0 btn-sm text-uppercase">Shop Now</a>
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.0/nouislider.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {

    let filterForm = document.getElementById('filterForm');
    let productList = document.getElementById('productList');

    function runFilter() {
        let formData = new FormData(filterForm);
        let params = new URLSearchParams(formData).toString();
console.log(params)
        axios.get('{{ route("products.filter") }}?' + params)
            .then(function(response) {
                
                productList.innerHTML = response.data;
            })
            .catch(function(error) {
                console.error(error);
            });
    }

    // Category
    document.querySelectorAll('.categoryFilter').forEach(el => {
        el.addEventListener('click', function() {
            let id = document.getElementById('categoryInput').value = this.dataset.id;
            console.log(id)
            runFilter();
        });
    });

    // // Price Slider
    let priceSlider = document.getElementById('price_filter');
    console.log(priceSlider)
    let minPrice = parseInt(priceSlider.dataset.min);
    let maxPrice = parseInt(priceSlider.dataset.max);
    let startMin = parseInt(priceSlider.dataset['minValue']);
    let startMax = parseInt(priceSlider.dataset['maxValue']);

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
    
    runFilter(); // triggers AJAX continuously while sliding
});


    priceSlider.noUiSlider.on('change', function(values) {
    runFilter(); // run AJAX request
});


});

</script>
@endpush
