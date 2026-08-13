<!-- Modal -->
<div class="modal animated zoomIn" id="details-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Invoice</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div id="invoice" class="modal-body px-2 pt-2 bg-white">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="row">
                                 <div class="col-12 text-center">
                                     <span class="text-center text-bold fs-3 fw-bold" style="">Auto Reckshaw and Electrical Parts</span><br>
                                     <span class="text-center fs-6 fw-bold" style="">Domdoma Bazzar, Ullapara, Sirajganj</span><br>
                                     <span class="text-center" style="font-size:11px;">
                                        Mobile: 01739871705, email: mdsalimrezaspi@gmail.com
                                    </span>
                                 </div>
                            </div>
                        </div>
                        <div class="col-6 text-left">Date : <span id="invCreateDt"></span></div>
                        <div class="col-6" style="text-align: right;">
                            Inv No: <span id="InvoiceId" class="fw-bold"></span>
                        </div>
                        <hr class="mx-0 my-2 p-0 bg-secondary"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table class="table w-100" id="invoiceTable">
                            <thead class="w-100">
                            <tr class="text-xs text-bold">
                                <td class="text-center">S/L</td>
                                <td>Product Name</td>
                                <td>Quantity</td>
                                <td>Rate</td>
                                <td>Taka</td>
                            </tr>
                            </thead>
                            <tbody  class="w-100" id="invoiceList">

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <p class="text-bold text-xs my-1 text-dark text-end"> Total Payable: </i> <span id="total"></span>/= </p>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row footer">
                    <div class="col-6 text-center">Accounter</div>
                    <div class="col-6 text-left">
                        <span id="user_name"></span>
                        Provider
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn bg-primary" data-bs-dismiss="modal">Close</button>
                <button onclick="PrintPage()" class="btn bg-success">Print</button>
            </div>
        </div>
    </div>
</div>
    <style>
    .invoice {        
        overflow: hidden;
    }
  </style>

<script>
    async function InvoiceDetails(inv_id, user_id) {
        console.log(inv_id)
        // showLoader()
        let res=await axios.post("/pos-invoice-details",{inv_id:inv_id, user_id:user_id})
        // hideLoader();
        console.log(res);
        const createdAt = res.data['invoice']['created_at'];

        const formattedDate = new Date(createdAt).toLocaleString('en-GB', {
            timeZone: 'Asia/Dhaka',
            year: 'numeric',
            month: '2-digit',
            day: '2-digit',
        }); // '2024-10-10'

        document.getElementById('invCreateDt').innerText = formattedDate;
    
        document.getElementById('total').innerText =parseFloat(res.data['invoice']['total']).toFixed(2);
        
        document.getElementById('InvoiceId').innerText=res.data['invoice']['id']
        let total = parseFloat(document.getElementById('total').innerText) || 0;
        let invoiceList=$('#invoiceList');
        invoiceList.empty();
        res.data['product'].forEach(function (item,index) {
            let row=`<tr class="text-xs">
                        <td class="text-center">${index+1}</td>
                        <td>${item['product']['title']}</td>
                        <td>${item['qty']}</td>
                        <td>${item['rate']}</td>
                        <td>${item['sale_price']}</td>
                     </tr>`
            invoiceList.append(row)
        });
        $("#details-modal").modal('show')
    }
    function PrintPage() {
        let printContents = document.getElementById('invoice').innerHTML;
        let originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        setTimeout(function() {
            location.reload();
        }, 1000);
    }
</script>
