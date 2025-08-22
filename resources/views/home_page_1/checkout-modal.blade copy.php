<!-- Modal -->
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">ক্যাশ অন
                    ডেলিভারিতে অর্ডার করতে আপনার তথ্য দিন</h1>
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
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-phone"></i></span>
                                    <input type="text" name="phone" class="form-control"
                                        placeholder="আপনার ফোন নম্বর লিখুন" aria-label="আপনার ফোন নম্বর লিখুন"
                                        aria-describedby="basic-addon1">
                                </div>
                                {{-- <input type="text" class="form-control" id="phone" name="phone" placeholder="আপনার ফোন নম্বর লিখুন"
                            required> --}}
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
                                {{-- <input type="text" class="form-control" id="address" name="address" placeholder="আপনার ঠিকানা লিখুন"
                            required> --}}
                            </div>
                        </div>
                    </div>
                    <h3>শিপিং মেথড</h3>
                    <div class="row px-3 py-3">
                        <div class="col-8">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="radioDefault" id="radioDefault1"
                                    checked value="70">
                                <label class="form-check-label" for="radioDefault1">
                                    ঢাকা সিটির ভিতরে
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="radioDefault" id="radioDefault2"
                                    value="150">
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
                    <div id="cartContainer">
                        @include('partials.cart-list')
                    </div>
                    <div id="cartSummary">
                        @include('partials.cart-summary')
                    </div>

                    <span id="cartItemCount">{{ $cartCount ?? 0 }}</span>



                    <button type="submit" class="btn btn-fill-out btn-outline-warning text-center w-100">আপনার
                        অর্ডার কনফার্ম করতে ক্লিক করুন</button>
                </form>
            </div>

        </div>
    </div>
</div>
