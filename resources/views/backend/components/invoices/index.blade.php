<div class="page-wrapper">
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
                    <li class="breadcrumb-item active" aria-current="page">Invoice Table</li>
                </ol>
            </nav>
        </div>
        
    </div>
    <!--end breadcrumb-->
    <h6 class="mb-0 text-uppercase fs-6">Invoice List</h6>
    <hr>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5">
                    <table class="table table-responsive" id="tableData">
                    <thead>
                        <tr class="bg-light">
                            <th>No</th>
                            <th>Name & Phone</th>
                            <th>Payable</th>
                            <th>Earn</th>
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
@push('script')
    <script>

getList();


async function getList() {
    // showLoader();

    try {
        let res = await axios.get("/invoice-select");
        // hideLoader();

        // console.log(res);

        let role = res.data.role; // Access the role directly
        let tableList = $("#tableList");
        let tableData = $("#tableData");

        // Reset DataTable
        tableData.DataTable().destroy();
        tableList.empty();

        // Populate the table
        res.data.data.forEach(function (item) {
            let row = `
                <tr>
                    <td style="vertical-align:middle; text-align:center;">${item['invoice'].id}</td>
                    <td>${item['invoice'].name} <br> ${item['invoice'].phone}<br> ${item['invoice'].address}</td>
                    <td style="vertical-align:middle;">${item['invoice'].subtotal}</td>
                    <td style="vertical-align:middle;">${((item['invoice'].subtotal || 0) - (item['totalBuyPrice'] || 0)).toFixed(2)}</td>

                    <td style="vertical-align:middle;">
                        <button data-id="${item['invoice'].id}" class="viewBtn btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0">
                            <i class="fa text-sm fa-eye"></i>
                        </button>
                        <a href="#" class="btn btn-outline-success text-sm px-3 py-1 btn-sm m-0">
                            <i class="fa text-sm fa-pen"></i>
                        </a>
                        <button data-id="${item['invoice'].id}" class="completeBtn btn btn-outline-primary text-sm px-3 py-1 btn-sm m-0"><i class="fa text-sm  fa-check"></i></button>

                        <button data-id="${item['invoice'].id}" class="deleteBtn btn btn-outline-danger text-sm px-3 py-1 btn-sm m-0">
                            <i class="fa text-sm fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>`;
            tableList.append(row);
        });

        

    } catch (error) {
        // hideLoader();
        console.error(error);
        alert("An error occurred while fetching data. Please try again later.");
    }



    $('.viewBtn').on('click', async function () {
        let id= $(this).data('id');
        await InvoiceDetails(id)
    })

    $('.deleteBtn').on('click',function () {
        let id= $(this).data('id');
        document.getElementById('deleteID').value=id;
        $("#delete-modal").modal('show');
    })
    $('.completeBtn').on('click',function () {
        let id= $(this).data('id');
        document.getElementById('completeID').value=id;
        $("#complete-modal").modal('show');
    })

    new DataTable('#tableData',{
        order:[[0,'desc']],
        lengthMenu:[10,20,30,50,100,500]
    });

}


</script>
@endpush
