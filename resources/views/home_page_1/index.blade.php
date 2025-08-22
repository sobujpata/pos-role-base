@extends('layouts.app1')
@section('title', 'Home-page')
@section('content')
@include('home_page_1.slider')
@include('home_page_1.popup')


<!-- END MAIN CONTENT -->
<div class="main_content">

@include('home_page_1.shop-banner')

@include('home_page_1.exclusive-products')

@include('home_page_1.single-banner')

@include('home_page_1.featured-product')


<!-- START SECTION TESTIMONIAL -->
<div class="section bg_redon">
	<div class="container">
    	<div class="row justify-content-center">
        	<div class="col-md-6">
            	<div class="heading_s1 text-center">
                	<h2>Our Client Say!</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-9">
            	<div class="testimonial_wrap testimonial_style1 carousel_slider owl-carousel owl-theme nav_style2" data-nav="true" data-dots="false" data-center="true" data-loop="true" data-autoplay="true" data-items='1'>
                	<div class="testimonial_box">
                    	<div class="testimonial_desc">
                        	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquam amet animi blanditiis consequatur debitis dicta distinctio, enim error eum iste libero modi nam natus perferendis possimus quasi sint sit tempora voluptatem.</p>
                        </div>
                        <div class="author_wrap">
                            <div class="author_img">
                                <img src="{{asset('images/user_img1.jpg')}}" alt="user_img1" />
                            </div>
                            <div class="author_name">
                                <h6>Lissa Castro</h6>
                                <span>Designer</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial_box">
                    	<div class="testimonial_desc">
                        	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquam amet animi blanditiis consequatur debitis dicta distinctio, enim error eum iste libero modi nam natus perferendis possimus quasi sint sit tempora voluptatem.</p>
                        </div>
                        <div class="author_wrap">
                            <div class="author_img">
                                <img src="{{asset('images/user_img2.jpg')}}" alt="user_img2" />
                            </div>
                            <div class="author_name">
                                <h6>Alden Smith</h6>
                                <span>Designer</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial_box">
                    	<div class="testimonial_desc">
                        	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquam amet animi blanditiis consequatur debitis dicta distinctio, enim error eum iste libero modi nam natus perferendis possimus quasi sint sit tempora voluptatem.</p>
                        </div>
                        <div class="author_wrap">
                            <div class="author_img">
                                <img src="{{asset('images/user_img3.jpg')}}" alt="user_img3" />
                            </div>
                            <div class="author_name">
                                <h6>Daisy Lana</h6>
                                <span>Designer</span>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial_box">
                    	<div class="testimonial_desc">
                        	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A aliquam amet animi blanditiis consequatur debitis dicta distinctio, enim error eum iste libero modi nam natus perferendis possimus quasi sint sit tempora voluptatem.</p>
                        </div>
                        <div class="author_wrap">
                            <div class="author_img">
                                <img src="{{asset('images/user_img4.jpg')}}" alt="user_img4" />
                            </div>
                            <div class="author_name">
                                <h6>John Becker</h6>
                                <span>Designer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION TESTIMONIAL -->

<!-- START SECTION SHOP INFO -->
<div class="section pb_70">
    	<div class="container">
            <div class="row g-0">
                <div class="col-lg-4">	
                    <div class="icon_box icon_box_style1">
                        <div class="icon">
                            <i class="flaticon-shipped"></i>
                        </div>
                        <div class="icon_box_content">
                            <h5>Free Delivery</h5>
                            <p>If you are going to use of Lorem, you need to be sure there anything</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">	
                    <div class="icon_box icon_box_style1">
                        <div class="icon">
                            <i class="flaticon-money-back"></i>
                        </div>
                        <div class="icon_box_content">
                            <h5>30 Day Return</h5>
                            <p>If you are going to use of Lorem, you need to be sure there anything</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">	
                    <div class="icon_box icon_box_style1">
                        <div class="icon">
                            <i class="flaticon-support"></i>
                        </div>
                        <div class="icon_box_content">
                            <h5>27/4 Support</h5>
                            <p>If you are going to use of Lorem, you need to be sure there anything</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- END SECTION SHOP INFO -->



</div>
<!-- END MAIN CONTENT -->


@endsection
@section('scripts')
    <script>
        (async () => {
            // await Category();
            await Hero();
            await ShopBanner();
            // await TopCategory();
            $(".preloader").delay(10).fadeOut(100).addClass('loaded');
            await Popular();
            await New();
            await Top();
            await Special();
            await Trending();
            await singleBannerShow();
            await Featured();
            // await TopBrands();
        })()
    </script>
@endsection