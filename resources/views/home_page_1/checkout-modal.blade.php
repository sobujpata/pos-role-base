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
                <form action="">
                    @csrf
                    <div class="form-group mb-2">
                        <div class="row">
                            <div class="col-3">
                                <label for="name">আপনার নাম</label>
                            </div>
                            <div class="col-9">
                                
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" name="name" id="fname"
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
                                    <input type="text" name="phone" id="phone_no" class="form-control"
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
                                    <input type="text" class="form-control" name="address" id="address"
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

                    <div id="cartItem"></div>
                    <div id="cartSummary"></div>
                </form>
                <button onclick="confirmOrder()" type="submit"
                    class="btn btn-fill-out btn-outline-warning text-center w-100">আপনার
                    অর্ডার কনফার্ম করতে ক্লিক করুন</button>

            </div>

        </div>
    </div>
</div>
<script>
    function updateSummary() {
        let shipping = parseFloat($('input[name="radioDefault"]:checked').val()) || 0;
        let subtotalText = $('#subtotal_modal').text().replace(/,/g, '').trim();
        let subtotal = parseFloat(subtotalText) || 0;

        $('#shipping_charge').text(shipping.toFixed(2));
        $('#total').text((subtotal + shipping).toFixed(2));
    }

    async function fillCartItem() {
        try {
            let res = await axios.get('/cart/checkout');
            let cartItem = $("#cartItem");
            cartItem.empty();
            let cartSummary = $("#cartSummary");
            cartSummary.empty();

            res.data.cart.forEach(function(item) {
                let removeUrl = `{{ url('cart/remove') }}/${item.id}`;
                let htmlCart = `
                <ul class="cart_list">
                    <li>
                        <a href="${removeUrl}" class="item_remove mt-4"><i class="ion-close"></i></a>
                        <a href="#"><img src="${item.image}" alt="${item.name}">${item.name}</a>
                        <span class="cart_total_amount float-end mt-4">Tk ${item.price * item.quantity}</span>
                        <span class="cart_quantity text-dark">${item.quantity} x
                            <span class="cart_amount"><span class="price_symbole">Tk</span>${item.price}</span>
                        </span>
                    </li>
                </ul>
            `;
                cartItem.append(htmlCart);
            });

            let summary = `
            <table class="table">
                <tbody>
                    <tr>
                        <td class="cart_total_label">সাব টোটাল</td>
                        <td class="cart_total_amount text-end">Tk <span id="subtotal_modal">${res.data.subtotal}</span></td>
                    </tr>
                    <tr>
                        <td class="cart_total_label">ডেলিভারি চার্জ</td>
                        <td class="cart_total_amount text-end" id="shipping_charge">70</td>
                    </tr>
                    <tr>
                        <td class="cart_total_label"><strong>সর্বমোট</strong></td>
                        <td class="cart_total_amount text-end"><strong>Tk <span id="total">${res.data.subtotal + 70}</span></strong></td>
                    </tr>
                </tbody>
            </table>
        `;
            cartSummary.append(summary);

            $('#subtotal_modal').text(res.data.subtotal);
            updateSummary(); // ✅ Now works
        } catch (error) {
            console.error('Error fetching cart items:', error);
        }
    }

    $(function() {
        // Initial run
        updateSummary();

        // Update when shipping changes
        $(document).on('change', 'input[name="radioDefault"]', updateSummary);
    });


    async function confirmOrder() {
    try {
        let name = $('input[name="name"]').val();
        let phone = $('input[name="phone"]').val();
        let address = $('input[name="address"]').val();
        let shipping = parseFloat($('input[name="radioDefault"]:checked').val()) || 0;
        let subtotal = parseFloat($('#subtotal_modal').text().replace(/,/g, '').trim()) || 0;
        let total = subtotal + shipping;

        // ✅ Correct FormData creation
        let formData = new FormData();
        formData.append('name', name);
        formData.append('phone', phone);
        formData.append('address', address);
        formData.append('shipping', shipping);
        formData.append('subtotal', subtotal);
        formData.append('total', total);

        let response = await axios.post('/invoice-create', formData);
        
        if (response.data.success) {
            alert('অর্ডার সফলভাবে কনফার্ম হয়েছে!');
            $('#checkoutModal').modal('hide');
            //redirect url /cart
            window.location.href = '/cart';
        } else {
            alert('অর্ডার কনফার্ম করতে সমস্যা হয়েছে।');
        }
    } catch (error) {
        console.error('Error confirming order:', error);
        alert('অর্ডার কনফার্ম করতে সমস্যা হয়েছে।');
    }
}

</script>
