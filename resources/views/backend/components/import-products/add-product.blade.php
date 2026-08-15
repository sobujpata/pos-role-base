<div class="modal animated zoomIn" id="add-product-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabelAdd">Create Product</h5>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">

                                <label class="form-label">Products</label>
                                <select type="text" class="form-control form-select" id="productId">
                                    <option value="" disabled selected>Select Products</option>
                                </select>

                                <label class="form-label mt-3">Import Price</label>
                                <input type="number" class="form-control" id="importPrice">

                                <label class="form-label mt-3">Price</label>
                                <input type="number" class="form-control" id="salePrice">

                                <label class="form-label mt-3">Dis %</label>
                                <input type="number" class="form-control" id="discountPercent">

                                <label class="form-label mt-3">Discount Price</label>
                                <input type="number" class="form-control" id="discountPrice">

                                <label class="form-label mt-3">Quantity</label>
                                <input type="number" class="form-control" id="productQty"
                                    placeholder="New Product Quantity">

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-primary mx-2" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-success">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    FillProducts();

    // ---------------------------------------------------
    // Populate the product <select> dropdown in the modal
    // ---------------------------------------------------
    async function FillProducts() {
        let res = await axios.get("/list-products");
        res.data.forEach(function(item, i) {
            let option = `<option value="${item['id']}">${item['title']}</option>`;
            $("#productId").append(option);
        });

        // When user selects a product from the dropdown
        $('#productId').on('change', function() {
            let productId = $(this).val();
            if (productId) {
                loadProductDetails(productId);
            }
        });
    }

    // ---------------------------------------------------
    // Fetch selected product's pricing details and fill form
    // ---------------------------------------------------
    async function loadProductDetails(productId) {
        try {
            let res = await axios.get(`/import-product-list/${productId}`);
            let data = res.data.data;

            $('#importPrice').val(data.original_price ?? '');
            $('#salePrice').val(data.price ?? '');
            $('#discountPercent').val(data.discount ?? '');
            $('#discountPrice').val(data.discount_price ?? '');
            // $('#productQty').val(data.buy_qty ?? '');
        } catch (error) {
            console.error(error);
            flasher.error('Failed to load product details!');
        }
    }

    // ---------------------------------------------------
    // Pre-fill the modal form when "+" button is clicked
    // on a row from the products list table
    // ---------------------------------------------------
    async function FillUpaddForm(id, name, original_price, price, discount, discount_price) {
        $('#productId').val(id).trigger('change'); // select the product in dropdown
        $('#importPrice').val(original_price ?? '');
        $('#salePrice').val(price ?? '');
        $('#discountPercent').val(discount ?? '');
        $('#discountPrice').val(discount_price ?? '');
        $('#productQty').val('');
    }

    // ---------------------------------------------------
    // Save the import/product entry
    // ---------------------------------------------------
    async function Save() {
        let productId = $('#productId').val();
        let importPrice = $('#importPrice').val();
        let salePrice = $('#salePrice').val();
        let discountPercent = $('#discountPercent').val();
        let discountPrice = $('#discountPrice').val();
        let productQty = $('#productQty').val();

        if (!productId) {
            return flasher.error("Product Required!");
        } else if (!salePrice) {
            return flasher.error("Sale Price Required!");
        } else if (!productQty) {
            return flasher.error("Quantity Required!");
        }

        $('#modal-close').click();

        let formData = new FormData();
        formData.append('import_price', importPrice);
        formData.append('sale_price', salePrice);
        formData.append('quantity', productQty);
        formData.append('product_id', productId);
        formData.append('discount', discountPercent);
        formData.append('discount_price', discountPrice);

        const config = {
            headers: {
                'content-type': 'multipart/form-data'
            }
        };

        let res = await axios.post("/import-product", formData, config);
        console.log(res);
        if (res.status === 201) {
            flasher.success('Product import successfully!');
            $("#save-form")[0].reset();
            await getList();
        } else {
            flasher.error("Request failed!");
        }
    }
</script>

<script>
    // ---------------------------------------------------
    // Auto-calculate discount price when sale price
    // or discount percent changes
    // ---------------------------------------------------
    function calculateDiscount() {
        let price = parseFloat(document.getElementById("salePrice").value) || 0;
        let percent = parseFloat(document.getElementById("discountPercent").value) || 0;

        let discountAmount = price * (percent / 100);
        let finalPrice = price - discountAmount;

        document.getElementById("discountPrice").value = finalPrice.toFixed(2);
    }

    document.getElementById("salePrice").addEventListener("input", calculateDiscount);
    document.getElementById("discountPercent").addEventListener("input", calculateDiscount);
</script>

