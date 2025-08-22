<!-- START HEADER -->
<header class="header_wrap fixed-top header_with_topbar">
    <div class="top-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <div class="lng_dropdown me-2">
                            <select name="countries" class="custome_select">
                                <option value='en' data-image="{{ asset('images/eng.png') }}" data-title="English">
                                    English</option>
                                <option value='fn' data-image="{{ asset('images/fn.png') }}" data-title="France">
                                    France</option>
                                <option value='us' data-image="{{ asset('images/us.png') }}"
                                    data-title="United States">United States</option>
                            </select>
                        </div>
                        <div class="me-3">
                            <select name="countries" class="custome_select">
                                <option value='USD' data-title="USD">USD</option>
                                <option value='EUR' data-title="EUR">EUR</option>
                                <option value='GBR' data-title="GBR">GBR</option>
                            </select>
                        </div>
                        <ul class="contact_detail text-center text-lg-start">
                            <li><i class="ti-mobile"></i><span>01739871705</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center text-md-end">
                        <ul class="header_list">
                            <li><a href="compare.html"><i class="ti-control-shuffle"></i><span>Compare</span></a></li>
                            <li><a href="wishlist.html"><i class="ti-heart"></i><span>Wishlist</span></a></li>
                            <li><a href="{{ url('/login') }}"><i class="ti-user"></i><span>Login</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom_header dark_skin main_menu_uppercase">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="logo_light" src="{{ asset('images/logo_light.png') }}" alt="logo" />
                    <img class="logo_dark" src="{{ asset('images/logo_dark.png') }}" alt="logo" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-expanded="false">
                    <span class="ion-android-menu"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="dropdown">
                            <a data-bs-toggle="dropdown" class="nav-link dropdown-toggle active" href="#">Home</a>
                            <div class="dropdown-menu">
                                <ul>
                                    <li><a class="dropdown-item nav-link nav_item active" href="/">Fashion 1</a>
                                    </li>
                                    <li><a class="dropdown-item nav-link nav_item" href="/home-2">Fashion 2</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="/home-3">Furniture 1</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="/home-4">Furniture 2</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="/home-5">Electronics 1</a></li>
                                    <li><a class="dropdown-item nav-link nav_item" href="/home-6">Electronics 2</a></li>
                                </ul>
                            </div>
                        </li>

                        <li class="dropdown dropdown-mega-menu">
                            <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Products</a>
                            <div class="dropdown-menu">
                                <ul class="mega-menu d-lg-flex" id="category-dropdown">

                                </ul>
                                <div class="d-lg-flex menu_banners row g-3 px-3" id="menu_banners">

                                </div>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Blog</a>
                            <div class="dropdown-menu dropdown-reverse">
                                <ul>
                                    <li>
                                        <a class="dropdown-item menu-link dropdown-toggler" href="#">Fashions</a>
                                        <div class="dropdown-menu">
                                            <ul>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">Fashion
                                                        1</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">Fashion
                                                        2</a></li>
                                            </ul>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item menu-link dropdown-toggler" href="#">Health</a>
                                        <div class="dropdown-menu">
                                            <ul>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">Health
                                                        1</a></li>
                                                <li><a class="dropdown-item nav-link nav_item" href="#">Health
                                                        2</a></li>
                                            </ul>
                                        </div>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        {{-- <li class="dropdown dropdown-mega-menu">
                            <a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Shop</a>
                            <div class="dropdown-menu">
                                <ul class="mega-menu d-lg-flex">
                                    <li class="mega-menu-col col-lg-9">
                                        <ul class="d-lg-flex">
                                            <li class="mega-menu-col col-lg-4">
                                                <ul>
                                                    <li class="dropdown-header">Shop Page Layout</li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                            href="shop-list.html">shop List view</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                            href="shop-list-left-sidebar.html">shop List Left
                                                            Sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                            href="shop-list-right-sidebar.html">shop List Right
                                                            Sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                            href="shop-left-sidebar.html">Left Sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                            href="shop-right-sidebar.html">Right Sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                            href="shop-load-more.html">Shop Load More</a></li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-4">
                                                <ul>
                                                    <li class="dropdown-header">Other Pages</li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                            href="shop-cart.html">Cart</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                            href="checkout.html">Checkout</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                            href="my-account.html">My Account</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                            href="wishlist.html">Wishlist</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                            href="compare.html">compare</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                            href="order-completed.html">Order Completed</a></li>
                                                </ul>
                                            </li>
                                            <li class="mega-menu-col col-lg-4">
                                                <ul>
                                                    <li class="dropdown-header">Product Pages</li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                            href="shop-product-detail.html">Default</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                            href="shop-product-detail-left-sidebar.html">Left
                                                            Sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                            href="shop-product-detail-right-sidebar.html">Right
                                                            Sidebar</a></li>
                                                    <li><a class="dropdown-item nav-link nav_item"
                                                            href="shop-product-detail-thumbnails-left.html">Thumbnails
                                                            Left</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="mega-menu-col col-lg-3">
                                        <div class="header_banner">
                                            <div class="header_banner_content">
                                                <div class="shop_banner">
                                                    <div class="banner_img overlay_bg_40">
                                                        <img src="{{ asset('images/shop_banner.jpg') }}"
                                                            alt="shop_banner" />
                                                    </div>
                                                    <div class="shop_bn_content">
                                                        <h5 class="text-uppercase shop_subtitle">New Collection</h5>
                                                        <h3 class="text-uppercase shop_title">Sale 30% Off</h3>
                                                        <a href="#"
                                                            class="btn btn-white rounded-0 btn-sm text-uppercase">Shop
                                                            Now</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li> --}}
                        <li><a class="nav-link nav_item" href="#">Contact Us</a></li>
                    </ul>
                </div>
                <ul class="navbar-nav attr-nav align-items-center">
                    <li><a href="javascript:;" class="nav-link search_trigger"><i
                                class="linearicons-magnifier"></i></a>
                        <div class="search_wrap">
                            <span class="close-search"><i class="ion-ios-close-empty"></i></span>
                            <form>
                                <input type="text" placeholder="Search" class="form-control" id="search_input">
                                <button type="submit" class="search_icon"><i
                                        class="ion-ios-search-strong"></i></button>
                            </form>
                        </div>
                        <div class="search_overlay"></div>
                    </li>
                    <li class="dropdown cart_dropdown"><a class="nav-link cart_trigger" href="#"
                            data-bs-toggle="dropdown"><i class="linearicons-cart"></i><span class="cart_count"
                                id="cart-count">{{ $totalCartCount }}</span></a>
                        <div class="cart_box dropdown-menu dropdown-menu-right">
                            <ul class="cart_list" id="cartProductList">
                                @foreach ($cart as $item)
                                    <li>
                                        <a href="{{ route('cart.remove', $item['id']) }}" class="item_remove"><i
                                                class="ion-close"></i></a>
                                        <a href="#"><img src="{{ $item['image'] }}"
                                                alt="{{ $item['name'] }}">{{ $item['name'] }}</a>
                                        <span class="cart_quantity"> {{ $item['quantity'] }} x
                                            <span class="cart_amount"> <span class="price_symbole">Tk
                                                </span>{{ $item['price'] }}</span></span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="cart_footer">
                                <p class="cart_total">
                                    <strong>Subtotal:</strong> 
                                    <span class="cart_price"> <span class="price_symbole">Tk </span></span><span id="subtotalHeader">{{ $subtotal }}</span></p>
                                <p class="cart_buttons"><a href="{{ url('/cart') }}"
                                        class="btn btn-fill-line rounded-0 view-cart">View Cart</a>
                                    <a href="#" class="btn btn-fill-out rounded-0 checkout">Checkout</a>
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
<!-- END HEADER -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        axios.get("{{ url('/category-main-nav') }}")
            .then(response => {
                const data = response.data;
                const categoryContainer = document.getElementById("category-dropdown");
                categoryContainer.innerHTML = ""; // Clear previous data

                data.mainCategories.forEach(mainCategory => {
                    let subCategoriesHtml = "";

                    if (data.subCategories[mainCategory.id]) {
                        data.subCategories[mainCategory.id].forEach(subCategory => {
                            subCategoriesHtml += `
                               <li><a class="dropdown-item nav-link nav_item" href="/product-category/${subCategory.categoryName}">${subCategory.categoryName}</a></li>
                               `;
                        });
                    }

                    categoryContainer.innerHTML += `                        
                            <li class="mega-menu-col col-lg-3">
                                <ul>
                                    <li class="dropdown-header">${mainCategory.categoryName}</li>
                                    ${subCategoriesHtml}
                                </ul>                                
                            </li>
                    `;
                });
            })
            .catch(error => console.error("Error fetching categories:", error));


        // Fetch and display menu banners
        axios.get("{{ url('/menu-banners-for-products') }}")
            .then(response => {
                const banners = response.data;
                const menuBannersContainer = document.getElementById("menu_banners");
                menuBannersContainer.innerHTML = ""; // Clear previous banners

                banners.forEach(banner => {
                    let imgSrc = fixImageUrl(banner.image);
                    menuBannersContainer.innerHTML += `                          
                            <div class="col-sm-4">
                                 <div class="header-banner">
                                      <img src="${imgSrc}" alt="${banner.title}">
                                      <div class="banne_info">
                                           <h6>${banner.discount}</h6>
                                           <h4>${banner.title}</h4>
                                           <a href="${banner.link}">Shop now</a>
                                      </div>
                                 </div>
                            </div>
                          `;
                });
            })
            .catch(error => console.error("Error fetching menu banners:", error));

    });

    function fixImageUrl(url) {
        if (!url.startsWith('http') && !url.startsWith('/')) {
            return '/' + url;  // add leading slash if missing
        }
        return url;
    }

// Usage

// let html = `<img src="${imgSrc}" alt="${banner.title}">`;
</script>
