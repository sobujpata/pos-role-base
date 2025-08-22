@extends('layouts.app1')
@section('content')
    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Product Detail</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active">Product Detail</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START MAIN CONTENT -->
    <div class="main_content">

        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-md-6 mb-4 mb-md-0">
                        <div class="product-image">
                            {{-- <div class="product_img_box">
                                <img id="product_img" src="{{ asset($product->productDetail->img1 ?? '') }}"
                                    data-zoom-image="{{ asset($product->productDetail->zoom_img1 ?? '') }}"
                                    alt="{{ $product->title }}" />
                                <a href="#" class="product_img_zoom" title="Zoom">
                                    <span class="linearicons-zoom-in"></span>
                                </a>
                            </div>
                            <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4"
                                data-slides-to-scroll="1" data-infinite="false">

                                @php
                                    $galleryImages = [
                                        [
                                            'thumb' => $product->productDetail->img1 ?? null,
                                            'zoom' => $product->productDetail->zoom_img1 ?? null,
                                        ],
                                        [
                                            'thumb' => $product->productDetail->img2 ?? null,
                                            'zoom' => $product->productDetail->zoom_img2 ?? null,
                                        ],
                                        [
                                            'thumb' => $product->productDetail->img3 ?? null,
                                            'zoom' => $product->productDetail->zoom_img3 ?? null,
                                        ],
                                        [
                                            'thumb' => $product->productDetail->img4 ?? null,
                                            'zoom' => $product->productDetail->zoom_img4 ?? null,
                                        ],
                                    ];
                                @endphp

                                @foreach (array_filter($galleryImages, fn($img) => $img['thumb'] && $img['zoom']) as $index => $img)
                                    <div class="item">
                                        <a href="#" class="product_gallery_item {{ $index === 0 ? 'active' : '' }}"
                                            data-image="{{ asset($img['thumb']) }}"
                                            data-zoom-image="{{ asset($img['zoom']) }}">
                                            <img src="{{ asset($img['thumb']) }}"
                                                alt="product_small_img{{ $index + 1 }}" />
                                        </a>
                                    </div>
                                @endforeach
                            </div> --}}
                            <div class="product_img_box">
                                <img id="product_img" src='{{ asset($product->productDetail->img1) }}'
                                    data-zoom-image="{{asset($product->productDetail->zoom_img1)}}" alt="product_img1" />
                                <a href="#" class="product_img_zoom" title="Zoom">
                                    <span class="linearicons-zoom-in"></span>
                                </a>
                            </div>
                            <div id="pr_item_gallery" class="product_gallery_item slick_slider" data-slides-to-show="4"
                                data-slides-to-scroll="1" data-infinite="false">
                                <div class="item">
                                    <a href="#" class="product_gallery_item active"
                                        data-image="{{ asset($product->productDetail->img1) }}"
                                        data-zoom-image="{{ asset($product->productDetail->zoom_img1) }}">
                                        <img src="{{ asset($product->productDetail->img1) }}" alt="product_small_img1" />
                                    </a>
                                </div>
                                <div class="item">
                                    <a href="#" class="product_gallery_item"
                                        data-image="{{ asset($product->productDetail->img2) }}"
                                        data-zoom-image="{{asset($product->productDetail->zoom_img2)}}">
                                        <img src="{{ asset($product->productDetail->img2) }}" alt="product_small_img2" />
                                    </a>
                                </div>
                                <div class="item">
                                    <a href="#" class="product_gallery_item"
                                        data-image="{{asset($product->productDetail->img3)}}"
                                        data-zoom-image="{{ asset($product->productDetail->zoom_img3) }}">
                                        <img src="{{ asset($product->productDetail->img3) }}" alt="product_small_img3" />
                                    </a>
                                </div>
                                <div class="item">
                                    <a href="#" class="product_gallery_item"
                                        data-image="{{ asset($product->productDetail->img4) }}"
                                        data-zoom-image="{{ asset($product->productDetail->zoom_img4) }}">
                                        <img src="{{ asset($product->productDetail->img4) }}" alt="product_small_img4" />
                                    </a>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="pr_detail">
                            <div class="product_description">
                                <h4 class="product_title"><a href="#">{{ $product->title }}</a></h4>
                                <div class="product_price">
                                    <span class="price">{{ $product->discount_price }}</span>
                                    <del>{{ $product->price }}</del>
                                    <div class="on_sale">
                                        <span>{{ $product->discount }}</span>
                                    </div>
                                </div>
                                <div class="rating_wrap">
                                    <div class="rating">
                                        <div class="product_rate" style="width:80%"></div>
                                    </div>
                                    <span class="rating_num">({{ $product->star }})</span>
                                </div>
                                <div class="pr_desc">
                                    <p>{{ $product->short_des }}</p>
                                </div>
                                <div class="product_sort_info">
                                    <ul>
                                        <li><i class="linearicons-shield-check"></i> 1 Year AL Jazeera Brand Warranty
                                        </li>
                                        <li><i class="linearicons-sync"></i> 30 Day Return Policy</li>
                                        <li><i class="linearicons-bag-dollar"></i> Cash on Delivery available</li>
                                    </ul>
                                </div>
                                <div class="pr_switch_wrap">
                                    <span class="switch_lable">Color</span>
                                    <div class="product_color_switch">

                                        @if ($product->productDetail?->color)
                                            @php
                                                $colors = explode(',', $product->productDetail->color); // Split string into array
                                            @endphp
                                            @foreach ($colors as $index => $color)
                                                @php
                                                    // Optional: map color name to hex
                                                    $colorHexMap = [
                                                        'Red' => '#DA323F',
                                                        'Green' => '#008000',
                                                        'White' => '#FFFFFF',
                                                    ];
                                                    $hex = $colorHexMap[$color] ?? '#333333';
                                                @endphp

                                                <span @if ($index == 0) class="active" @endif
                                                    data-color="{{ $hex }}" title="{{ $color }}"
                                                    style="background-color: {{ $hex }}; display:inline-block; width:20px; height:20px; border-radius:50%; cursor:pointer;">
                                                </span>
                                            @endforeach
                                        @endif




                                    </div>
                                </div>
                                <div class="pr_switch_wrap">
                                    <span class="switch_lable">Size</span>
                                    <div class="product_size_switch">
                                        @if ($product->productDetail?->size)
                                            @php
                                                $sizes = explode(',', $product->productDetail->size);
                                            @endphp
                                            @foreach ($sizes as $size)
                                                <span>{{ $size }}</span>
                                            @endforeach
                                        @endif



                                    </div>
                                </div>
                            </div>
                            <hr />
                            <div class="cart_extra">
                                <div class="cart-product-quantity">
                                    <div class="quantity">
                                        <input type="button" value="-" class="minusQty">
                                        <input type="text" name="quantity" value="1" title="Qty" class="qty"
                                            size="4">
                                        <input type="button" value="+" class="plusQty">
                                    </div>
                                </div>
                                <div class="cart_btn">
                                    <button class="btn btn-fill-out btn-addtocart" type="button"><i
                                            class="icon-basket-loaded"></i> Add to cart</button>
                                    <a class="add_compare" href="#"><i class="icon-shuffle"></i></a>
                                    <a class="add_wishlist" href="#"><i class="icon-heart"></i></a>
                                </div>
                            </div>
                            <hr />
                            <ul class="product-meta">
                                <li>SKU: <a href="#">{{ $product->sku }}</a></li>
                                <li>Category: <a href="#">{{ $product->category->categoryName }}</a></li>
                                <li>Tags: <a href="#" rel="tag">{{ $product->tags }}</a></li>
                            </ul>

                            <div class="product_share">
                                <span>Share:</span>
                                <ul class="social_icons">
                                    @php
                                        $url = urlencode(url('/details/' . $product->title . '-' . $product->id));
                                        $title = urlencode($product->title);
                                    @endphp
                                    <li><a target="_blank"
                                            href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}"><i
                                                class="ion-social-facebook"></i></a></li>
                                    <li><a target="_blank"
                                            href="https://twitter.com/intent/tweet?url={{ $url }}&text={{ $title }}"><i
                                                class="ion-social-twitter"></i></a></li>
                                    <li><a target="_blank"
                                            href="https://api.whatsapp.com/send?text={{ $title }}%20{{ $url }}"><i
                                                class="ion-social-whatsapp"></i></a></li>
                                    <li><a target="_blank" href="#"><i class="ion-social-youtube-outline"></i></a>
                                    </li>
                                    <li><a target="_blank" href="#"><i
                                                class="ion-social-instagram-outline"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="large_divider clearfix"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="tab-style3">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="Description-tab" data-bs-toggle="tab"
                                        href="#Description" role="tab" aria-controls="Description"
                                        aria-selected="true">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab"
                                        href="#Additional-info" role="tab" aria-controls="Additional-info"
                                        aria-selected="false">Additional info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews"
                                        role="tab" aria-controls="Reviews" aria-selected="false">Reviews
                                        ({{ $rating_count }})</a>
                                </li>
                            </ul>
                            <div class="tab-content shop_info_tab">
                                <div class="tab-pane fade show active" id="Description" role="tabpanel"
                                    aria-labelledby="Description-tab">
                                    {!! $product->productDetail->des ?? '' !!}
                                </div>
                                <div class="tab-pane fade" id="Additional-info" role="tabpanel"
                                    aria-labelledby="Additional-info-tab">
                                    <table class="table table-bordered">
                                        <tr>
                                            <td>Capacity</td>
                                            <td>{{ $product->capacity }}</td>
                                        </tr>
                                        <tr>
                                            <td>Color</td>
                                            <td>{{ $product->productDetail->color ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Water Resistant</td>
                                            <td>{{ $product->water_resistance ?? '' }}</td>
                                        </tr>
                                        <tr>
                                            <td>Material</td>
                                            <td>{{ $product->material }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="Reviews" role="tabpanel" aria-labelledby="Reviews-tab">
                                    <div class="comments">
                                        <h5 class="product_tab_title">{{ $rating_count }} Review For <span>Blue Dress For
                                                Woman</span>
                                        </h5>
                                        <ul class="list_none comment_list mt-4">

                                            @if ($product_reviews)
                                                @foreach ($product_reviews as $review)
                                                    <li>
                                                        <div class="comment_img">
                                                            <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($review->customer_email))) }}"
                                                                alt="user1" />
                                                        </div>
                                                        <div class="comment_block">
                                                            <div class="rating_wrap">
                                                                <div class="rating">
                                                                    <div class="product_rate"
                                                                        style="width:{{ $review->rating }}%"></div>
                                                                </div>
                                                            </div>
                                                            <p class="customer_meta">
                                                                <span
                                                                    class="review_author">{{ $review->customer_name }}</span>
                                                                <span
                                                                    class="comment-date">{{ $review->created_at->diffForHumans() }}</span>
                                                            </p>
                                                            <div class="description">
                                                                <p>{{ $review->description }}</p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                                <div class="mt-3">
                                                    {{ $product_reviews->links() }}
                                                </div>
                                            @endif


                                        </ul>
                                    </div>
                                    <div class="review_form field_form">
                                        <h5>Add a review</h5>
                                        <form class="row mt-3" action="{{ route('reviews.store') }}" method="POST">
                                            @csrf
                                            <div class="form-group col-12 mb-3">
                                                @if ($errors->any())
                                                    <div class="alert alert-danger">
                                                        <ul class="mb-0">
                                                            @foreach ($errors->all() as $error)
                                                                <li>{{ $error }}</li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                                <div class="star_rating">
                                                    <span data-value="1"><i class="far fa-star"></i></span>
                                                    <span data-value="2"><i class="far fa-star"></i></span>
                                                    <span data-value="3"><i class="far fa-star"></i></span>
                                                    <span data-value="4"><i class="far fa-star"></i></span>
                                                    <span data-value="5"><i class="far fa-star"></i></span>
                                                </div>

                                                <input type="hidden" name="rating" id="rating-value" required>
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            </div>

                                            <div class="form-group col-12 mb-3">
                                                <textarea required placeholder="Your review *" class="form-control" name="message" rows="4"></textarea>
                                            </div>
                                            <div class="form-group col-md-6 mb-3">
                                                <input required placeholder="Enter Name *" class="form-control"
                                                    name="name" type="text">
                                            </div>
                                            <div class="form-group col-md-6 mb-3">
                                                <input required placeholder="Enter Email *" class="form-control"
                                                    name="email" type="email">
                                            </div>

                                            <div class="form-group col-12 mb-3">
                                                <button type="submit" class="btn btn-fill-out">Submit Review</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="small_divider"></div>
                        <div class="divider"></div>
                        <div class="medium_divider"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="heading_s1">
                            <h3>Releted Products</h3>
                        </div>
                        <div class="releted_product_slider carousel_slider owl-carousel owl-theme" data-margin="20"
                            data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                            <div class="item">
                                <div class="product">
                                    <div class="product_img">
                                        <a href="shop-product-detail.html">
                                            <img src="{{ asset('/images/product_img1.jpg') }}" alt="product_img1">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="#"><i
                                                            class="icon-basket-loaded"></i>
                                                        Add To Cart</a></li>
                                                <li><a href="shop-compare.html"><i class="icon-shuffle"></i></a></li>
                                                <li><a href="shop-quick-view.html" class="popup-ajax"><i
                                                            class="icon-magnifier-add"></i></a></li>
                                                <li><a href="#"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.html">Blue Dress For
                                                Woman</a></h6>
                                        <div class="product_price">
                                            <span class="price">$45.00</span>
                                            <del>$55.25</del>
                                            <div class="on_sale">
                                                <span>35% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus
                                                blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                        <div class="pr_switch_wrap">
                                            <div class="product_color_switch">
                                                <span class="active" data-color="#87554B"></span>
                                                <span data-color="#333333"></span>
                                                <span data-color="#DA323F"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product">
                                    <div class="product_img">
                                        <a href="shop-product-detail.html">
                                            <img src="{{ asset('/images/product_img2.jpg') }}" alt="product_img2">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="#"><i
                                                            class="icon-basket-loaded"></i>
                                                        Add To Cart</a></li>
                                                <li><a href="shop-compare.html"><i class="icon-shuffle"></i></a></li>
                                                <li><a href="shop-quick-view.html" class="popup-ajax"><i
                                                            class="icon-magnifier-add"></i></a></li>
                                                <li><a href="#"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.html">Lether Gray
                                                Tuxedo</a></h6>
                                        <div class="product_price">
                                            <span class="price">$55.00</span>
                                            <del>$95.00</del>
                                            <div class="on_sale">
                                                <span>25% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:68%"></div>
                                            </div>
                                            <span class="rating_num">(15)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus
                                                blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                        <div class="pr_switch_wrap">
                                            <div class="product_color_switch">
                                                <span class="active" data-color="#847764"></span>
                                                <span data-color="#0393B5"></span>
                                                <span data-color="#DA323F"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product">
                                    <span class="pr_flash">New</span>
                                    <div class="product_img">
                                        <a href="shop-product-detail.html">
                                            <img src="{{ asset('/images/product_img3.jpg') }}" alt="product_img3">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="#"><i
                                                            class="icon-basket-loaded"></i>
                                                        Add To Cart</a></li>
                                                <li><a href="shop-compare.html"><i class="icon-shuffle"></i></a></li>
                                                <li><a href="shop-quick-view.html" class="popup-ajax"><i
                                                            class="icon-magnifier-add"></i></a></li>
                                                <li><a href="#"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.html">woman full sliv
                                                dress</a></h6>
                                        <div class="product_price">
                                            <span class="price">$68.00</span>
                                            <del>$99.00</del>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:87%"></div>
                                            </div>
                                            <span class="rating_num">(25)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus
                                                blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                        <div class="pr_switch_wrap">
                                            <div class="product_color_switch">
                                                <span class="active" data-color="#333333"></span>
                                                <span data-color="#7C502F"></span>
                                                <span data-color="#2F366C"></span>
                                                <span data-color="#874A3D"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product">
                                    <div class="product_img">
                                        <a href="shop-product-detail.html">
                                            <img src="{{ asset('/images/product_img4.jpg') }}" alt="product_img4">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="#"><i
                                                            class="icon-basket-loaded"></i>
                                                        Add To Cart</a></li>
                                                <li><a href="shop-compare.html"><i class="icon-shuffle"></i></a></li>
                                                <li><a href="shop-quick-view.html" class="popup-ajax"><i
                                                            class="icon-magnifier-add"></i></a></li>
                                                <li><a href="#"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.html">light blue
                                                Shirt</a></h6>
                                        <div class="product_price">
                                            <span class="price">$69.00</span>
                                            <del>$89.00</del>
                                            <div class="on_sale">
                                                <span>20% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:70%"></div>
                                            </div>
                                            <span class="rating_num">(22)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus
                                                blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                        <div class="pr_switch_wrap">
                                            <div class="product_color_switch">
                                                <span class="active" data-color="#333333"></span>
                                                <span data-color="#A92534"></span>
                                                <span data-color="#B9C2DF"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="product">
                                    <div class="product_img">
                                        <a href="shop-product-detail.html">
                                            <img src="{{ asset('/images/product_img5.jpg') }}" alt="product_img5">
                                        </a>
                                        <div class="product_action_box">
                                            <ul class="list_none pr_action_btn">
                                                <li class="add-to-cart"><a href="#"><i
                                                            class="icon-basket-loaded"></i>
                                                        Add To Cart</a></li>
                                                <li><a href="shop-compare.html"><i class="icon-shuffle"></i></a></li>
                                                <li><a href="shop-quick-view.html" class="popup-ajax"><i
                                                            class="icon-magnifier-add"></i></a></li>
                                                <li><a href="#"><i class="icon-heart"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product_info">
                                        <h6 class="product_title"><a href="shop-product-detail.html">blue dress for
                                                woman</a></h6>
                                        <div class="product_price">
                                            <span class="price">$45.00</span>
                                            <del>$55.25</del>
                                            <div class="on_sale">
                                                <span>35% Off</span>
                                            </div>
                                        </div>
                                        <div class="rating_wrap">
                                            <div class="rating">
                                                <div class="product_rate" style="width:80%"></div>
                                            </div>
                                            <span class="rating_num">(21)</span>
                                        </div>
                                        <div class="pr_desc">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus
                                                blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                        </div>
                                        <div class="pr_switch_wrap">
                                            <div class="product_color_switch">
                                                <span class="active" data-color="#87554B"></span>
                                                <span data-color="#333333"></span>
                                                <span data-color="#5FB7D4"></span>
                                            </div>
                                        </div>
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
    <!-- END MAIN CONTENT -->
    <script>
        document.querySelectorAll('.star_rating span').forEach(star => {
            star.addEventListener('click', function() {
                let value = this.getAttribute('data-value');
                document.getElementById('rating-value').value = value;

                // Optional: highlight stars
                document.querySelectorAll('.star_rating span i').forEach((icon, index) => {
                    icon.classList.toggle('fas', index < value);
                    icon.classList.toggle('far', index >= value);
                });
            });
        });
    </script>

   
    {{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        const mainImage = document.getElementById("product_img");
        const galleryLinks = document.querySelectorAll(".product_gallery_item");

        function initZoom() {
            if (typeof $.fn.elevateZoom !== "undefined") {
                $(".zoomContainer").remove(); // clear previous zoom instance
                $(mainImage).elevateZoom({
                    zoomType: "lens",
                    lensShape: "round",
                    lensSize: 200,
                    responsive: true,
                    cursor: "crosshair"
                });
            }
        }

        // Initialize zoom on page load (for default image)
        initZoom();

        galleryLinks.forEach(link => {
            link.addEventListener("click", function(e) {
                e.preventDefault();

                // Remove active class from all thumbnails
                galleryLinks.forEach(l => l.classList.remove("active"));

                // Add active class to clicked thumbnail
                this.classList.add("active");

                // Update main image + zoom image
                let newImage = this.getAttribute("data-image");
                let zoomImage = this.getAttribute("data-zoom-image");

                mainImage.src = newImage;
                mainImage.setAttribute("data-zoom-image", zoomImage);

                // Reinit zoom with new image
                initZoom();
            });
        });
    });
</script> --}}


@endsection
