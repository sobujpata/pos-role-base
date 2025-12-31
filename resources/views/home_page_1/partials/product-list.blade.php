@php
    function slugify($text)
    {
        // Convert to string, lowercase, and trim
        $text = strtolower(trim($text));

        // Replace spaces with hyphens
        $text = preg_replace('/\s+/', '-', $text);

        // Remove all non-word characters (letters, numbers, underscore, hyphen)
        $text = preg_replace('/[^\w\-]+/', '', $text);

        // Replace multiple hyphens with a single hyphen
        $text = preg_replace('/\-+/', '-', $text);

        return $text;
    }
@endphp
<div class="row shop_container">
    @foreach ($products as $product)
        <div class="col-md-4 col-6">
            <div class="product">
                <div class="product_img">
                    <a href="{{ url('details/' . slugify($product->title) . '-' . $product->id) }}">
                        <img src="{{ asset('storage/'.$product->image) }}" alt="product_img1">
                    </a>
                    <div class="product_action_box">
                        <ul class="list_none pr_action_btn">
                            <li class="add-to-cart"><a href="#" class="addToCartBtnAll"
                                    data-id="{{ $product->id }}" data-name="{{ $product->title }}"
                                    data-image="{{ $product->image }}"
                                    data-price="{{ (float) $product->discount_price }}"><i
                                        class="icon-basket-loaded"></i>
                                    Add To Cart</a></li>
                            <li><a href="#" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                            <li><a href="#" class="popup-ajax"><i class="icon-magnifier-add"></i></a>
                            </li>
                            <li><a href="#"><i class="icon-heart"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="product_info">
                    <h6 class="product_title"><a
                            href="{{ url('details/' . slugify($product->title) . '-' . $product->id) }}">{{ $product->title }}</a>
                    </h6>
                    <div class="product_price">
                        <span class="price">Tk {{ $product->discount_price }}</span>
                        <del>Tk {{ $product->price }}</del>
                        <div class="on_sale">
                            <span>{{ $product->discount }} Off</span>
                        </div>
                    </div>
                    <div class="rating_wrap">
                        <div class="rating">
                            <div class="product_rate" style="width:80%"></div>
                        </div>
                        <span class="rating_num">({{ $product->star }})</span>
                    </div>
                    <div class="pr_desc">
                        <p>{{ $product->shor_des }}</p>
                    </div>
                    <div class="pr_switch_wrap">
                        <div class="product_color_switch">
                            <span class="active" data-color="#87554B"></span>
                            <span data-color="#333333"></span>
                            <span data-color="#DA323F"></span>
                        </div>
                    </div>
                    <div class="list_product_action_box">
                        <ul class="list_none pr_action_btn">
                            <li class="add-to-cart"><a href="#"><i class="icon-basket-loaded"></i>
                                    Add To Cart</a></li>
                            <li><a href="shop-compare.html" class="popup-ajax"><i class="icon-shuffle"></i></a></li>
                            <li><a href="shop-quick-view.html" class="popup-ajax"><i class="icon-magnifier-add"></i></a>
                            </li>
                            <li><a href="#"><i class="icon-heart"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div class="row">
    <div class="col-12">
        {{ $products->links() }}
    </div>
</div>
