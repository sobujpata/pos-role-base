<!-- START SECTION SHOP -->
<div class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="heading_s1 text-center">
                    <h2>Featured Products</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="featuredItem" class="product_slider carousel_slider owl-carousel owl-theme nav_style1"
                    data-loop="true" data-dots="false" data-nav="true" data-margin="20"
                    data-responsive='{"0":{"items": "1"}, "481":{"items": "2"}, "768":{"items": "3"}, "1199":{"items": "4"}}'>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION SHOP -->
<script>
    async function Featured() {
        try {
            let res = await axios.get("/featured-products");

            $("#featuredItem").empty();

            res.data['data'].forEach((item) => {
                let productSlug = slugify(item.title) + '-' + item.id;
                let productUrl = `/details/${productSlug}`;
                let EachItem = `<div class="item">
                <div class="product">
                    <div class="product_img">
                        <a href="shop-product-detail.html">
                            <img src="${item['image']}" alt="product_img1">
                        </a>
                        <div class="product_action_box">
                            <ul class="list_none pr_action_btn">
                                <li class="add-to-cart">
                                    <a href="#" class="addToCartBtnFeature" 
                                   data-id="${item['id']}" 
                                   data-name="${item['title']}" 
                                   data-image="${item['image']}" 
                                   data-price="${item['price']}">
                                    <i class="icon-basket-loaded"></i> Add To Cart
                                    </a>
                                </li>
                                <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                                <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a></li>
                                <li><a href="#"><i class="icon-heart"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="product_info">
                        <h6 class="product_title"><a href="${productUrl}">${item['title']}</a></h6>
                        <div class="product_price">
                            <span class="price">${item['discount_price'] ?? '0.00'}</span>
                            <del>${item['price'] ?? '0.00'}</del>
                            <div class="on_sale">
                                <span>${item['discount'] + '% Off' ?? '0% Off'}</span>
                            </div>
                        </div>
                        <div class="rating_wrap">
                            <div class="rating">
                                <div class="product_rate" style="width:${item['star'] ?? 80}%"></div>
                            </div>
                            <span class="rating_num">(${item['stock'] ?? 21})</span>
                        </div>
                        <div class="pr_desc">
                            <p>${item['short_des']}</p>
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
            </div>`;

                $("#featuredItem").append(EachItem);
            });

            // Reinitialize owlCarousel
            $("#featuredItem").owlCarousel('destroy');
            $("#featuredItem").owlCarousel({
                loop: true,
                nav: true,
                dots: false,
                margin: 20,
                responsive: {
                    0: {
                        items: 1
                    },
                    481: {
                        items: 2
                    },
                    768: {
                        items: 3
                    },
                    1199: {
                        items: 4
                    }
                }
            });
        } catch (error) {
            console.error("Error fetching featured products:", error);
            $("#featuredItem").html("<p class='text-danger'>Failed to load featured products.</p>");
        }

        // Use delegation to bind event after DOM is ready
        $(document).on('click', '.addToCartBtnFeature', function(e) {
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

    
</script>
