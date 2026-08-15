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
        <!-- start-content -->
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Tables</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Product Table</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        
        <hr>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5">
                                <table class="table" id="productTable">
                                    <thead>
                                        <tr class="bg-light">
                                            <th class="text-center">Name</th>
                                            <th class="text-center">
                                                Orig Price<br>Dis Price
                                            </th>
                                            <th class="text-center">Ex Qty</th>
                                            <th class="text-center">Add</th>
                                        </tr>
                                    </thead>
                                    <tbody id="productsList">

                                    </tbody>
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
                            <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5">
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
                                    <tbody id="tableList">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end-content -->
            </div>
        </div>

    </div>
</div>
<script>
    getList();
    async function getList() {
        // showLoader();
        let resProducts = await axios.get("/list-products");


        console.log(resProducts);
        let res = await axios.get("/import-product-all");
        // hideLoader();
        // console.log(res);
        let productsList = $("#productsList");
        let productTable = $("#productTable");        

        productTable.DataTable().destroy();
        productsList.empty();

        resProducts.data.forEach(function(item, index){
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
                    class="btn addBtn btn-sm btn-outline-primary"><i class="fa text-sm  fa-plus"></i></button>
                </td>
            </tr>
            `
            productsList.append(row);
        });

        $(document).off('click', '.addBtn').on('click', '.addBtn', async function() {
            let id = $(this).data('id');
            let name = $(this).data('name');            // ✅ fixed: was data('title')
            let original_price = $(this).data('original_price');
            let price = $(this).data('price');
            let discount = $(this).data('discount');
            let discount_price = $(this).data('discount_price');

            console.log(id);
            await FillUpaddForm(id, name, original_price, price, discount, discount_price);
            $("#add-product-modal").modal('show');
        });

        let tableList = $("#tableList");
        let tableData = $("#tableData");

        tableData.DataTable().destroy();
        tableList.empty();

        res.data.data.forEach(function(item, index) {
            let row = `<tr>
                    <td style="vertical-align: middle;">${item['product']['title']}<br>${item['product']['sku']}</td>
                    <td style="vertical-align: middle; text-align: center;">${item['import_price']}</td>
                    <td style="vertical-align: middle; text-align: center;">${item['sale_price']}</td>
                    <td style="vertical-align: middle; text-align: center;">${item['product']['discount_price']}</td>
                    <td style="vertical-align: middle; text-align: center;">${item['quantity']}</td>
                    <td style="vertical-align: middle; text-align: center;">
                        <button data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success"><i class="fa text-sm  fa-pen"></i></button>
                        <button data-id="${item['id']}" class="btn deleteBtn btn-sm btn-outline-danger"><i class="fa text-sm  fa-trash-alt"></i></button>
                    </td>
                 </tr>`
            tableList.append(row)
        })

        $('.editBtn').on('click', async function() {
            let id = $(this).data('id');
            await FillUpUpdateForm(id)
            $("#update-modal").modal('show');
        })

        $('.deleteBtn').on('click', function() {
            let id = $(this).data('id');
            $("#delete-modal").modal('show');
            $("#deleteID").val(id);
        })

        new DataTable('#productTable', {
            // order:[[0,'desc']],
            lengthMenu: [10, 20, 50, 100, 500]
        });
        new DataTable('#tableData', {
            // order:[[0,'desc']],
            lengthMenu: [10, 20, 50, 100, 500]
        });

    }
</script>
