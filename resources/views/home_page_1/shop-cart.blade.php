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

        <!-- START SECTION SHOP -->
        <div class="section">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="heading_s1 mb-3">
                                    <h6>Product Cart</h6>
                                </div>
                                <form id="cartUpdateForm">
                                    @csrf
                                    <ul class="cart_list">
                                        {{-- @dd($cart) --}}
                                        @foreach ($cart as $id => $item)
                                            <li class="text-dark">
                                                <a href="{{ route('cart.remove', $item['id']) }}" class="item_remove"
                                                    style="">
                                                    <i class="ion-close"></i>
                                                </a>
                                                <a href="#">
                                                    <img src="{{ $item['image'] }}"
                                                        alt="{{ $item['name'] }}">{{ $item['name'] }}
                                                </a>
                                                <span class="cart_total_amount float-end mr-4 mt-sm-2">
                                                    Tk {{ (float)$item['price'] * (int) $item['quantity'] }}
                                                </span>
                                                <span class="cart_quantity text-dark">
                                                    <span class="number">{{ (int) $item['quantity'] }}</span>
                                                    x
                                                    <span class="cart_amount">
                                                        <span class="price_symbole">Tk</span> <span
                                                            class="price">{{ (float)$item['price'] }}</span>
                                                    </span>


                                                </span>

                                                <div class="quantity">
                                                    <input type="button" value="-" class="minus">
                                                    <input type="text" name="quantities[{{ $id }}]"
                                                        value="{{ $item['quantity'] }}" title="Qty" class="qty"
                                                        size="4">
                                                    <input type="button" value="+" class="plus">


                                                </div>

                                            </li>
                                        @endforeach
                                    </ul>




                            </div>
                            <div class="col-md-4">
                                <div class="border p-3 p-md-4">
                                    <div class="heading_s1 mb-3">
                                        <h6>Cart Totals</h6>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td class="cart_total_label">Cart Subtotal</td>
                                                    <td class="cart_total_amount text-end" id="subtotal">Tk
                                                        {{ $subtotal }}</td>
                                                </tr>

                                                {{-- <tr>
                                                    <td class="cart_total_label">Total</td>
                                                    <td class="cart_total_amount text-end"><strong>Tk {{ $subtotal }}</strong>
                                                    </td>
                                                </tr> --}}
                                            </tbody>
                                        </table>
                                    </div>
                                    <button class="btn btn-fill-out" style="width:100%" type="submit">ক্যাশ অন ডেলিভারিতে অর্ডার করুন</button>
                                    <!-- Button trigger modal -->
                                    {{-- <button class="btn btn-primary" type="submit">Process for Checkout</button> --}}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="medium_divider"></div>
                        <div class="divider center_icon"><i class="ti-shopping-cart-full"></i></div>
                        <div class="medium_divider"></div>
                    </div>
                </div>

            </div>
        </div>
        <!-- END SECTION SHOP -->


    </div>


    @include('home_page_1.checkout-modal')
    <script>
        $(document).on('submit', '#cartUpdateForm', function(e) {
            e.preventDefault();

            $.ajax({
                url: '{{ route('cart.update.ajax') }}',
                type: 'POST',
                // console.log($(this).serialize()),
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

            // Update subtotal by recalculating from all items (more reliable than adding/subtracting)
            function recalcSubtotal() {
                let subtotal = 0;
                $('.cart_list li').each(function() {
                    let qty = parseInt($(this).find('.qty').val()) || 1;
                    let price = parsePrice($(this).find('.price').text());
                    subtotal += qty * price;
                });
                $('#subtotal').text('Tk ' + subtotal.toFixed(2));
            }

            // Update the displayed quantity and total for a single item (pass li element)
            function updateItemTotal($li) {
                let qty = parseInt($li.find('.qty').val()) || 1;
                $li.find('.number').text(qty);
                let price = parsePrice($li.find('.price').text());
                let total = qty * price;
                $li.find('.cart_total_amount').text('Tk ' + total.toFixed(2));
            }

            // When quantity input manually changed
            $(document).on('change', '.qty', function() {
                let $li = $(this).closest('li');
                let qty = parseInt($(this).val()) || 1;
                if (qty < 1) {
                    qty = 1;
                    $(this).val(qty);
                }
                updateItemTotal($li);
                recalcSubtotal();
                updateQty();
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

            // Example updateQty function: collect quantities & optionally send to server
            function updateQty() {
                let quantities = {};
                $('.qty').each(function() {
                    let name = $(this).attr('name'); // e.g. quantities[5]
                    let val = parseInt($(this).val()) || 1;
                    quantities[name] = val;
                });
                console.log('Quantities to update:', quantities);

                // TODO: Send quantities to server via AJAX if you want
                // $.post('{{ route('cart.update.ajax') }}', quantities, function(response) {
                //     console.log('Cart updated:', response);
                // });
            }
        });
    </script>
@endsection
