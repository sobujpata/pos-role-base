<div class="container mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="heading_s1 text-center">
                <h2 class="fs-2">Exclusive Products</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="tab-style1">
                <ul class="nav nav-tabs justify-content-center" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="arrival-tab" data-bs-toggle="tab" href="#Popular" role="tab"
                            aria-controls="arrival" aria-selected="true">Popular</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="sellers-tab" data-bs-toggle="tab" href="#New" role="tab"
                            aria-controls="sellers" aria-selected="false">New</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="featured-tab" data-bs-toggle="tab" href="#Top" role="tab"
                            aria-controls="featured" aria-selected="false">Top</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="special-tab" data-bs-toggle="tab" href="#Special" role="tab"
                            aria-controls="special" aria-selected="false">Special</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="special-tab" data-bs-toggle="tab" href="#Trending" role="tab"
                            aria-controls="special" aria-selected="false">Trending</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="Popular" role="tabpanel" aria-labelledby="arrival-tab">
                    <div id="PopularItem" class="row shop_container">




                    </div>
                </div>
                <div class="tab-pane fade" id="New" role="tabpanel" aria-labelledby="sellers-tab">
                    <div id="NewItem" class="row shop_container">


                    </div>
                </div>
                <div class="tab-pane fade" id="Top" role="tabpanel" aria-labelledby="featured-tab">
                    <div id="TopItem" class="row shop_container">

                    </div>
                </div>
                <div class="tab-pane fade" id="Special" role="tabpanel" aria-labelledby="special-tab">
                    <div id="SpecialItem" class="row shop_container">

                    </div>
                </div>
                <div class="tab-pane fade" id="Trending" role="tabpanel" aria-labelledby="special-tab">
                    <div id="TrendingItem" class="row shop_container">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    function slugify(text) {
        return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-')        // Replace spaces with -
            .replace(/[^\w\-]+/g, '')    // Remove all non-word chars
            .replace(/\-\-+/g, '-');     // Replace multiple - with single -
    }

    async function Popular() {
        let res = await axios.get("/ListProductByRemark/popular");
        // console.log(res);
        $("#PopularItem").empty();

        res.data['data'].forEach((item) => {
            let productSlug = slugify(item.title) + '-' + item.id;
            let productUrl = `/details/${productSlug}`;
            
            let EachItem = `
        <div class="col-lg-3 col-md-4 col-6">
            <div class="product">
                <div class="product_img">
                    <a href="#">
                        <img src="storage/${item['image']}" alt="product_img">
                    </a>
                    <div class="product_action_box">
                        <ul class="list_none pr_action_btn">
                            <li class="add-to-cart">
                                <a href="#" class="addToCartBtn" 
                                   data-id="${item['id']}" 
                                   data-name="${item['title']}" 
                                   data-image="storage/${item['image']}" 
                                   data-price="${item['price']}">
                                    <i class="icon-basket-loaded"></i> Add To Cart
                                </a>
                            </li>
                            <li><a href="#"><i class="icon-shuffle"></i></a></li>
                            <li><a href="#"><i class="icon-magnifier-add"></i></a></li>
                            <li><a href="#"><i class="icon-heart"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="product_info">
                    <h6 class="product_title">
                        <a href="${productUrl}">${item['title']}</a>
                    </h6>
                    <div class="product_price">
                        <span class="price">$ ${item['price']}</span>
                    </div>
                    <div class="rating_wrap">
                        <div class="rating">
                            <div class="product_rate" style="width:${item['star']}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
            $("#PopularItem").append(EachItem);
        });

        // Use delegation to bind event after DOM is ready
        $(document).on('click', '.addToCartBtn', function(e) {
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
    }



    async function New() {
        let res = await axios.get("/ListProductByRemark/new");
        $("#NewItem").empty();
        res.data['data'].forEach((item, i) => {
            let productSlug = slugify(item.title) + '-' + item.id;
            let productUrl = `/details/${productSlug}`;
            let EachItem = `
        <div class="col-lg-3 col-md-4 col-6">
            <div class="product">
                <div class="product_img">
                    <a href="${productUrl}">
                        <img src="storage/${item['image']}" alt="product_img">
                    </a>
                    <div class="product_action_box">
                        <ul class="list_none pr_action_btn">
                            <li class="add-to-cart">
                                <a href="#" class="addToCartBtnNew" 
                                   data-id="${item['id']}" 
                                   data-name="${item['title']}" 
                                   data-image="storage/${item['image']}" 
                                   data-price="${item['price']}">
                                    <i class="icon-basket-loaded"></i> Add To Cart
                                </a>
                            </li>
                            <li><a href="#"><i class="icon-shuffle"></i></a></li>
                            <li><a href="#"><i class="icon-magnifier-add"></i></a></li>
                            <li><a href="#"><i class="icon-heart"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="product_info">
                    <h6 class="product_title"><a href="${productUrl}">${item['title']}</a></h6>
                    <div class="product_price">
                        <span class="price">$ ${item['price']}</span>
                    </div>
                    <div class="rating_wrap">
                        <div class="rating">
                            <div class="product_rate" style="width:${item['star']}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
            $("#NewItem").append(EachItem);
        });

        // Use delegation to bind event after DOM is ready
        $(document).on('click', '.addToCartBtnNew', function(e) {
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
    }


    async function Top() {
        let res = await axios.get("/ListProductByRemark/top");
        $("#TopItem").empty();
        res.data['data'].forEach((item, i) => {
            let productSlug = slugify(item.title) + '-' + item.id;
            let productUrl = `/details/${productSlug}`;
            let EachItem = `
        <div class="col-lg-3 col-md-4 col-6">
            <div class="product">
                <div class="product_img">
                    <a href="${productUrl}">
                        <img src="storage/${item['image']}" alt="product_img">
                    </a>
                    <div class="product_action_box">
                        <ul class="list_none pr_action_btn">
                            <li class="add-to-cart">
                                <a href="#" class="addToCartBtnTop" 
                                   data-id="${item['id']}" 
                                   data-name="${item['title']}" 
                                   data-image="storage/${item['image']}" 
                                   data-price="${item['price']}">
                                    <i class="icon-basket-loaded"></i> Add To Cart
                                </a>
                            </li>
                            <li><a href="#"><i class="icon-shuffle"></i></a></li>
                            <li><a href="#"><i class="icon-magnifier-add"></i></a></li>
                            <li><a href="#"><i class="icon-heart"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="product_info">
                    <h6 class="product_title"><a href="${productUrl}">${item['title']}</a></h6>
                    <div class="product_price">
                        <span class="price">$ ${item['price']}</span>
                    </div>
                    <div class="rating_wrap">
                        <div class="rating">
                            <div class="product_rate" style="width:${item['star']}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
            $("#TopItem").append(EachItem);
        });

        // Use delegation to bind event after DOM is ready
        $(document).on('click', '.addToCartBtnTop', function(e) {
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
    }



    async function Special() {
        let res = await axios.get("/ListProductByRemark/special");
        $("#SpecialItem").empty();

        res.data['data'].forEach((item, i) => {
            let productSlug = slugify(item.title) + '-' + item.id;
            let productUrl = `/details/${productSlug}`;
            let EachItem = `
        <div class="col-lg-3 col-md-4 col-6">
            <div class="product">
                <div class="product_img">
                    <a href="#">
                        <img src="storage/${item['image']}" alt="product_img">
                    </a>
                    <div class="product_action_box">
                        <ul class="list_none pr_action_btn">
                            <li class="add-to-cart">
                                <a href="#" class="addToCartBtnSpecial" 
                                   data-id="${item['id']}" 
                                   data-name="${item['title']}" 
                                   data-image="storage/${item['image']}" 
                                   data-price="${item['price']}">
                                    <i class="icon-basket-loaded"></i> Add To Cart
                                </a>
                            </li>
                            <li><a href="#"><i class="icon-shuffle"></i></a></li>
                            <li><a href="#"><i class="icon-magnifier-add"></i></a></li>
                            <li><a href="#"><i class="icon-heart"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="product_info">
                    <h6 class="product_title"><a href="${productUrl}">${item['title']}</a></h6>
                    <div class="product_price">
                        <span class="price">$ ${item['price']}</span>
                    </div>
                    <div class="rating_wrap">
                        <div class="rating">
                            <div class="product_rate" style="width:${item['star']}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
            $("#SpecialItem").append(EachItem);
        });

        // Use delegation to bind event after DOM is ready
        $(document).on('click', '.addToCartBtnSpecial', function(e) {
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
    }



    async function Trending() {
        let res = await axios.get("/ListProductByRemark/trending");
        $("#TrendingItem").empty();
        res.data['data'].forEach((item, i) => {
            let productSlug = slugify(item.title) + '-' + item.id;
            let productUrl = `/details/${productSlug}`;
            let EachItem = `
        <div class="col-lg-3 col-md-4 col-6">
            <div class="product">
                <div class="product_img">
                    <a href="${productUrl}">
                        <img src="storage/${item['image']}" alt="product_img">
                    </a>
                    <div class="product_action_box">
                        <ul class="list_none pr_action_btn">
                            <li class="add-to-cart">
                                <a href="#" class="addToCartBtnTrending" 
                                   data-id="${item['id']}" 
                                   data-name="${item['title']}" 
                                   data-price="${item['price']}"
                                   data-image="storage/${item['image']}">
                                    <i class="icon-basket-loaded"></i> Add To Cart
                                </a>
                            </li>
                            <li><a href="#"><i class="icon-shuffle"></i></a></li>
                            <li><a href="#"><i class="icon-magnifier-add"></i></a></li>
                            <li><a href="#"><i class="icon-heart"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="product_info">
                    <h6 class="product_title"><a href="${productUrl}">${item['title']}</a></h6>
                    <div class="product_price">
                        <span class="price">$ ${item['price']}</span>
                    </div>
                    <div class="rating_wrap">
                        <div class="rating">
                            <div class="product_rate" style="width:${item['star']}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;
            $("#TrendingItem").append(EachItem);
        });

        // Use delegation to bind event after DOM is ready
        $(document).on('click', '.addToCartBtnTrending', function(e) {
            e.preventDefault();

            let formData = new FormData();
            formData.append('id', $(this).data('id'));
            formData.append('name', $(this).data('name'));
            formData.append('price', $(this).data('price'));
            formData.append('image', $(this).data('image'));
            axios.post("/cart/add", formData)
                .then(res => {
                    if (res.data.success) {
                        alert('Product added to cart!');
                    }
                    updateCartCount();
                }).catch(err => {
                    console.error(err);
                    alert('Error adding to cart');
                });

        });
    }

    function updateCartCount() {
        axios.get('/cart/count').then(res => {
            document.getElementById('cart-count').textContent = res.data.count;
            console.log(res.data.cart);

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
