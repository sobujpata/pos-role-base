<div class="modal animated zoomIn" id="update-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Product</h5>
            </div>
            <div class="modal-body">
                <form id="update-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <label class="form-label">Update Import Products</label>
                                <select class="form-control form-select" id="productIdUpdate">
                                    <option value="" disabled selected>Select Products</option>
                                </select>

                                <label class="form-label mt-3">Import Price</label>
                                <input type="number" class="form-control" id="importPriceUpdate">

                                <label class="form-label mt-3">Price</label>
                                <input type="number" class="form-control" id="salePriceUpdate">

                                <label class="form-label mt-3">Dis %</label>
                                <input type="number" class="form-control" id="discountPercentUpdate">

                                <label class="form-label mt-3">Discount Price</label>
                                <input type="number" class="form-control" id="discountPriceUpdate">

                                <label class="form-label mt-3">Quantity</label>
                                <input type="number" class="form-control" id="productQtyUpdate"
                                    placeholder="New Product Quantity">

                                <input type="number" class="form-control" id="productIdShow" hidden>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-primary mx-2" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="update()" id="update-btn" class="btn bg-success">Update</button>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    async function FillUpUpdateForm(id) {
        document.getElementById('productIdShow').value = id;

        let resImportProduct = await axios.post("/import-product-by-id", { id: id });
        let data = resImportProduct.data.data;

        $('#productIdUpdate').val(data.product_id);
        $('#importPriceUpdate').val(data.import_price);
        $('#salePriceUpdate').val(data.sale_price);
        $('#discountPercentUpdate').val(data.product.discount);
        $('#discountPriceUpdate').val(data.product.discount_price);
        $('#productQtyUpdate').val(data.quantity);
    }

    loadProducts();
    async function loadProducts() {
        let res = await axios.get("/list-products");
        res.data.forEach(function (item) {
            $("#productIdUpdate").append(`<option value="${item['id']}">${item['title']}</option>`);
        });

        $('#productIdUpdate').on('change', function () {
            let productIdUpdate = $(this).val();
            if (productIdUpdate) {
                loadProductDetailsUpdate(productIdUpdate);
            }
        });
    }

    async function loadProductDetailsUpdate(productIdUpdate) {
        try {
            let res = await axios.get(`/import-product-list/${productIdUpdate}`);
            let data = res.data.data;
            $('#importPriceUpdate').val(data.original_price ?? '');
            $('#salePriceUpdate').val(data.price ?? '');
            $('#discountPercentUpdate').val(data.discount ?? '');
            $('#discountPriceUpdate').val(data.discount_price ?? '');
        } catch (error) {
            console.error(error);
            errorToast('Failed to load product details!');
        }
    }

    async function update() {
        const productIdUpdate = $('#productIdUpdate').val();
        const importPrice = $('#importPriceUpdate').val();
        const salePrice = $('#salePriceUpdate').val();
        const discountPercent = $('#discountPercentUpdate').val();
        const discountPrice = $('#discountPriceUpdate').val();
        const quantity = $('#productQtyUpdate').val();
        const importId = $('#productIdShow').val();

        if (!productIdUpdate) return flasher.error('Product required!');
        if (!salePrice || isNaN(salePrice)) return flasher.error('Valid sale price required!');
        if (!quantity || isNaN(quantity) || quantity <= 0)
            return flasher.error('Valid quantity required!');

        const formData = new FormData();
        formData.append('id', importId);
        formData.append('product_id', productIdUpdate);
        formData.append('import_price', importPrice);
        formData.append('sale_price', salePrice);
        formData.append('discount', discountPercent);
        formData.append('discount_price', discountPrice);
        formData.append('quantity', quantity);

        try {
            const res = await axios.post('/import-product-update', formData);

            if (res.status === 200) {
                flasher.success(res.data.message ?? 'Product import updated successfully!');
                $('#update-modal').modal('hide');

                // ✅ Defensive check: make sure getList exists globally before calling it.
                if (typeof window.getList === 'function') {
                    await window.getList();
                } else {
                    console.error(
                        "getList() is not defined on window — table will not refresh. " +
                        "Make sure getList is declared as `window.getList = async function () {...}` " +
                        "in the product-table script, not scoped inside a local closure."
                    );
                }
            }
        } catch (error) {
            if (error.response) {
                flasher.error(error.response.data.message ?? 'Request failed!');
            } else {
                flasher.error('Server not responding');
            }
        }
    }
</script>
<script>
    function calculateDiscount() {
        let price = parseFloat(document.getElementById("salePriceUpdate").value) || 0;
        let percent = parseFloat(document.getElementById("discountPercentUpdate").value) || 0;

        let discountAmount = price * (percent / 100);
        let finalPrice = price - discountAmount;

        document.getElementById("discountPriceUpdate").value = finalPrice.toFixed(2);
    }

    document.getElementById("salePriceUpdate").addEventListener("input", calculateDiscount);
    document.getElementById("discountPercentUpdate").addEventListener("input", calculateDiscount);
</script>
@endpush