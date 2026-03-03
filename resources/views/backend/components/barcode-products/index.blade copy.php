<style>
    input{
        border: 2px solid #a9fac4 !important;
    }
    select{
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
                        <li class="breadcrumb-item active" aria-current="page">Product Barcode Generate Table</li>
                    </ol>
                </nav>
            </div>
            
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">Product Barcode List</h6>
        <hr>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <table class="table" id="tableData">
                            <thead>
                                <tr class="bg-light">
                                    <th>Image</th>
                                    <th>Name & SKU</th>
                                    <th>Sale Price</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
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
<script>
    getList();


    async function getList() {
        // showLoader();
        let res = await axios.get("/list-products");
        // hideLoader();
        // console.log(res);
        let tableList = $("#tableList");
        let tableData = $("#tableData");

        tableData.DataTable().destroy();
        tableList.empty();

        res.data.forEach(function(item, index) {
            let imgUrl = item['image'];
            let row = `<tr>
                    <td><img style="width: 90px; height: 100px;" alt="" src="storage/${imgUrl}"></td>
                    <td>${item['title']}<br>${item['sku']}</td>
                    <td>${item['discount_price']}</td>
                    <td>${item['stock']}</td>
                    <td>
                        <button data-id="${item['id']}" class="btn editBtn btn-sm btn-outline-success"><i class="fa text-sm  fa-eye"></i></button>
                    </td>
                 </tr>`
            tableList.append(row)
        })

        $('.editBtn').on('click', async function() {
            let id = $(this).data('id');
            await FillUpBarcodeForm(id)
            $("#barcode-modal").modal('show');
        })

       
        new DataTable('#tableData', {
            // order:[[0,'desc']],
            lengthMenu: [10, 20, 50, 100, 500]
        });

    }
</script>
