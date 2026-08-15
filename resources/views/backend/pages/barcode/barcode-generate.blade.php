<!-- Modal -->
<div class="modal fade" id="exampleModal{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" style="max-width: 300px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Barcode Generate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Preview must match the print size exactly: 38mm x 18mm -->
                <div id="barcodePrint{{ $product->id }}"
                    class="barcode-label"
                    style="
                    width: 38mm;
                    height: 18mm;
                    padding: 0.8mm;
                    font-family: Arial, Helvetica, sans-serif;
                    box-sizing: border-box;
                    overflow: hidden;
                    color: #000;
                    display: flex;
                    flex-direction: column;
                    justify-content: flex-start;
                ">

                    <!-- Brand / Company -->
                    <div style="text-align:center; font-size:5px; font-weight:bold; line-height:1.1;">
                        SAIDUL E&E PARTS
                    </div>

                    <!-- Product Model -->
                    <div style="text-align:center; font-size:5px; line-height:1.1; margin-bottom:0.3mm;">
                        {{ Str::limit($product->title ?? 'Save Chula T6000', 20) }}
                    </div>

                    <!-- Barcode -->
                    <div style="text-align:center; margin:0.2mm 0;">
                        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($product->sku ?? 'A2566988', 'C128', 1, 7) }}"
                            style="width:100%; height:6mm; display:block;" alt="barcode">
                    </div>

                    <!-- Codes Row -->
                    <div style="font-size:5px; line-height:1.1; display:flex; justify-content:space-between;">
                        <span>{{ $product->sku ?? 'A2566988' }}</span>
                        <span>SL-{{ $product->id }}</span>
                    </div>

                    <!-- Price (single line to save vertical space on 18mm height) -->
                    <div style="font-size:5px; font-weight:bold; line-height:1.1; text-align:center; margin-top:0.2mm;">
                        MRP: {{ number_format($product->price ?? 7000, 2) }} |
                        Disc: {{ number_format($product->discount_price ?? 0, 2) }}
                    </div>

                </div>

                <p class="text-muted mt-2" style="font-size:11px;">
                    Note: 18mm height is very tight — if any line gets clipped on your printer,
                    remove the "Brand" line or the "Codes Row" below to free up space.
                </p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success print-barcode-btn" data-print-barcode="{{ $product->id }}">
                    <i class="fas fa-print"></i> Print 38x18mm Label
                </button>
            </div>

        </div>
    </div>
</div>

<script>
    // Renamed for clarity + fixed to actually match the 38mm x 18mm label size.
    window.PrintLabel38x18 = function (productId) {
        const target = document.getElementById('barcodePrint' + productId);
        if (!target) return;

        const printContents = target.innerHTML;
        const win = window.open('', '', 'width=200,height=200');

        win.document.write(`
            <html>
            <head>
                <title>Print 38x18mm Barcode Label</title>
                <style>
                    @page { size: 38mm 18mm; margin: 0; }
                    * { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
                    html, body {
                        margin: 0;
                        padding: 0;
                        background: #fff;
                        font-family: Arial, Helvetica, sans-serif;
                        color: #000;
                    }
                    body {
                        width: 38mm;
                        height: 18mm;
                        display: flex;
                        align-items: flex-start;
                        justify-content: center;
                    }
                    #barcodePrintLabel {
                        width: 38mm;
                        height: 18mm;
                        padding: 0.8mm;
                        box-sizing: border-box;
                        display: flex;
                        flex-direction: column;
                        justify-content: flex-start;
                        overflow: hidden;
                        background: #fff;
                    }
                    img {
                        max-width: 100%;
                        height: auto;
                        display: block;
                        margin: 0 auto;
                    }
                </style>
            </head>
            <body><div id="barcodePrintLabel">${printContents}</div></body>
            </html>
        `);

        win.document.close();

        // Give the barcode <img> (base64, so usually instant) a tick to paint before printing.
        win.onload = function () {
            win.focus();
            win.print();
            setTimeout(function () { win.close(); }, 500);
        };
    };

    document.addEventListener('click', function (event) {
        const button = event.target.closest('.print-barcode-btn');
        if (!button) return;

        const productId = button.dataset.printBarcode;
        if (productId) {
            window.PrintLabel38x18(productId);
        }
    });
</script>