@extends('layouts.app1')
@section('content')
    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Shopping Cart</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Shopping Cart</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START MAIN CONTENT -->
    <div class="main_content">

        <!-- START SECTION SHOP CART -->
        <div class="section">
            <div class="container">
                @if(count($cart) > 0)
                <div class="row">
                    <!-- Cart Items -->
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-white">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-shopping-cart text-primary me-2"></i>
                                    <h5 class="mb-0">Your Cart Items ({{ count($cart) }})</h5>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <form id="cartUpdateForm">
                                    @csrf
                                    @foreach ($cart as $id => $item)
                                    <div class="cart-item border-bottom p-3">
                                        <div class="row align-items-center">
                                            <!-- Product Image -->
                                            <div class="col-md-2 col-sm-3">
                                                <div class="cart-product-image">
                                                    <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                                         class="img-fluid rounded" style="max-width: 80px; height: auto;">
                                                </div>
                                            </div>

                                            <!-- Product Details -->
                                            <div class="col-md-4 col-sm-4">
                                                <div class="cart-product-details">
                                                    <h6 class="mb-1">
                                                        <a href="#" class="text-decoration-none text-dark">{{ $item['name'] }}</a>
                                                    </h6>
                                                    <p class="text-muted small mb-0">Unit Price: Tk {{ number_format($item['price'], 2) }}</p>
                                                </div>
                                            </div>

                                            <!-- Quantity Controls -->
                                            <div class="col-md-3 col-sm-3">
                                                <div class="quantity-controls d-flex align-items-center justify-content-center">
                                                    <button type="button" class="btn btn-outline-secondary btn-sm minus" data-id="{{ $id }}">
                                                        <i class="fas fa-minus"></i>
                                                    </button>
                                                    <input type="text" name="quantities[{{ $id }}]"
                                                           value="{{ $item['quantity'] }}" class="form-control form-control-sm text-center qty mx-2"
                                                           style="width: 60px;" readonly>
                                                    <button type="button" class="btn btn-outline-secondary btn-sm plus" data-id="{{ $id }}">
                                                        <i class="fas fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <!-- Item Total & Remove -->
                                            <div class="col-md-3 col-sm-2 text-end">
                                                <div class="cart-item-total">
                                                    <h6 class="text-primary mb-1">Tk {{ number_format((float)$item['price'] * (int)$item['quantity'], 2) }}</h6>
                                                    <a href="{{ route('cart.remove', $item['id']) }}" class="text-danger remove-item" title="Remove item">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </form>
                            </div>
                        </div>

                        <!-- Continue Shopping -->
                        <div class="mt-3">
                            <a href="/" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                            </a>
                        </div>
                    </div>

                    <!-- Cart Summary -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm sticky-top" style="top: 88px;">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0 text-white">
                                    <i class="fas fa-calculator me-2"></i>Cart Summary
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="cart-summary">
                                    <div class="d-flex justify-content-between mb-3">
                                        <span>Subtotal ({{ count($cart) }} items)</span>
                                        <span class="fw-bold" id="subtotal">Tk {{ number_format($subtotal, 2) }}</span>
                                    </div>

                                    <div class="d-flex justify-content-between mb-3">
                                        <span>Shipping (In Dhaka)</span>
                                        <span class="text-success">70</span>
                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between mb-4">
                                        <span class="fw-bold">Total</span>
                                        @php
                                            $total = $subtotal+70;  
                                        @endphp
                                        <span class="fw-bold text-primary fs-5" id="total">Tk {{ number_format($subtotal+70, 2) }}</span>
                                    </div>

                                    <button class="btn btn-success btn-lg w-100 mb-3" type="submit" form="cartUpdateForm">
                                        <i class="fas fa-credit-card me-2"></i>ক্যাশ অন ডেলিভারিতে অর্ডার করুন
                                    </button>

                                    <div class="text-center">
                                        <small class="text-muted">
                                            <i class="fas fa-shield-alt me-1"></i>
                                            Secure checkout with SSL encryption
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Promo Code Section -->
                        <div class="card shadow-sm mt-3">
                            <div class="card-body">
                                <h6 class="mb-3">
                                    <i class="fas fa-tags me-2"></i>Have a Promo Code?
                                </h6>
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Enter promo code" id="promoCode">
                                    <button class="btn btn-outline-primary" type="button" id="applyPromo">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </div>
                                <small class="text-muted mt-2 d-block">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Promo codes are applied at checkout
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <!-- Empty Cart -->
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center empty-cart py-5">
                            <div class="empty-cart-icon mb-4">
                                <i class="fas fa-shopping-cart fa-4x text-muted"></i>
                            </div>
                            <h3 class="mb-3">Your Cart is Empty</h3>
                            <p class="text-muted mb-4">Looks like you haven't added any items to your cart yet.</p>
                            <a href="/" class="btn btn-primary btn-lg">
                                <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <!-- END SECTION SHOP CART -->

    </div>
    <!-- END MAIN CONTENT -->

    @include('home_page_1.checkout-modal')
    <script>
        $(document).on('submit', '#cartUpdateForm', function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('cart.update.ajax') }}',
                type: 'POST',
                data: $(this).serialize(),
                success: function(res) {
                    if (res.success) {
                        $('#cartItemCount').text(res.total_items);
                        fillCartItem(); // no await
                        $('#checkoutModal').modal('show');
                    }
                }
            });
        });
    </script>

    <script>
        $(function() {
            // Helper: parse price from string like "Tk 123.45"
            function parsePrice(text) {
                return parseFloat(text.replace(/[^\d\.]/g, '')) || 0;
            }

            // Update subtotal and total
            function updateTotals() {
                let subtotal = 0;
                $('.cart-item').each(function() {
                    let qty = parseInt($(this).find('.qty').val()) || 1;
                    let price = parsePrice($(this).find('.cart-product-details .text-muted').text());
                    subtotal += qty * price;
                });
                $('#subtotal').text('Tk ' + subtotal.toFixed(2));
                let total = subtotal+70;
                $('#total').text('Tk ' + total.toFixed(2));
            }

            // Update the displayed quantity and total for a single item
            function updateItemTotal($item) {
                let qty = parseInt($item.find('.qty').val()) || 1;
                let price = parsePrice($item.find('.cart-product-details .text-muted').text());
                let total = qty * price;
                $item.find('.cart-item-total h6').text('Tk ' + total.toFixed(2));
            }

            // When quantity input manually changed
            $(document).on('change', '.qty', function() {
                let $item = $(this).closest('.cart-item');
                let qty = parseInt($(this).val()) || 1;
                if (qty < 1) {
                    qty = 1;
                    $(this).val(qty);
                }
                updateItemTotal($item);
                updateTotals();
            });

            // Minus button click
            $(document).on('click', '.minus', function() {
                let $qtyInput = $(this).siblings('.qty');
                let currentQty = parseInt($qtyInput.val()) || 1;
                if (currentQty > 1) {
                    currentQty--;
                    $qtyInput.val(currentQty).trigger('change');
                }
            });

            // Plus button click
            $(document).on('click', '.plus', function() {
                let $qtyInput = $(this).siblings('.qty');
                let currentQty = parseInt($qtyInput.val()) || 1;
                currentQty++;
                $qtyInput.val(currentQty).trigger('change');
            });

            // Remove item with confirmation
            $(document).on('click', '.remove-item', function(e) {
                e.preventDefault();
                if (confirm('Are you sure you want to remove this item from your cart?')) {
                    window.location.href = $(this).attr('href');
                }
            });

            // Promo code functionality (placeholder)
            $(document).on('click', '#applyPromo', function() {
                let promoCode = $('#promoCode').val().trim();
                if (promoCode) {
                    alert('Promo code functionality would be implemented here. Code: ' + promoCode);
                } else {
                    alert('Please enter a promo code.');
                }
            });

            // Initialize totals on page load
            updateTotals();
        });
    </script>
@endsection
