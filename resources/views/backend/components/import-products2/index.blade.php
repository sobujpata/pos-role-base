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
                        <li class="breadcrumb-item active" aria-current="page">Product Table</li>
                    </ol>
                </nav>
            </div>
            @can('product-create')
                <div class="ms-auto">
                    <div class="btn-group">
                        <button data-bs-toggle="modal" data-bs-target="#create-modal"
                            class="float-end btn m-0  btn-primary">Import Product</button>
                    </div>
                </div>
            @endcan
        </div>
        <!--end breadcrumb-->
        <h6 class="mb-0 text-uppercase">Product List</h6>
        <hr>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5">
                        <table class="table" id="tableData">
                            <thead>
                                <tr class="bg-light">
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Name</th>
                                    <th class="text-center">Import Price</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Discount Price</th>
                                    <th class="text-center">Quantity</th>
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
<script>
    getList();


    async function getList() {
        // showLoader();
        let res = await axios.get("/import-product-all");
        // hideLoader();
        // console.log(res);
        let tableList = $("#tableList");
        let tableData = $("#tableData");

        tableData.DataTable().destroy();
        tableList.empty();

        res.data.data.forEach(function(item, index) {
            let imgUrl = item['product']['image'];
            let row = `<tr>
                    <td><img style="width: 90px; height: 100px;" alt="" src="storage/${imgUrl}"></td>
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

        $('.deleteBtn').on('click', function () {
            let id = $(this).data('id');
            $("#delete-modal").modal('show');
            $("#deleteID").val(id);
        })

        new DataTable('#tableData', {
            // order:[[0,'desc']],
            lengthMenu: [10, 20, 50, 100, 500]
        });

    }
</script>
