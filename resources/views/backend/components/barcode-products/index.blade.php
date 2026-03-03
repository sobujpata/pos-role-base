<style>
    input {
        border: 2px solid #a9fac4 !important;
    }

    select {
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

                <h6 class="mb-3 text-uppercase">Product Barcode List</h6>

                <div class="table-responsive">
                    <table class="table table-bordered" id="tableData">
                        <thead class="bg-light">
                            <tr>
                                <th>Image</th>
                                <th>Name & SKU</th>
                                <th>Price</th>
                                <th>Stock</th>
                                <th width="80">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products ?? [] as $product)
                                <tr>
                                    <td>
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" width="70">
                                        @else
                                            <span class="text-muted">No image</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $product->title }} <br>
                                        <small>{{ $product->sku }}</small>
                                    </td>
                                    <td>{{ $product->discount_price }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-outline-success"
                                            onclick="openBarcode({{ $product->id }})">
                                            <i class="fa fa-barcode"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="barcode-modal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" id="barcodeModalContent">
                    <!-- AJAX content -->
                </div>
            </div>
        </div>


        <script>
            axios.defaults.headers.common['X-CSRF-TOKEN'] =
                document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            function openBarcode(id) {
                axios.get(`/product-barcode-view/${id}`)
                    .then(res => {
                        document.getElementById('barcodeModalContent').innerHTML = res.data;
                        new bootstrap.Modal('#barcode-modal').show();
                    })
                    .catch(err => {
                        alert('Failed to load barcode');
                        console.error(err);
                    });
            }
        </script>

    </div>
</div>
