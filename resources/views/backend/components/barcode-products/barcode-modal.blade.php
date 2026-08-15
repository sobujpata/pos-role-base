<div class="modal-header">
    <h5 class="modal-title">Barcode Generate</h5>
    <button class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body text-center" id="print-area">
    <div class="fw-bold">Saidul Varaitis Shop</div>

    <div class="mt-1">
        {{ $product->title }}
    </div>

    <img class="mt-2"
         src="{{ $barcode }}"
         alt="Barcode">
</div>

<div class="modal-footer">
    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-success print-barcode-btn" data-print-barcode="{{ $product->id }}">Print</button>
</div>

<script>
    window.PrintBarcodeLabel = function (productId) {
        const content = document.getElementById('print-area').innerHTML;
        const win = window.open('', '_blank', 'width=400,height=400');

        if (!win) {
            alert('Popup blocked. Please allow popups and try again.');
            return;
        }

        win.document.write(
            '<html><head><title>Print Barcode</title>' +
            '<style>body { text-align:center; font-family: Arial; } img { max-width:100%; } </style>' +
            '</head><body>' + content + '</body></html>'
        );

        win.document.close();
        win.focus();
        win.print();
        setTimeout(function () {
            win.close();
        }, 500);
    };

    document.addEventListener('click', function (event) {
        const button = event.target.closest('.print-barcode-btn');
        if (!button) return;

        const productId = button.dataset.printBarcode;
        if (productId) {
            window.PrintBarcodeLabel(productId);
        }
    });
</script>
