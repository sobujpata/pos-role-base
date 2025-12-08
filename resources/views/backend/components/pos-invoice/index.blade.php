<div class="page-wrapper">
    <div class="page-content">
        <!-- start-content -->
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Invoice Tables</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">POS Invoice</li>
                    </ol>
                </nav>
            </div>
            <div class="ms-auto">
                <div class="btn-group">
                    <a href="{{ url('/point-of-sales') }}" class="float-end btn m-0 bg-primary text-white">Create Sale</a>
                </div>
            </div>
        </div>
        <!--end breadcrumb-->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="card px-md-2 py-4">
                    <div class="row justify-content-between ">
                        <div class="align-items-center col">
                            <h5>Invoices</h5>
                        </div>
                        <div class="align-items-center col">
                            
                        </div>
                    </div>
                    <hr class="bg-dark " />
                    <table class="table table-responsive px-md-2" id="tableData">
                        <thead>
                            <tr class="bg-light">
                                <th class="text-center">No</th>
                                <th>Shop keeper Name</th>
                                <th>Payable</th>
                                <th>Earn</th>
                                <th>Sales Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="tableList">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- end-content -->
    </div>
</div>
<script>
    getList();
    async function getList() {
        try {
            let res = await axios.get("/pos-invoice-select");

            // console.log(res);

            let role = res.data.role; // Access the role directly
            let tableList = $("#tableList");
            let tableData = $("#tableData");

            // Reset DataTable
            tableData.DataTable().destroy();
            tableList.empty();

            // Populate the table
            res.data.data.forEach(function(item) {
                function formatDate(date) {
                    // return new Intl.DateTimeFormat('bn-BD').format(new Date(date));
                    return new Intl.DateTimeFormat('en-GB').format(new Date(date));
                }

                // console.log(formatDate(new Date()));
                let row = `
                <tr>
                    <td class="text-center">${item['invoice'].id}</td>
                    <td>${item['invoice'].user.name}</td>
                    <td>${item['invoice'].payable}</td>
                    <td>${((item['invoice'].payable || 0) - (item['totalBuyPrice'] || 0)).toFixed(2)}</td>
                    <td>${formatDate(item['invoice'].created_at)}</td>

                    <td>
                        <button data-id="${item['invoice'].id}" data-user_id="${item['invoice'].user_id}" class="viewBtn btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0">
                            <i class="fa text-sm fa-eye"></i>
                        </button>
                        <a href="/invoice-edit-page/${item['invoice'].id}" class="btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0">
                            <i class="fa text-sm fa-pen"></i>
                        </a>
                        <button data-id="${item['invoice'].id}" class="completeBtn btn btn-outline-primary text-sm px-3 py-1 btn-sm m-0"><i class="fa text-sm  fa-check"></i></button>

                        <button data-id="${item['invoice'].id}" class="deleteBtn btn btn-outline-dark text-sm px-3 py-1 btn-sm m-0">
                            <i class="fa text-sm fa-trash-alt"></i>
                        </button>
                    </td>
                </tr>`;
                tableList.append(row);
            });

        } catch (error) {
            console.error(error);
            alert("An error occurred while fetching data. Please try again later.");
        }

        $('.viewBtn').on('click', async function() {
            let inv_id = $(this).data('id');
            let user_id = $(this).data('id');
            console.log(inv_id);
            await InvoiceDetails(inv_id, user_id)
        })

        $('.deleteBtn').on('click', function() {
            let id = $(this).data('id');
            document.getElementById('deleteID').value = id;
            $("#delete-modal").modal('show');
        })
        $('.completeBtn').on('click', function() {
            let id = $(this).data('id');
            document.getElementById('completeID').value = id;
            $("#complete-modal").modal('show');
        })

        new DataTable('#tableData', {
            order: [
                [0, 'desc']
            ],
            lengthMenu: [20, 30, 50, 100, 500]
        });

    }
</script>
