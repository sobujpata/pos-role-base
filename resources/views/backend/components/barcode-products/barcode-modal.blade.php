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
    <button class="btn btn-success" onclick="printBarcode()">Print</button>
</div>

<script>
function printBarcode() {
    let content = document.getElementById('print-area').innerHTML;
    let win = window.open('', '', 'width=400,height=400');

    win.document.write(`
        <html>
        <head>
            <title>Print Barcode</title>
            <style>
                body { text-align:center; font-family: Arial }
                img { max-width:100% }
            </style>
        </head>
        <body>${content}</body>
        </html>
    `);

    win.document.close();
    win.focus();
    win.print();
    win.close();
}
</script>
