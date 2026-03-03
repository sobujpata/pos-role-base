@extends('layouts.app1')
@section('content')
    <!-- START SECTION BREADCRUMB -->
    <div class="breadcrumb_section bg_gray page-title-mini">
        <div class="container"><!-- STRART CONTAINER -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="page-title">
                        <h1>Thank You for Your Order!</h1>
                    </div>
                </div>
                <div class="col-md-6">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">Order Confirmation</li>
                    </ol>
                </div>
            </div>
        </div><!-- END CONTAINER-->
    </div>
    <!-- END SECTION BREADCRUMB -->

    <!-- START MAIN CONTENT -->
    <div class="main_content">

        <!-- START THANK YOU SECTION -->
        <div class="section bg_light_blue">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="text-center">
                            <div class="success-icon mb-4">
                                <i class="fas fa-check-circle fa-5x text-success"></i>
                            </div>
                            <h2 class="mb-3">Order Placed Successfully!</h2>
                            <p class="lead mb-4">Thank you for shopping with us. Your order has been received and is being processed. You will receive an email confirmation shortly.</p>
                            <div class="order-summary bg-white p-4 rounded shadow-sm mb-4">
                                <h4 class="mb-3">Order Summary</h4>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p><strong>Order Number:</strong> #ORD-2024-{{ $order->id }}</p>
                                        <p><strong>Order Date:</strong> {{ $order->created_at }}</p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p><strong>Estimated Delivery:</strong> 3-5 Business Days</p>
                                        <p><strong>Payment Method:</strong> Cash on delivery</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END THANK YOU SECTION -->

        <!-- START WHAT HAPPENS NEXT SECTION -->
        <div class="section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h3 class="text-center mb-5">What Happens Next?</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="process-step text-center">
                            <div class="step-icon mb-3">
                                <i class="fas fa-envelope fa-3x text-primary"></i>
                            </div>
                            <h5>Order Confirmation</h5>
                            <p>You'll receive an email confirmation with your order details and tracking information.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="process-step text-center">
                            <div class="step-icon mb-3">
                                <i class="fas fa-box fa-3x text-warning"></i>
                            </div>
                            <h5>Processing</h5>
                            <p>Our team will carefully prepare your order and ensure everything is packed securely.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="process-step text-center">
                            <div class="step-icon mb-3">
                                <i class="fas fa-truck fa-3x text-info"></i>
                            </div>
                            <h5>Shipping</h5>
                            <p>Your order will be shipped via our trusted delivery partners with tracking updates.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END WHAT HAPPENS NEXT SECTION -->

        <!-- START CUSTOMER SUPPORT SECTION -->
        <div class="section bg_gray">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8">
                        <div class="text-center">
                            <h4 class="mb-3">Need Help?</h4>
                            <p class="mb-4">Our customer support team is here to assist you with any questions about your order.</p>
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <a href="tel:+8801739871705" class="btn btn-outline-primary btn-block">
                                        <i class="fas fa-phone mr-2"></i> Call Us
                                    </a>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <a href="mailto:info@localbazer.com" class="btn btn-outline-primary btn-block">
                                        <i class="fas fa-envelope mr-2"></i> Email Us
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CUSTOMER SUPPORT SECTION -->

        <!-- START CONTINUE SHOPPING SECTION -->
        <div class="section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="text-center">
                            <h4 class="mb-3">Continue Shopping</h4>
                            <p class="mb-4">Discover more amazing products in our collection.</p>
                            <a href="/" class="btn btn-primary btn-lg mr-3">
                                <i class="fas fa-home mr-2"></i> Back to Home
                            </a>
                            <a href="/products-view" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-shopping-bag mr-2"></i> Shop More
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTINUE SHOPPING SECTION -->

    </div>
    <!-- END MAIN CONTENT -->

@endsection
