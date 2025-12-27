<div class="modal animated zoomIn" id="barcode-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><U>Barcode Generate</U></h5>
            </div>
            <div class="modal-body">
                <form id="barcode-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1 text-transform-uppercase text-center font-weight-bold">
                                Saidul Varaitis Shop
                            </div>
                            <div class="col-12 p-1 text-center">
                                <span id="productTitle" class="font-weight-bold"></span>
                            </div>
                            <div class="col-12 p-1 text-center">
                                <img id="barcodeImageBarcode" src="" alt="Barcode Image">
                            </div>
                        </div>
                        <input type="number" class="form-control" id="productIdShow" hidden>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-primary mx-2" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
                <button onclick="print()" id="barcode-btn" class="btn bg-success">Print</button>
            </div>
        </div>
    </div>
</div>


<script>
async function FillUpBarcodeForm(id) {
    try {
        document.getElementById('productIdShow').value = id;

        let res = await axios.post("/barcode-generate-by-id", { id });

        if (res.data.status !== 'success') {
            alert(res.data.message);
            return;
        }

        let data = res.data.data;
        console.log(data);

        document.getElementById('productTitle').innerText = data.title;
        document.getElementById('barcodeImageBarcode').src = data.barcode;

        // Show modal if not already shown
        let modal = new bootstrap.Modal(document.getElementById('barcode-modal'));
        modal.show();

    } catch (error) {
        console.error(error);
        alert('Failed to generate barcode');
    }
}
</script>
