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
                        <form id="checkoutForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="heading_s1 mb-3">
                                        <h6>Product Cart</h6>
                                    </div>
                                    <ul class="cart_list">
                                        @foreach ($cart as $item)
                                            <li class="text-dark">
                                                <a href="{{ route('cart.remove', $item['id']) }}" class="item_remove"
                                                    style="margin-top: 30px !important"><i class="ion-close"></i></a>
                                                <a href="#"><img src="{{ $item['image'] }}"
                                                        alt="{{ $item['name'] }}">{{ $item['name'] }}</a>
                                                <span class="cart_quantity text-dark"> {{ $item['quantity'] }} x
                                                    <span class="cart_amount"> <span class="price_symbole">Tk
                                                        </span>{{ $item['price'] }}</span></span>
                                                <div class="quantity">
                                                    <input type="button" value="-" class="minus">
                                                    <input type="text" name="quantity[{{ $item['id'] }}]" value="{{ $item['quantity'] }}"
                                                        title="Qty" class="qty" size="4">
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
                                                        <td class="cart_total_amount">Tk {{ $subtotal }}</td>
                                                    </tr>
                                                    {{-- <tr>
                                                    <td class="cart_total_label">Shipping</td>
                                                    <td class="cart_total_amount">Free Shipping</td>
                                                </tr> --}}
                                                    <tr>
                                                        <td class="cart_total_label">Total</td>
                                                        <td class="cart_total_amount"><strong>Tk
                                                                {{ $subtotal }}</strong>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Checkout</button>
                                        {{-- <button type="submit" class="btn btn-fill-out" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal">ক্যাশ অন ডেলিভারিতে অর্ডার করুন</button> --}}
                                        <!-- Button trigger modal -->
                                    </div>
                                </div>
                            </div>
                        </form>
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
    <!-- END MAIN CONTENT -->


    <!--Checkout Modal -->
    <div class="modal fade" id="checkoutModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="modal-title fs-6 text-center bolder" id="exampleModalLabel">ক্যাশ অন
                        ডেলিভারিতে অর্ডার করতে আপনার তথ্য দিন</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        @csrf
                        <div class="form-group mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <label for="name">আপনার নাম</label>
                                </div>
                                <div class="col-9">
                                    {{-- <input type="text" class="form-control" id="name" name="name" placeholder="আপনার নাম লিখুন" --}}
                                    {{-- required> --}}
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                        <input type="text" class="form-control" name="name"
                                            placeholder="আপনার নাম লিখুন" aria-label="আপনার নাম লিখুন"
                                            aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <label for="phone">ফোন নম্বর</label>
                                </div>
                                <div class="col-9">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i
                                                class="fa fa-phone"></i></span>
                                        <input type="text" name="phone" class="form-control"
                                            placeholder="আপনার ফোন নম্বর লিখুন" aria-label="আপনার ফোন নম্বর লিখুন"
                                            aria-describedby="basic-addon1">
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <div class="row">
                                <div class="col-3">
                                    <label for="address">আপনার ঠিকানা</label>
                                </div>
                                <div class="col-9">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-map-marker"
                                                aria-hidden="true"></i></span>
                                        <input type="text" class="form-control" name="address"
                                            placeholder="আপনার ঠিকানা লিখুন" aria-label="আপনার ঠিকানা লিখুন"
                                            aria-describedby="basic-addon1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h3>শিপিং মেথড</h3>
                        <div class="row px-3 py-3">
                            <div class="col-8">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radioDefault"
                                        id="radioDefault1" checked value="70">
                                    <label class="form-check-label" for="radioDefault1">
                                        ঢাকা সিটির ভিতরে
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="radioDefault"
                                        id="radioDefault2" value="150">
                                    <label class="form-check-label" for="radioDefault2">
                                        ঢাকা সিটির বাহিরে
                                    </label>
                                </div>

                            </div>
                            <div class="col-4">
                                Tk 70.00
                                <br>
                                Tk 150.00
                            </div>

                        </div>
                        <span id="checkoutContent"></span>

                        <ul class="cart_list">
                            @foreach ($cart as $item)
                                <li>
                                    <a href="{{ route('cart.remove', $item['id']) }}" class="item_remove mt-4"><i
                                            class="ion-close"></i></a>
                                    <a href="#"><img src="{{ $item['image'] }}"
                                            alt="{{ $item['name'] }}">{{ $item['name'] }}</a>
                                    <span class="cart_quantity text-dark">
                                        {{ $item['quantity'] }} x
                                        <span class="cart_amount"> <span class="price_symbole text-dark">Tk
                                            </span>{{ $item['price'] }}</span></span>
                                </li>
                            @endforeach
                        </ul>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td class="cart_total_label">সাব টোটাল</td>
                                    <td class="cart_total_amount text-end">Tk
                                        {{ $subtotal }}</td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label">ডেলিভারি চার্জ</td>
                                    <td class="cart_total_amount text-end">Free Shipping
                                    </td>
                                </tr>
                                <tr>
                                    <td class="cart_total_label"><strong>সর্বমোট</strong>
                                    </td>
                                    <td class="cart_total_amount text-end"><strong>Tk
                                            {{ $subtotal }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-fill-out btn-outline-warning text-center w-100">আপনার
                            অর্ডার কনফার্ম করতে ক্লিক করুন</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    axios.post('/cart/update', formData)
        .then(res => {
            if (res.data.success) {
                const cart = res.data.cart;
                const subtotal = res.data.subtotal;

                let html = '<table class="table"><thead><tr><th>Name</th><th>Price</th><th>Qty</th><th>Total</th></tr></thead><tbody>';
                cart.forEach(item => {
                    html += `<tr>
                        <td>${item.name}</td>
                        <td>$${item.price}</td>
                        <td>${item.quantity}</td>
                        <td>$${item.price * item.quantity}</td>
                    </tr>`;
                });
                html += `<tr><td colspan="3"><strong>Subtotal</strong></td><td><strong>$${subtotal}</strong></td></tr>`;
                html += '</tbody></table>';

                document.getElementById('checkoutContent').innerHTML = html;

                // Show the Bootstrap modal
                const modal = new bootstrap.Modal(document.getElementById('checkoutModal'));
                modal.show();
            }
        })
        .catch(err => {
            alert("Something went wrong!");
            console.error(err);
        });
});
</script>

@endsection
