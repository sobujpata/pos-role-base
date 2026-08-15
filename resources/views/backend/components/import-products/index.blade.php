<style>
    input {
        border: 2px solid #a9fac4 !important;
    }

    select {
        border: 2px solid #a9fac4 !important;
    }
</style>

<div class="page-wrapper app-container">
    <div class="page-content">
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Tables</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Product Table</li>
                    </ol>
                </nav>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="productTable_container" class="dataTables_wrapper dt-bootstrap5">
                                <table class="table" id="productTable">
                                    <thead>
                                        <tr class="bg-light">
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Orig Price<br>Dis Price</th>
                                            <th class="text-center">Ex Qty</th>
                                            <th class="text-center">Add</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productsList"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h6 class="mb-0 text-uppercase">Imported Product List</h6>
                        <div class="table-responsive">
                            <div id="tableData_container" class="dataTables_wrapper dt-bootstrap5">
                                <table class="table" id="tableData">
                                    <thead>
                                        <tr class="bg-light">
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Import Price</th>
                                            <th class="text-center">Price</th>
                                            <th class="text-center">Dis Price</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableList"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Modal now lives on the SAME page as the table -->
<div class="modal animated zoomIn" id="add-product-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
                                <select class="form-control form-select" id="productId">
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
@push('script')
    <script>
        $(function() {
            // ---------------------------------------------------
            // Main table + imported list loader
            // ---------------------------------------------------
           window.getList = async function getList() {
                let resProducts = await axios.get("/list-products");
                let res = await axios.get("/import-product-all");

                let productsList = $("#productsList");

                if ($.fn.DataTable.isDataTable('#productTable')) {
                    $('#productTable').DataTable().destroy();
                }
                productsList.empty();

                resProducts.data.forEach(function(item) {
                    let row = `
            <tr>
                <td style="vertical-align: middle;">${item['title']}<br>${item['sku']}</td>
                <td style="vertical-align: middle; text-align: center;">${item['original_price']}<br>${item['discount_price']}</td>
                <td style="vertical-align: middle; text-align: center;">${item['stock']}</td>
                <td style="vertical-align: middle; text-align: center;">
                    <button
                        data-id="${item['id']}"
                        data-name="${item['title']}"
                        data-original_price="${item['original_price']}"
                        data-price="${item['price']}"
                        data-discount="${item['discount']}"
                        data-discount_price="${item['discount_price']}"
                        class="btn addBtn btn-sm btn-outline-primary"><i class="fa text-sm fa-plus"></i></button>
                </td>
            </tr>`;
                    productsList.append(row);
                });

                let tableList = $("#tableList");

                if ($.fn.DataTable.isDataTable('#tableData')) {
                    $('#tableData').DataTable().destroy();
                }
                tableList.empty();

                res.data.data.forEach(function(item) {
                    let row = `<tr>
                    <td style="vertical-align: middle;">${item['product']['title']}<br>${item['product']['sku']}</td>
                    <td style="vertical-align: middle; text-align: center;">${item['import_price']}</td>
                    <td style="vertical-align: middle; text-align: center;">${item['sale_price']}</td>
                    <td style="vertical-align: middle; text-align: center;">${item['product']['discount_price']}</td>
                    <td style="vertical-align: middle; text-align: center;">${item['quantity']}</td>
                    <td style="vertical-align: middle; text-align: center;">
                        <button data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success"><i class="fa text-sm fa-pen"></i></button>
                        <button data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger"><i class="fa text-sm fa-trash-alt"></i></button>
                    </td>
                 </tr>`;
                    tableList.append(row);
                });

                new DataTable('#productTable', {
                    lengthMenu: [10, 20, 50, 100, 500]
                });
                new DataTable('#tableData', {
                    lengthMenu: [10, 20, 50, 100, 500]
                });
            }
            getList();
            FillProducts();
            // ---------------------------------------------------
            // Delegated click handlers — bound ONCE, work forever
            // even after getList() re-renders the rows
            // ---------------------------------------------------
            $(document).on('click', '.addBtn', async function() {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let original_price = $(this).data('original_price');
                let price = $(this).data('price');
                let discount = $(this).data('discount');
                let discount_price = $(this).data('discount_price');

                FillUpaddForm(id, name, original_price, price, discount, discount_price);

                // Sanity check — warn loudly in console instead of silently doing nothing
                let modalEl = $("#add-product-modal");
                if (modalEl.length === 0) {
                    console.error(
                        "#add-product-modal not found in the DOM — check that the modal partial is included on this page."
                        );
                    return;
                }
                modalEl.modal('show');
            });

            $(document).on('click', '.editBtn', async function() {
                let id = $(this).data('id');
                await FillUpUpdateForm(id);
                $("#update-modal").modal('show');
            });

            $(document).on('click', '.deleteBtn', function() {
                let id = $(this).data('id');
                $("#delete-modal").modal('show');
                $("#deleteID").val(id);
            });

            // ---------------------------------------------------
            // Populate product dropdown
            // ---------------------------------------------------
            async function FillProducts() {
                let res = await axios.get("/list-products");
                res.data.forEach(function(item) {
                    $("#productId").append(`<option value="${item['id']}">${item['title']}</option>`);
                });
            }


            function FillUpaddForm(id, name, original_price, price, discount, discount_price) {
                $('#productId').val(id); // select in dropdown, but don't trigger a refetch
                $('#importPrice').val(original_price ?? '');
                $('#salePrice').val(price ?? '');
                $('#discountPercent').val(discount ?? '');
                $('#discountPrice').val(discount_price ?? '');
                $('#productQty').val('');
            }

            // ---------------------------------------------------
            // Only used when the user manually changes the dropdown
            // ---------------------------------------------------
            $('#productId').on('change', async function() {
                let productId = $(this).val();
                if (productId) {
                    await loadProductDetails(productId);
                }
            });

            async function loadProductDetails(productId) {
                try {
                    let res = await axios.get(`/import-product-list/${productId}`);
                    let data = res.data.data;
                    $('#importPrice').val(data.original_price ?? '');
                    $('#salePrice').val(data.price ?? '');
                    $('#discountPercent').val(data.discount ?? '');
                    $('#discountPrice').val(data.discount_price ?? '');
                } catch (error) {
                    console.error(error);
                    flasher.error('Failed to load product details!');
                }
            }

            // ---------------------------------------------------
            // Save
            // ---------------------------------------------------
            window.Save = async function() {
                let productId = $('#productId').val();
                let importPrice = $('#importPrice').val();
                let salePrice = $('#salePrice').val();
                let discountPercent = $('#discountPercent').val();
                let discountPrice = $('#discountPrice').val();
                let productQty = $('#productQty').val();

                if (!productId) return flasher.error("Product Required!");
                if (!salePrice) return flasher.error("Sale Price Required!");
                if (!productQty) return flasher.error("Quantity Required!");

                $('#modal-close').click();

                let formData = new FormData();
                formData.append('import_price', importPrice);
                formData.append('sale_price', salePrice);
                formData.append('quantity', productQty);
                formData.append('product_id', productId);
                formData.append('discount', discountPercent);
                formData.append('discount_price', discountPrice);

                let res = await axios.post("/import-product", formData, {
                    headers: {
                        'content-type': 'multipart/form-data'
                    }
                });

                if (res.status === 201) {
                    flasher.success('Product import successfully!');
                    $("#save-form")[0].reset();
                    await getList();
                } else {
                    flasher.error("Request failed!");
                }
            };

            // ---------------------------------------------------
            // Discount auto-calculation
            // ---------------------------------------------------
            function calculateDiscount() {
                let price = parseFloat($("#salePrice").val()) || 0;
                let percent = parseFloat($("#discountPercent").val()) || 0;
                let finalPrice = price - price * (percent / 100);
                $("#discountPrice").val(finalPrice.toFixed(2));
            }
            $("#salePrice, #discountPercent").on("input", calculateDiscount);
        });
    </script>
@endpush
