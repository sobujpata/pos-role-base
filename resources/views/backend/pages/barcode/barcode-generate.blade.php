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
                <div id="barcodePrint{{ $product->id }}"
                    style="
                    width: 38mm;
                    height: 25mm;
                    padding: 1.2mm;
                    font-family: Arial, Helvetica, sans-serif;
                    box-sizing: border-box;
                    overflow: hidden;
                    color: #000;
                ">

                    <!-- Brand / Company -->
                    <div style="text-align:center; font-size:7px; font-weight:bold;">
                        SAIDUL E&E PARTS
                    </div>

                    <!-- Product Model -->
                    <div style="text-align:center; font-size:6px; margin-bottom:0.5mm;">
                        {{ Str::limit($product->title ?? 'Save Chula T6000', 22) }}
                    </div>

                    <!-- Barcode -->
                    <div style="text-align:center; margin:0.5mm 0;">
                        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($product->sku ?? 'A2566988', 'C128', 1.15, 18) }}"
                            style="width:100%; height:8mm; border-radius: 0;" alt="barcode">
                    </div>

                    <!-- Codes Row -->
                    <div style="font-size:6px; display:flex; justify-content:space-between;">
                        <span>{{ $product->sku ?? 'A2566988' }}</span>
                        <span>SL-{{ $product->id }}</span>
                        {{-- <span>P11280</span> --}}
                    </div>

                    <!-- Prices -->
                    <div style="font-size:6px; margin-top:0.5mm;">
                        MRP: {{ number_format($product->price ?? 7000, 3) }}
                    </div>
                    <div style="font-size:6px; font-weight:bold;">
                        Discount Price: {{ number_format($product->discount_price ?? 000, 3) }}
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success print-barcode-btn" onclick="PrintPage()">
                    <i class="fas fa-print"></i> Print
                </button>

            </div>

        </div>
    </div>
</div>
<script>
    function PrintPage() {
        let printContents = document.getElementById('barcodePrint{{ $product->id }}').innerHTML;
        let originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        setTimeout(function() {
            location.reload();
        }, 1000);
    }
</script>
