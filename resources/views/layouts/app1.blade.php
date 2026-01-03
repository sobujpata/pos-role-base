<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="Anil z" name="author">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Localbazer is Powerful features and You Can Use The Perfect Build this Template For Any eCommerce Website. The template is built for sell Fashion, Auto parts, Electrical prats, Electronincs Equipment, Lather shoes, Sanitary, Products, Shoes, Bags, Cosmetics, Clothes, Sunglasses, Furniture, Kids Products, Electronics, Stationery Products and Sporting Goods.">
    <meta name="keywords"
        content="ecommerce, electronics store, Fashion store, furniture store,  bootstrap 4, clean, minimal, modern, online store, responsive, retail, shopping, ecommerce store">
    <title>Localbazer.com-@yield('title')</title>

    <!-- Favicon Icon -->
    <style>
        body {
            background: #fff;
            font-family: Arial, sans-serif;
            padding: 40px;
        }

        /* Container for each loading block */
        .skeleton-wrapper {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 24px;
            max-width: 100%;
        }

        /* Base skeleton block */
        .skeleton {
            position: relative;
            overflow: hidden;
            background-color: #e3e3e3;
            border-radius: 4px;
        }

        /* Shimmer animation overlay */
        .skeleton::after {
            content: "";
            position: absolute;
            top: 0;
            /* left: -150px; */
            width: 100%;
            height: 100hv;
            background: linear-gradient(90deg,
                    transparent,
                    rgba(255, 255, 255, 0.5),
                    transparent);
            animation: shimmer 1.5s infinite;
        }

        /* Shimmer animation keyframes */
        @keyframes shimmer {
            100% {
                left: 100%;
            }
        }

        /* Example layout pieces */
        .thumbnail {
            height: 180px;
            width: 100%;
        }

        .title {
            height: 30px;
            width: 80%;
        }

        .text {
            height: 20px;
            width: 60%;
        }

        .fade-out {
            opacity: 0;
            transition: opacity 0.1s ease-out;
            /* 100ms */
        }
    </style>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}">
    <!-- Animation CSS -->
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <!-- Latest Bootstrap min CSS -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,500,600,700,800,900&display=swap"
        rel="stylesheet">
    <!-- Icon Font CSS -->
    <link rel="stylesheet" href="{{ asset('css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/linearicons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/simple-line-icons.css') }}">
    <!--- owl carousel CSS-->
    <link rel="stylesheet" href="{{ asset('owlcarousel/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('owlcarousel/css/owl.theme.css') }}">
    <link rel="stylesheet" href="{{ asset('owlcarousel/css/owl.theme.default.min.css') }}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <!-- jquery-ui CSS -->
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <!-- Slick CSS -->
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">
    <!-- Style CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
    
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased">
    <!-- LOADER -->
    {{-- <div class="preloader">
        <div class="lds-ellipsis">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div> --}}
    <!-- Loader -->
    <div id="loader">
        <div class="skeleton-wrapper">
            <div class="skeleton thumbnail"></div>
            <div class="skeleton title"></div>
            <div class="skeleton text"></div>
        </div>
        <div class="skeleton-wrapper">
            <div class="skeleton thumbnail"></div>
            <div class="skeleton title"></div>
            <div class="skeleton text"></div>
        </div>
    </div>

    <div class="min-h-screen bg-gray-100 dark:bg-gray-900" id="real-content" style="display: none;">
        @include('layouts.partials.nav_1_2')
        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
        @include('layouts.partials.footer_1')
    </div>

    <!-- END FOOTER -->

    <a href="#" class="scrollup" style="display: none;"><i class="ion-ios-arrow-up"></i></a>

    <!-- Latest jQuery -->
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    
    <!-- jquery-ui -->
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <!-- popper min js -->
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <!-- Latest compiled and minified Bootstrap -->
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- owl-carousel min js  -->
    <script src="{{ asset('owlcarousel/js/owl.carousel.min.js') }}"></script>
    <!-- magnific-popup min js  -->
    <script src="{{ asset('js/magnific-popup.min.js') }}"></script>
    <!-- waypoints min js  -->
    <script src="{{ asset('js/waypoints.min.js') }}"></script>
    <!-- parallax js  -->
    <script src="{{ asset('js/parallax.js') }}"></script>
    <!-- countdown js  -->
    <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
    <!-- imagesloaded js -->
    <script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>
    <!-- isotope min js -->
    <script src="{{ asset('js/isotope.min.js') }}"></script>
    <!-- jquery.dd.min js -->
    <script src="{{ asset('js/jquery.dd.min.js') }}"></script>
    <!-- slick js -->
    <script src="{{ asset('js/slick.min.js') }}"></script>
    <!-- elevatezoom js -->
    <script src="{{ asset('js/jquery.elevatezoom.js') }}"></script>
    <!-- scripts js -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    @yield('scripts')
    @stack('scripts')
    <script>
        // Simulate loading (e.g., API call)
        setTimeout(() => {
            const loader = document.getElementById('loader');
            loader.classList.add('fade-out'); // start fade-out
            setTimeout(() => {
                loader.style.display = 'none'; // remove loader after fade
                //   document.getElementById("content-loader").style.display = "none";
                document.getElementById('real-content').style.display = 'block';
            }, 100); // match fade-out duration (100ms)
        }, 1000); // simulate 2s loading delay
    </script>
</body>

</html>
