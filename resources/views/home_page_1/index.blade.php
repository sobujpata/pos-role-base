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
@include('home_page_1.client')
@include('home_page_1.service')








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
            await getClient();
            // await TopBrands();
        })()
    </script>
@endsection