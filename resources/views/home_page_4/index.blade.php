@extends('layouts.app3')
@section('content')
@include('home_page_4.slider')
@include('home_page_4.popup')

<!-- END MAIN CONTENT -->
<div class="main_content">

<!-- START SECTION CATEGORIES -->
<div class="section pt-0 small_pb">
	<div class="container">
    	<div class="row">
        	<div class="col-12">
            	<div class="cat_overlap radius_all_5">
                	<div class="row align-items-center">
        				<div class="col-lg-3 col-md-4">
                        	<div class="text-center text-md-start">
                                <h4>Top Categories</h4>
                                <p class="mb-2">There are many variations of passages of Lorem</p>
                                <a href="#" class="btn btn-line-fill btn-sm">View All</a>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8">
                            <div class="cat_slider mt-4 mt-md-0 carousel_slider owl-carousel owl-theme nav_style5" data-loop="true" data-dots="false" data-nav="true" data-margin="30" data-responsive='{"0":{"items": "1"}, "380":{"items": "2"}, "991":{"items": "3"}, "1199":{"items": "4"}}'>
                                <div class="item">
                                    <div class="categories_box">
                                        <a href="#">
                                            <i class="flaticon-bed"></i>
                                            <span>Bedroom</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="categories_box">
                                        <a href="#">
                                            <i class="flaticon-table"></i>
                                            <span>Dining Table</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="categories_box">
                                        <a href="#">
                                            <i class="flaticon-sofa"></i>
                                            <span>Sofa</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="categories_box">
                                        <a href="#">
                                            <i class="flaticon-armchair"></i>
                                            <span>Armchair</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="categories_box">
                                        <a href="#">
                                            <i class="flaticon-chair"></i>
                                            <span>chair</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="categories_box">
                                        <a href="#">
                                            <i class="flaticon-desk-lamp"></i>
                                            <span>desk lamp</span>
                                        </a>
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
<!-- END SECTION CATEGORIES -->

<!-- START SECTION SHOP -->
<div class="section small_pt pb_70">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
                <div class="heading_s4 text-center">
                    <h2>Our Top Products</h2>
                </div>
                <p class="text-center leads">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim Nullam nunc varius.</p>
            </div>
		</div>
        <div class="row shop_container">
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product_box text-center">
                    <div class="product_img">
                        <a href="shop-product-detail.html">
                            <img src="{{asset('images/furniture_img1.jpg')}}" alt="furniture_img1">
                        </a>
                        <div class="product_action_box">
                            <ul class="list_none pr_action_btn">
                                <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                <li><a href="#"><i class="icon-heart"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product_info">
                        <h6 class="product_title"><a href="shop-product-detail.html">enim expedita sed</a></h6>
                        <div class="product_price">
                            <span class="price">$45.00</span>
                            <del>$55.25</del>
                        </div>
                        <div class="rating_wrap">
                            <div class="rating">
                                <div class="product_rate" style="width:80%"></div>
                            </div>
                            <span class="rating_num">(21)</span>
                        </div>
                        <div class="pr_desc">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                        </div>
                        <div class="add-to-cart">
                            <a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To Cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product_box text-center">
                    <div class="product_img">
                        <a href="shop-product-detail.html">
                            <img src="{{asset('images/furniture_img2.jpg')}}" alt="furniture_img2">
                        </a>
                        <div class="product_action_box">
                            <ul class="list_none pr_action_btn">
                                <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                <li><a href="#"><i class="icon-heart"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product_info">
                        <h6 class="product_title"><a href="shop-product-detail.html">adipisci officia libero</a></h6>
                        <div class="product_price">
                            <span class="price">$55.00</span>
                            <del>$95.00</del>
                        </div>
                        <div class="rating_wrap">
                            <div class="rating">
                                <div class="product_rate" style="width:68%"></div>
                            </div>
                            <span class="rating_num">(15)</span>
                        </div>
                        <div class="pr_desc">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                        </div>
                        <div class="add-to-cart">
                            <a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To Cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product_box text-center">
                    <div class="product_img">
                        <a href="shop-product-detail.html">
                            <img src="{{asset('images/furniture_img3.jpg')}}" alt="furniture_img3">
                        </a>
                        <div class="product_action_box">
                            <ul class="list_none pr_action_btn">
                                <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                <li><a href="#"><i class="icon-heart"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product_info">
                        <h6 class="product_title"><a href="shop-product-detail.html">Internet tend to repeat</a></h6>
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
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                        </div>
                        <div class="add-to-cart">
                            <a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To Cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product_box text-center">
                    <div class="product_img">
                        <a href="shop-product-detail.html">
                            <img src="{{asset('images/furniture_img4.jpg')}}" alt="furniture_img4">
                        </a>
                        <div class="product_action_box">
                            <ul class="list_none pr_action_btn">
                                <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                <li><a href="#"><i class="icon-heart"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product_info">
                        <h6 class="product_title"><a href="shop-product-detail.html">Many desktop publishing</a></h6>
                        <div class="product_price">
                            <span class="price">$69.00</span>
                            <del>$89.00</del>
                        </div>
                        <div class="rating_wrap">
                            <div class="rating">
                                <div class="product_rate" style="width:70%"></div>
                            </div>
                            <span class="rating_num">(22)</span>
                        </div>
                        <div class="pr_desc">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                        </div>
                        <div class="add-to-cart">
                            <a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To Cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product_box text-center">
                    <div class="product_img">
                        <a href="shop-product-detail.html">
                            <img src="{{asset('images/furniture_img5.jpg')}}" alt="furniture_img5">
                        </a>
                        <div class="product_action_box">
                            <ul class="list_none pr_action_btn">
                                <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                <li><a href="#"><i class="icon-heart"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product_info">
                        <h6 class="product_title"><a href="shop-product-detail.html">injected humour repetition</a></h6>
                        <div class="product_price">
                            <span class="price">$45.00</span>
                            <del>$55.25</del>
                        </div>
                        <div class="rating_wrap">
                            <div class="rating">
                                <div class="product_rate" style="width:80%"></div>
                            </div>
                            <span class="rating_num">(21)</span>
                        </div>
                        <div class="pr_desc">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                        </div>
                        <div class="add-to-cart">
                            <a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To Cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product_box text-center">
                    <div class="product_img">
                        <a href="shop-product-detail.html">
                            <img src="{{asset('images/furniture_img6.jpg')}}" alt="furniture_img6">
                        </a>
                        <div class="product_action_box">
                            <ul class="list_none pr_action_btn">
                                <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                <li><a href="#"><i class="icon-heart"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product_info">
                        <h6 class="product_title"><a href="shop-product-detail.html">randomised humour words</a></h6>
                        <div class="product_price">
                            <span class="price">$55.00</span>
                            <del>$95.00</del>
                        </div>
                        <div class="rating_wrap">
                            <div class="rating">
                                <div class="product_rate" style="width:68%"></div>
                            </div>
                            <span class="rating_num">(15)</span>
                        </div>
                        <div class="pr_desc">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                        </div>
                        <div class="add-to-cart">
                            <a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To Cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product_box text-center">
                    <div class="product_img">
                        <a href="shop-product-detail.html">
                            <img src="{{asset('images/furniture_img7.jpg')}}" alt="furniture_img7">
                        </a>
                        <div class="product_action_box">
                            <ul class="list_none pr_action_btn">
                                <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                <li><a href="#"><i class="icon-heart"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product_info">
                        <h6 class="product_title"><a href="shop-product-detail.html">expedita distinctio rerum</a></h6>
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
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                        </div>
                        <div class="add-to-cart">
                            <a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To Cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-6">
                <div class="product_box text-center">
                    <div class="product_img">
                        <a href="shop-product-detail.html">
                            <img src="{{asset('images/furniture_img8.jpg')}}" alt="furniture_img8">
                        </a>
                        <div class="product_action_box">
                            <ul class="list_none pr_action_btn">
                                <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                <li><a href="#"><i class="icon-heart"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product_info">
                        <h6 class="product_title"><a href="shop-product-detail.html">Itaque earum rerum</a></h6>
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
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                        </div>
                        <div class="add-to-cart">
                            <a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
<!-- END SECTION SHOP -->

<!-- START SECTION BANNER --> 
<div class="section background_bg" data-img-src="{{asset('images/furniture_banner3.jpg')}}">
	<div class="container">
    	<div class="row">
            <div class="col-lg-6 col-md-8 col-sm-9">
            	<div class="furniture_banner">
                    <h3 class="single_bn_title">Big Sale Deal</h3>
                    <h4 class="single_bn_title1 text_default">Sale 40% Off</h4>
                    <div class="countdown_time countdown_style3 mb-4" data-time="2021/09/02 12:30:15"></div>
                    <a href="#" class="btn btn-fill-out">Shop Now</a>
                    <div class="newsletter_form2 mt-5">
                        <form method="post">
                            <div class="form-group mb-3">
                                <input name="email" required="" type="email" class="form-control" placeholder="Enter Your Email">
                                <button class="btn btn-fill-out text-uppercase" title="Subscribe" type="submit">Subscribe</button>
                            </div>
                            <div class="form-group">
                                <small> To receive latest offers and discounts from the shop. </small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<!-- END SECTION BANNER -->

<!-- START SECTION SHOP -->
<div class="section pb_20">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">
                <div class="heading_s4 text-center">
                    <h2>Special Offers</h2>
                </div>
                <p class="text-center leads">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim Nullam nunc varius.</p>
            </div>
		</div>
        <div class="row">
        	<div class="col-md-12">
            	<div class="product_slider carousel_slider owl-carousel owl-theme nav_style5" data-loop="true" data-dots="false" data-nav="true" data-margin="30" data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>
                    <div class="item">
                        <div class="product_box text-center">
                            <div class="product_img">
                                <a href="shop-product-detail.html">
                                    <img src="{{asset('images/furniture_img1.jpg')}}" alt="furniture_img1">
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                        <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a href="shop-product-detail.html">enim expedita sed</a></h6>
                                <div class="product_price">
                                    <span class="price">$45.00</span>
                                    <del>$55.25</del>
                                </div>
                                <div class="rating_wrap">
                                    <div class="rating">
                                        <div class="product_rate" style="width:80%"></div>
                                    </div>
                                    <span class="rating_num">(21)</span>
                                </div>
                                <div class="pr_desc">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                </div>
                                <div class="add-to-cart">
                                    <a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product_box text-center">
                            <div class="product_img">
                                <a href="shop-product-detail.html">
                                    <img src="{{asset('images/furniture_img2.jpg')}}" alt="furniture_img2">
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                        <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a href="shop-product-detail.html">adipisci officia libero</a></h6>
                                <div class="product_price">
                                    <span class="price">$55.00</span>
                                    <del>$95.00</del>
                                </div>
                                <div class="rating_wrap">
                                    <div class="rating">
                                        <div class="product_rate" style="width:68%"></div>
                                    </div>
                                    <span class="rating_num">(15)</span>
                                </div>
                                <div class="pr_desc">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                </div>
                                <div class="add-to-cart">
                                    <a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product_box text-center">
                            <div class="product_img">
                                <a href="shop-product-detail.html">
                                    <img src="{{asset('images/furniture_img3.jpg')}}" alt="furniture_img3">
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                        <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a href="shop-product-detail.html">Internet tend to repeat</a></h6>
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
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                </div>
                                <div class="add-to-cart">
                                    <a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product_box text-center">
                            <div class="product_img">
                                <a href="shop-product-detail.html">
                                    <img src="{{asset('images/furniture_img4.jpg')}}" alt="furniture_img4">
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                        <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a href="shop-product-detail.html">Many desktop publishing</a></h6>
                                <div class="product_price">
                                    <span class="price">$69.00</span>
                                    <del>$89.00</del>
                                </div>
                                <div class="rating_wrap">
                                    <div class="rating">
                                        <div class="product_rate" style="width:70%"></div>
                                    </div>
                                    <span class="rating_num">(22)</span>
                                </div>
                                <div class="pr_desc">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                </div>
                                <div class="add-to-cart">
                                    <a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product_box text-center">
                            <div class="product_img">
                                <a href="shop-product-detail.html">
                                    <img src="{{asset('images/furniture_img5.jpg')}}" alt="furniture_img5">
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                        <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a href="shop-product-detail.html">injected humour repetition</a></h6>
                                <div class="product_price">
                                    <span class="price">$45.00</span>
                                    <del>$55.25</del>
                                </div>
                                <div class="rating_wrap">
                                    <div class="rating">
                                        <div class="product_rate" style="width:80%"></div>
                                    </div>
                                    <span class="rating_num">(21)</span>
                                </div>
                                <div class="pr_desc">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                </div>
                                <div class="add-to-cart">
                                    <a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="product_box text-center">
                            <div class="product_img">
                                <a href="shop-product-detail.html">
                                    <img src="{{asset('images/furniture_img6.jpg')}}" alt="furniture_img6">
                                </a>
                                <div class="product_action_box">
                                    <ul class="list_none pr_action_btn">
                                        <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                        <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                        <li><a href="#"><i class="icon-heart"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="product_info">
                                <h6 class="product_title"><a href="shop-product-detail.html">randomised humour words</a></h6>
                                <div class="product_price">
                                    <span class="price">$55.00</span>
                                    <del>$95.00</del>
                                </div>
                                <div class="rating_wrap">
                                    <div class="rating">
                                        <div class="product_rate" style="width:68%"></div>
                                    </div>
                                    <span class="rating_num">(15)</span>
                                </div>
                                <div class="pr_desc">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus blandit massa enim. Nullam id varius nunc id varius nunc.</p>
                                </div>
                                <div class="add-to-cart">
                                    <a href="#" class="btn btn-fill-out btn-radius"><i class="icon-basket-loaded"></i> Add To Cart</a>
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

<!-- START SECTION BLOG -->
<div class="section small_pt pb_70">
	<div class="container">
    	<div class="row justify-content-center">
        	<div class="col-lg-6 col-md-8">
            	<div class="heading_s1 text-center">
                	<h2>Latest News</h2>
                </div>
                <p class="leads text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.</p>
            </div>
        </div>
        <div class="row justify-content-center">
        	<div class="col-lg-4 col-md-6">
            	<div class="blog_post blog_style1 box_shadow1">
                	<div class="blog_img">
                        <a href="blog-single.html">
                            <img src="{{asset('images/furniture_blog_img1.jpg')}}" alt="furniture_blog_img1">
                        </a>
                    </div>
                    <div class="blog_content bg-white">
                    	<div class="blog_text">
                            <h5 class="blog_title"><a href="blog-single.html">But I must explain to you how all this mistaken idea</a></h5>
                            <ul class="list_none blog_meta">
                                <li><a href="#"><i class="ti-calendar"></i> April 14, 2018</a></li>
                                <li><a href="#"><i class="ti-comments"></i> 2 Comment</a></li>
                            </ul>
                            <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything hidden in the text</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
            	<div class="blog_post blog_style1 box_shadow1">
                	<div class="blog_img">
                        <a href="blog-single.html">
                            <img src="{{asset('images/furniture_blog_img2.jpg')}}" alt="furniture_blog_img2">
                        </a>
                    </div>
                    <div class="blog_content bg-white">
                    	<div class="blog_text">
                            <h5 class="blog_title"><a href="blog-single.html">On the other hand we provide denounce with righteous</a></h5>
                            <ul class="list_none blog_meta">
                                <li><a href="#"><i class="ti-calendar"></i> April 14, 2018</a></li>
                                <li><a href="#"><i class="ti-comments"></i> 2 Comment</a></li>
                            </ul>
                            <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything hidden in the text</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
            	<div class="blog_post blog_style1 box_shadow1">
                	<div class="blog_img">
                        <a href="blog-single.html">
                            <img src="{{asset('images/furniture_blog_img3.jpg')}}" alt="furniture_blog_img3">
                        </a>
                    </div>
                    <div class="blog_content bg-white">
                    	<div class="blog_text">
                            <h5 class="blog_title"><a href="blog-single.html">Why is a ticket to Lagos so expensive?</a></h5>
                            <ul class="list_none blog_meta">
                                <li><a href="#"><i class="ti-calendar"></i> April 14, 2018</a></li>
                                <li><a href="#"><i class="ti-comments"></i> 2 Comment</a></li>
                            </ul>
                            <p>If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't anything hidden in the text</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION BLOG -->

</div>
<!-- END MAIN CONTENT -->


@endsection