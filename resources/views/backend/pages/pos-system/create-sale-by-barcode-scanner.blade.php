@extends('backend.layouts.app')
@section('title', 'POS System - Barcode Scanner')
@section('content')
    <style>
        /* POS Custom Styles */
        .pos-container {
            font-size: 14px;
        }

        .scanner-input {
            font-family: monospace;
            font-size: 1.2rem;
            letter-spacing: 2px;
        }

        .product-card {
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .product-image-container {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border-radius: 0.375rem;
            overflow: hidden;
        }

        .product-image {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }

        .cart-item-name {
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .total-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: #198754;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .dropdown-search-container {
            position: relative;
        }

        .dropdown-search-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 1000;
            max-height: 300px;
            overflow-y: auto;
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            display: none;
        }

        .dropdown-search-item {
            padding: 10px;
            border-bottom: 1px solid #f8f9fa;
            cursor: pointer;
        }

        .dropdown-search-item:hover {
            background-color: #f8f9fa;
        }

        .out-of-stock {
            color: #dc3545;
        }

        .low-stock {
            color: #ffc107;
        }

        .in-stock {
            color: #28a745;
        }

        .product-search-highlight {
            background-color: yellow;
            font-weight: bold;
        }

        .quantity-input {
            max-width: 60px;
        }

        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        /* Scan feedback panel (replaces the old confirm-quantity popup for scans) */
        .scan-preview {
            border-left: 4px solid transparent;
            background: #f8f9fa;
            transition: background-color 0.2s, border-color 0.2s;
        }

        .scan-preview.success {
            border-left-color: #198754;
            background: #f0fdf4;
        }

        .scan-preview.error {
            border-left-color: #dc3545;
            background: #fef2f2;
        }

        /* Momentary highlight on the cart row that was just added/updated */
        @keyframes cartRowFlash {
            0% {
                background-color: #d1e7dd;
            }

            100% {
                background-color: transparent;
            }
        }

        .cart-item-flash {
            animation: cartRowFlash 1s ease-out;
        }

        @media (max-width: 768px) {
            .pos-container {
                font-size: 12px;
            }

            .cart-item-name {
                max-width: 100px;
            }
        }
    </style>

    <div class="page-wrapper app-container">
        <div class="page-content">
            <!-- Breadcrumb -->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">POS System</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Barcode Scanner POS</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="container-fluid pos-container">
                <div class="row g-3 mb-4">
                    <!-- Left Column: Product Search and Selection -->
                    <div class="col-lg-8">
                        <!-- Search Card -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-search me-2"></i>Product Search
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <!-- Barcode Scanner Input -->
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="fas fa-barcode me-1"></i>Barcode Scanner
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light">
                                                <i class="fas fa-qrcode"></i>
                                            </span>
                                            <input type="text" id="barcodeInput"
                                                class="form-control form-control-lg scanner-input"
                                                placeholder="Scan barcode..." autocomplete="off" autofocus>
                                        </div>
                                        <small class="text-muted">Scan to add 1 unit straight to the cart</small>

                                        <!-- Instant scan feedback (no modal / no interruption) -->
                                        <div id="scanPreview" class="scan-preview mt-2 p-2 rounded d-none">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <i id="scanPreviewIcon" class="fas fa-check-circle me-2 text-success"></i>
                                                    <div>
                                                        <div id="scanPreviewName" class="fw-medium"></div>
                                                        <div id="scanPreviewStatus" class="small text-muted"></div>
                                                    </div>
                                                </div>
                                                <div id="scanPreviewPrice" class="fw-bold text-primary"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Manual Search -->
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="fas fa-keyboard me-1"></i>Manual Search
                                        </label>
                                        <div class="dropdown-search-container">
                                            <div class="input-group">
                                                <span class="input-group-text bg-light">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                                <input type="text" id="productSearch" class="form-control form-control-lg"
                                                    placeholder="Type product name or barcode..." autocomplete="off">
                                                <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <!-- Dropdown Search Results -->
                                            <div id="searchResults" class="dropdown-search-results mt-1"></div>
                                        </div>
                                        <small class="text-muted">Type 2+ characters to search products</small>
                                    </div>

                                    <!-- Category Filter -->
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="fas fa-filter me-1"></i>Filter by Category
                                        </label>
                                        <select id="categoryFilter" class="form-select">
                                            <option value="">All Categories</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ $category->name ?? $category->categoryName }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Stock Filter -->
                                    <div class="col-md-6">
                                        <label class="form-label">
                                            <i class="fas fa-box me-1"></i>Stock Filter
                                        </label>
                                        <select id="stockFilter" class="form-select">
                                            <option value="all">All Products</option>
                                            <option value="in_stock">In Stock Only</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Products Grid -->
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-boxes me-2"></i>Products
                                </h5>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-light text-dark me-2" id="productCount">0 products</span>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="showImages">
                                        <label class="form-check-label" for="showImages">Show Images</label>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="productsGrid" class="row g-3">
                                    <!-- Products will be loaded here -->
                                </div>
                                <div id="productsLoading" class="text-center py-5">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                    <p class="mt-2 text-muted">Loading products...</p>
                                </div>
                                <div id="noProducts" class="text-center py-5" style="display: none;">
                                    <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No products found</h5>
                                    <p class="text-muted">Try adjusting your search or filters</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Shopping Cart -->
                    <div class="col-lg-4">
                        <!-- Cart Card -->
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-shopping-cart me-2"></i>Shopping Cart
                                    <span id="cartCountBadge" class="badge bg-primary ms-2">0</span>
                                </h5>
                                <div class="d-flex">
                                    <button class="btn btn-sm btn-outline-danger me-2" id="clearCartBtn" title="Clear Cart">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary" id="printReceiptBtn"
                                        title="Print Receipt">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body p-0 d-flex flex-column">
                                <!-- Cart Items -->
                                <div class="table-responsive flex-grow-1">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th width="5%"></th>
                                                <th width="40%">Product</th>
                                                <th width="40%">Price & Quantity</th>
                                                <th width="10%">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="cartTable">
                                            <!-- Cart items will be loaded here -->
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Empty Cart Message -->
                                <div id="emptyCart" class="text-center py-5">
                                    <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Cart is empty</h5>
                                    <p class="text-muted">Add products by scanning or searching</p>
                                </div>

                                <!-- Cart Summary -->
                                <div id="cartSummary" class="p-3 border-top" style="display: none;">
                                    <div class="row g-2 mb-2">
                                        <div class="col-6 text-muted">Subtotal:</div>
                                        <div class="col-6 text-end" id="cartSubtotal">৳0.00</div>
                                    </div>
                                    <div class="row g-2 mb-2">
                                        <div class="col-6 text-muted">Tax (0%):</div>
                                        <div class="col-6 text-end" id="cartTax">৳0.00</div>
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-6">
                                            <strong>Total:</strong>
                                        </div>
                                        <div class="col-6 text-end">
                                            <div class="total-amount" id="cartTotal">৳0.00</div>
                                        </div>
                                    </div>

                                    <!-- Cart Actions -->
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary btn-lg" id="checkoutBtn">
                                            <i class="fas fa-credit-card me-2"></i>Process Payment
                                        </button>
                                        <button class="btn btn-outline-secondary" id="holdCartBtn">
                                            <i class="fas fa-pause me-2"></i>Hold Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        {{-- <div class="card mt-3 mb-4">
                            <div class="card-body">
                                <h6 class="card-title mb-3">
                                    <i class="fas fa-bolt me-2"></i>Quick Actions
                                </h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <button class="btn btn-outline-primary w-100" id="quickSaleBtn">
                                            <i class="fas fa-bolt me-1"></i>Quick Sale
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-outline-success w-100" id="applyDiscountBtn">
                                            <i class="fas fa-percent me-1"></i>Discount
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-outline-warning w-100" id="returnBtn">
                                            <i class="fas fa-exchange-alt me-1"></i>Return
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button class="btn btn-outline-info w-100" id="loadCartBtn">
                                            <i class="fas fa-history me-1"></i>Load Cart
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>

            <!-- Checkout Modal -->
            <div class="modal fade" id="checkoutModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fas fa-credit-card me-2"></i>Process Payment
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Checkout form will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Receipt Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-body receipt" id="receiptContent">
                <!-- Receipt will be generated here -->
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>

                <button type="button" class="btn btn-primary" onclick="printReceipt()">
                    <i class="fas fa-print me-1"></i>Print
                </button>
            </div>

        </div>
    </div>
</div>


<style>
    /* Receipt preview */
    .receipt {
        /* width: 58mm; */
        margin: 0 auto;
        padding: 1mm;
        font-family: Arial, sans-serif;
        font-size: 10px;
        color: #000;
        background: #fff;
        margin-left: 5px;
        margin-right: 5px;
    }

    /* Print settings */
    @media print {

        @page {
            size: 58mm auto;
            margin: 0;
        }

        html,
        body {
            width: 58mm;
            margin: 0;
            padding: 0;
            background: #fff;
        }

        /* Hide everything */
        body * {
            visibility: hidden;
        }

        /* Show only receipt */
        #receiptContent,
        #receiptContent * {
            visibility: visible;
        }

        #receiptContent {
            position: absolute;
            left: 0;
            top: 0;
            width: 58mm;
            margin: 0;
            padding: 2mm;
            box-sizing: border-box;
        }

        /* Hide modal buttons/footer */
        .modal-footer {
            display: none !important;
        }

        /* Remove modal styling */
        .modal,
        .modal-dialog,
        .modal-content,
        .modal-body {
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            box-shadow: none !important;
            width: 58mm !important;
            max-width: 58mm !important;
        }
    }
</style>


<script>
    function printReceipt() {
        window.print();
    }
</script>

            <!-- Quantity Modal -->
            <div class="modal fade" id="quantityModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Enter Quantity</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" id="quantityInput" class="form-control form-control-lg text-center"
                                    value="1" min="1" max="999" autofocus>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Sale Price</label>
                                <input type="number" id="salePriceInput" class="form-control form-control-lg text-center">
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" id="confirmQuantityBtn">Add to Cart</button>
                                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    {{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script> --}}
    <script>
        // POS System Configuration
        const POS_CONFIG = {
            api: {
                base: '{{ url("/") }}',
                'pos-products': '/pos-products',
                'pos-cart': '/pos-cart',
                cart: '/cart'
            },
            settings: {
                minSearchChars: 2,
                debounceDelay: 300,
                taxRate: 0.10,
                currency: '৳',
                maxQuantity: 999
            },
            sounds: {
                scan: 'https://assets.mixkit.co/sfx/preview/mixkit-correct-answer-tone-2870.mp3',
                error: 'https://assets.mixkit.co/sfx/preview/mixkit-wrong-answer-fail-notification-946.mp3',
                add: 'https://assets.mixkit.co/sfx/preview/mixkit-cash-register-purchase-876.mp3'
            }
        };

        // POS System Class
        class POSSystem {
            constructor() {
                this.currentProduct = null;
                this.searchTimeout = null;
                this.scanTimeout = null;
                this.scanPreviewHideTimeout = null;
                this.lastScan = { barcode: null, time: 0 };
                this.cartData = null;
                this.init();
            }

            init() {
                this.loadCartCount();
                this.loadProducts();
                this.attachEvents();
                this.setupSearch();
                this.keepBarcodeFocus();
                this.loadCart();
            }

            attachEvents() {
                // Barcode scanner input
                $("#barcodeInput").on("input", (e) => this.handleBarcodeInput(e.target.value));
                $("#barcodeInput").on("keypress", (e) => {
                    if (e.key === "Enter") {
                        e.preventDefault();
                        clearTimeout(this.scanTimeout); // cancel the pending idle-debounce so it doesn't fire twice
                        const value = $("#barcodeInput").val();
                        $("#barcodeInput").val("");
                        this.handleBarcodeScan(value);
                    }
                });

                // Manual search
                $("#productSearch").on("input", (e) => this.handleManualSearch(e.target.value));
                $("#clearSearch").on("click", () => {
                    $("#productSearch").val("").focus();
                    $("#searchResults").hide();
                });

                // Filters
                $("#categoryFilter, #stockFilter").on("change", () => this.loadProducts());

                // Cart actions
                $("#clearCartBtn").on("click", () => this.clearCart());
                $("#checkoutBtn").on("click", () => this.showCheckoutModal());
                $("#printReceiptBtn").on("click", () => this.printReceipt());

                // Quick actions
                $("#quickSaleBtn").on("click", () => this.quickSale());
                $("#applyDiscountBtn").on("click", () => this.applyDiscount());
                $("#returnBtn").on("click", () => this.processReturn());
                $("#loadCartBtn").on("click", () => this.loadSavedCarts());
                $("#holdCartBtn").on("click", () => this.holdCart());

                // Show images toggle
                $("#showImages").on("change", (e) => {
                    localStorage.setItem("posShowImages", e.target.checked);
                    this.loadProducts();
                });

                // Quantity modal
                $("#confirmQuantityBtn").on("click", () => this.addProductWithQuantity());
                $("#quantityInput").on("keypress", (e) => {
                    if (e.key === "Enter") this.addProductWithQuantity();
                });

                // Close dropdown when clicking outside
                $(document).on("click", (e) => {
                    if (!$(e.target).closest(".dropdown-search-container").length) {
                        $("#searchResults").hide();
                    }
                });

                // Keyboard shortcuts
                $(document).on("keydown", (e) => {
                    if (e.ctrlKey && e.key === "f") {
                        e.preventDefault();
                        $("#productSearch").focus();
                    }
                    if (e.key === "F2") {
                        e.preventDefault();
                        this.clearCart();
                    }
                    if (e.key === "F3") {
                        e.preventDefault();
                        this.showCheckoutModal();
                    }
                    if (e.key === "F5") {
                        e.preventDefault();
                        this.loadProducts();
                    }
                    if (e.key === "Escape") {
                        $("#searchResults").hide();
                    }
                });
            }

            setupSearch() {
                const showImages = localStorage.getItem("posShowImages") === "true";
                $("#showImages").prop("checked", showImages);
            }

            keepBarcodeFocus() {
                $(document).on("click", (e) => {
                    if (!$(e.target).closest("#barcodeInput, .modal").length) {
                        setTimeout(() => $("#barcodeInput").focus(), 100);
                    }
                });
            }

            handleBarcodeInput(value) {
                clearTimeout(this.scanTimeout);
                this.scanTimeout = setTimeout(() => {
                    if (value.length >= 3) {
                        this.handleBarcodeScan(value);
                        $("#barcodeInput").val("");
                    }
                }, 500);
            }

            async handleBarcodeScan(barcode) {
                const code = barcode.trim();
                if (!code) return;

                // Guard against scanners/keyboards that emit the same code twice in quick succession
                const now = Date.now();
                if (code === this.lastScan.barcode && now - this.lastScan.time < 800) return;
                this.lastScan = { barcode: code, time: now };

                try {
                    const response = await axios.get(`/pos-products/by-barcode/${encodeURIComponent(code)}`);
                    if (!(response.data.success && response.data.product)) {
                        this.showScanPreview(null, "error", `No product for barcode "${code}"`);
                        this.showToast("Product not found", "error");
                        this.playSound("error");
                        return;
                    }

                    const product = response.data.product;
                    this.playSound("scan");

                    const stock = product.stock ?? 0;
                    const alreadyInCart = this.cartData?.items?.find((i) => i.id === product.id)?.quantity || 0;

                    if (stock <= 0 || alreadyInCart + 1 > stock) {
                        this.showScanPreview(product, "error", stock <= 0 ? "Out of stock" : `Only ${stock} in stock`);
                        this.showToast(`${product.title || product.name}: insufficient stock`, "error");
                        this.playSound("error");
                        return;
                    }

                    // Straight to the cart: no confirm-quantity modal in the scan flow
                    const salePrice = parseFloat(product.discount_price) > 0
                        ? parseFloat(product.discount_price)
                        : parseFloat(product.price || 0);

                    const added = await this.addToCart(product, 1, salePrice, { silent: true });
                    if (added) {
                        this.showScanPreview(
                            product,
                            "success",
                            alreadyInCart > 0 ? `Now ${alreadyInCart + 1} in cart` : "Added to cart"
                        );
                    }
                } catch (error) {
                    console.error("Barcode scan error:", error);
                    this.showScanPreview(null, "error", "Error scanning product");
                    this.showToast("Error scanning product", "error");
                    this.playSound("error");
                }
            }

            /** Small inline panel that gives instant scan feedback since scanning no longer opens a modal. */
            showScanPreview(product, status, message) {
                clearTimeout(this.scanPreviewHideTimeout);
                const panel = $("#scanPreview");
                panel.removeClass("d-none success error").addClass(status);
                $("#scanPreviewIcon").attr(
                    "class",
                    status === "success" ? "fas fa-check-circle me-2 text-success" : "fas fa-exclamation-circle me-2 text-danger"
                );
                $("#scanPreviewName").text(product ? (product.title || product.name) : "Unknown barcode");
                $("#scanPreviewStatus").text(message);
                $("#scanPreviewPrice").text(product ? this.formatCurrency(product.discount_price > 0 ? product.discount_price : product.price) : "");
                this.scanPreviewHideTimeout = setTimeout(() => panel.addClass("d-none"), 2500);
            }

            handleManualSearch(searchTerm) {
                clearTimeout(this.searchTimeout);
                if (searchTerm.length < POS_CONFIG.settings.minSearchChars) {
                    $("#searchResults").hide();
                    return;
                }
                this.searchTimeout = setTimeout(() => {
                    this.searchProducts(searchTerm);
                }, POS_CONFIG.settings.debounceDelay);
            }

            async searchProducts(searchTerm) {
                try {
                    const params = { search: searchTerm };
                    const category = $("#categoryFilter").val();
                    const inStock = $("#stockFilter").val() === "in_stock";
                    if (category) params.category = category;
                    if (inStock) params.in_stock = true;

                    const response = await axios.get('/pos-products/search', { params });
                    if (response.data.success && response.data.products.length > 0) {
                        this.showSearchResults(response.data.products, searchTerm);
                    } else {
                        $("#searchResults").hide();
                    }
                } catch (error) {
                    console.error("Search error:", error);
                    $("#searchResults").hide();
                }
            }

            showSearchResults(products, searchTerm) {
                const resultsDiv = $("#searchResults");
                let html = "";
                products.forEach((product) => {
                    const highlightedName = this.highlightText(product.title || product.name, searchTerm);
                    const stockClass = product.stock <= 0 ? "out-of-stock" : "in-stock";
                    html += `
                        <div class="dropdown-search-item" data-product='${JSON.stringify(product).replace(/'/g, "&#39;")}'>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="flex-grow-1">
                                    <div class="fw-medium">${highlightedName}</div>
                                    <div class="small text-muted">
                                        <span class="me-2">${product.sku || 'N/A'}</span>
                                        <span class="${stockClass}">
                                            <i class="fas fa-box me-1"></i>${product.stock || 0} ${product.unit || 'pcs'}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold text-primary">${POS_CONFIG.settings.currency}${parseFloat(product.price || 0).toFixed(2)}</div>
                                    <div class="fw-bold text-primary">${POS_CONFIG.settings.currency}${parseFloat(product.discount_price || 0).toFixed(2)}</div>
                                    <button class="btn btn-sm btn-outline-primary mt-1 add-from-search">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>`;
                });
                resultsDiv.html(html).show();

                $(".dropdown-search-item").on("click", (e) => {
                    if (!$(e.target).hasClass("add-from-search")) {
                        const productData = $(e.currentTarget).data('product');
                        if (productData) this.selectProduct(productData);
                    }
                });

                $(".add-from-search").on("click", (e) => {
                    e.stopPropagation();
                    const productData = $(e.target).closest(".dropdown-search-item").data('product');
                    if (productData) this.selectProduct(productData);
                });
            }

            highlightText(text, search) {
                if (!search || !text) return text;
                const regex = new RegExp(`(${search.replace(/[.*+?^${}()|[\]\\]/g, "\\$&")})`, "gi");
                return text.replace(regex, '<span class="product-search-highlight">$1</span>');
            }

            selectProduct(product) {
                this.currentProduct = product;
                $("#productSearch").val("").focus();
                $("#searchResults").hide();
                this.showQuantityModal(product);
            }

            showQuantityModal(product) {
                this.currentProduct = product;
                $("#quantityModal .modal-title").text(`Add ${product.title || product.name}`);
                const maxQty = Math.min(POS_CONFIG.settings.maxQuantity, product.stock || 999);
                $("#quantityInput").val(1).attr("max", maxQty).focus().select();
                $("#salePriceInput").val(product.discount_price);

                $("#quantityModal").modal("show");
            }

            async addProductWithQuantity() {
                if (!this.currentProduct) return;

                const quantity = parseInt($("#quantityInput").val(), 10);
                const salePrice = parseFloat($("#salePriceInput").val());

                if (isNaN(quantity) || quantity < 1) {
                    this.showToast("Invalid quantity", "error");
                    return;
                }

                if (quantity > (this.currentProduct.stock ?? 0)) {
                    this.showToast(`Only ${this.currentProduct.stock ?? 0} items in stock`, "error");
                    return;
                }

                if (isNaN(salePrice) || salePrice <= 0) {
                    this.showToast("Invalid sale price", "error");
                    return;
                }

                const success = await this.addToCart(this.currentProduct, quantity, salePrice);
                if (success) {
                    $("#quantityModal").modal("hide");
                    this.currentProduct = null;
                }
            }

            /**
             * Single source of truth for adding a product to the cart.
             * Used by the barcode-scan quick-add flow and the manual quantity-modal flow,
             * so the API call, error handling, and post-add UI feedback live in one place.
             */
            async addToCart(product, quantity, salePrice, { silent = false } = {}) {
                try {
                    const response = await axios.post('/pos-cart/add', {
                        product_id: product.id,
                        quantity: quantity,
                        salePrice: salePrice,
                    });

                    if (response.data.success) {
                        await this.loadCart();
                        this.playSound("add");
                        this.flashCartRow(product.id);
                        if (!silent) {
                            this.showToast(`Added ${quantity} × ${product.title || product.name}`, "success");
                        }
                        return true;
                    }

                    this.showToast(response.data.message || "Failed to add to cart", "error");
                    this.playSound("error");
                    return false;
                } catch (error) {
                    console.error("Add to cart error:", error);
                    const message =
                        error.response?.data?.message ||
                        error.response?.data?.errors?.salePrice?.[0] ||
                        "Error adding to cart";
                    this.showToast(message, "error");
                    this.playSound("error");
                    return false;
                }
            }

            /** Briefly highlight the cart row for a product after it's added/updated. */
            flashCartRow(productId) {
                const row = $(`.cart-item[data-product-id="${productId}"]`);
                if (!row.length) return;
                row.addClass("cart-item-flash");
                setTimeout(() => row.removeClass("cart-item-flash"), 1000);
            }

            /** Centralised currency formatting so amount strings stay consistent across the UI. */
            formatCurrency(value) {
                return `${POS_CONFIG.settings.currency}${parseFloat(value || 0).toFixed(2)}`;
            }


            async loadProducts() {
                try {
                    $("#productsGrid").hide();
                    $("#productsLoading").show();
                    $("#noProducts").hide();
                    const params = {};
                    const category = $("#categoryFilter").val();
                    const inStock = $("#stockFilter").val() === "in_stock";
                    if (category) params.category = category;
                    if (inStock) params.in_stock = true;
                    const response = await axios.get('/pos-products/search', { params });
                    // console.log(response)
                    if (response.data.success) {
                        this.renderProducts(response.data.products, $("#showImages").is(":checked"));
                        $("#productCount").text(`${response.data.count} products`);
                        if (response.data.count === 0) {
                            $("#noProducts").show();
                        }
                    }
                } catch (error) {
                    console.error("Load products error:", error);
                    this.showToast("Error loading products", "error");
                } finally {
                    $("#productsLoading").hide();
                    $("#productsGrid").show();
                }
            }

            renderProducts(products, showImages) {
                const grid = $("#productsGrid");
                let html = "";
                products.forEach((product) => {
                    let imageUrl = product.image || null;
                    // console.log(imageUrl);
                    const stockClass = product.stock <= 0 ? "out-of-stock" : "in-stock";
                    const stockBadge = product.stock <= 0
                        ? '<span class="badge bg-danger">Out of Stock</span>'
                        : '<span class="badge bg-success">In Stock</span>';
                    html += `
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="card product-card h-100 cursor-pointer" data-product='${JSON.stringify(product).replace(/'/g, "&#39;")}'>
                                <div class="card-body">
                                    <div class="d-flex align-items-start mb-2">
                                        ${showImages && imageUrl
                                        ? `<img src="${product.image}" class="product-image me-2" alt="${product.title || product.name}" style="width: 60px; height: 60px; object-fit: cover;">`
                                        : '<div class="product-image me-2 bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;"><i class="fas fa-box text-muted"></i></div>'}
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-1">${product.title || product.name}</h6>
                                            <div class="small text-muted mb-2">${product.sku || 'N/A'}</div>
                                            ${stockBadge}
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div>
                                            <div class="fw-bold text-secondary text-decoration-line-through fs-5">${POS_CONFIG.settings.currency}${parseFloat(product.price || 0).toFixed(2)}</div>
                                            <div class="fw-bold text-primary fs-5">${POS_CONFIG.settings.currency}${parseFloat(product.discount_price || 0).toFixed(2)}</div>
                                            <div class="small ${stockClass}">
                                                <i class="fas fa-box me-1"></i>${product.stock || 0} ${product.unit || 'pcs'}
                                            </div>
                                        </div>
                                        <button class="btn btn-primary add-product-btn">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                });
                grid.html(html);
                $(".product-card").on("click", (e) => {
                    if (!$(e.target).hasClass("add-product-btn")) {
                        const productData = $(e.currentTarget).data('product');
                        if (productData) this.selectProduct(productData);
                    }
                });
                $(".add-product-btn").on("click", (e) => {
                    e.stopPropagation();
                    const productData = $(e.target).closest(".product-card").data('product');
                    if (productData) this.selectProduct(productData);
                });
            }

            async loadCart() {
                try {
                    const response = await axios.get('/pos-cart');
                    // console.log(response)
                    if (response.data.success) {
                        this.cartData = response.data;
                        this.renderCart(response.data);
                        $("#cartCountBadge").text(response.data.summary.total_items || 0);
                    } else {
                        console.error("Cart API returned error:", response.data.message);
                        this.cartData = { items: [], summary: { subtotal: 0, tax: 0, total: 0, total_items: 0, item_count: 0 } };
                        this.renderCart(this.cartData);
                    }
                } catch (error) {
                    console.error("Load cart error:", error);
                    this.cartData = { items: [], summary: { subtotal: 0, tax: 0, total: 0, total_items: 0, item_count: 0 } };
                    this.renderCart(this.cartData);
                    $("#cartCountBadge").text("0");
                }
            }

            renderCart(cartData) {
                const table = $("#cartTable");
                const emptyCart = $("#emptyCart");
                const cartSummary = $("#cartSummary");
                if (cartData.items.length === 0) {
                    table.html("");
                    emptyCart.show();
                    cartSummary.hide();
                    return;
                }
                emptyCart.hide();
                cartSummary.show();
                let html = "";
                cartData.items.forEach((item) => {
                    html += `
                        <tr class="cart-item align-middle" data-product-id="${item.id}">
                            <td><button class="btn btn-sm btn-outline-danger remove-item-btn"><i class="fas fa-times"></i></button></td>
                            <td><div class="fw-medium cart-item-name">${item.title || item.name}</div><div class="small text-muted">${item.sku || 'N/A'}</div></td>
                            <td>
                                ${POS_CONFIG.settings.currency}${parseFloat(item.price || 0).toFixed(2)}
                                <div class="input-group input-group-sm">
                                    <button class="btn btn-outline-secondary qty-decrease">-</button>
                                    <input type="number" class="form-control text-center quantity-input" value="${item.quantity}" min="1" max="${item.stock || 999}" data-product-id="${item.id}">
                                    <button class="btn btn-outline-secondary qty-increase">+</button>
                                </div>
                            </td>
                            <td class="fw-bold">${POS_CONFIG.settings.currency}${parseFloat(item.total || 0).toFixed(2)}</td>
                        </tr>`;
                });
                table.html(html);
                $("#cartSubtotal").text(`${POS_CONFIG.settings.currency}${parseFloat(cartData.summary.subtotal || 0).toFixed(2)}`);
                $("#cartTax").text(`${POS_CONFIG.settings.currency}${parseFloat(cartData.summary.tax || 0).toFixed(2)}`);
                $("#cartTotal").text(`${POS_CONFIG.settings.currency}${parseFloat(cartData.summary.total || 0).toFixed(2)}`);
                this.attachCartEvents();
            }

            attachCartEvents() {
                $(".remove-item-btn").on("click", async (e) => {
                    const productId = $(e.target).closest(".cart-item").data("product-id");
                    await this.removeFromCart(productId);
                });
                $(".qty-decrease").on("click", async (e) => {
                    const input = $(e.target).closest(".input-group").find(".quantity-input");
                    const productId = input.data("product-id");
                    let qty = parseInt(input.val()) - 1;
                    if (qty >= 1) await this.updateCartQuantity(productId, qty);
                });
                $(".qty-increase").on("click", async (e) => {
                    const input = $(e.target).closest(".input-group").find(".quantity-input");
                    const productId = input.data("product-id");
                    let qty = parseInt(input.val()) + 1;
                    await this.updateCartQuantity(productId, qty);
                });
                $(".quantity-input").on("change", async (e) => {
                    const input = $(e.target);
                    const productId = input.data("product-id");
                    const qty = parseInt(input.val());
                    if (qty >= 1) await this.updateCartQuantity(productId, qty);
                });
            }

            async removeFromCart(productId) {
                if (!confirm("Remove this item from cart?")) return;
                try {
                    const response = await axios.delete(`/pos-cart/remove/${productId}`);
                    if (response.data.success) {
                        this.showToast("Item removed from cart", "success");
                        await this.loadCart();
                    } else {
                        this.showToast(response.data.message || "Failed to remove item", "error");
                    }
                } catch (error) {
                    console.error("Remove from cart error:", error);
                    this.showToast("Error removing item", "error");
                }
            }

            async updateCartQuantity(productId, quantity) {
                try {
                    const response = await axios.put('/pos-cart/update', {
                        product_id: productId,
                        quantity: quantity,
                    });
                    if (response.data.success) {
                        await this.loadCart();
                    } else {
                        this.showToast(response.data.message || "Failed to update quantity", "error");
                    }
                } catch (error) {
                    console.error("Update quantity error:", error);
                    this.showToast("Error updating quantity", "error");
                }
            }

            async clearCart() {
                if (!this.cartData || this.cartData.items.length === 0) return;
                if (!confirm("Clear all items from cart?")) return;
                try {
                    const response = await axios.delete('/pos-cart/clear');
                    if (response.data.success) {
                        this.showToast("Cart cleared", "success");
                        await this.loadCart();
                    } else {
                        this.showToast(response.data.message || "Failed to clear cart", "error");
                    }
                } catch (error) {
                    console.error("Clear cart error:", error);
                    this.showToast("Error clearing cart", "error");
                }
            }

            async loadCartCount() {
                try {
                    const response = await axios.get('/pos-cart/count');
                    if (response.data.success) {
                        $("#cartCountBadge").text(response.data.total_items || 0);
                    }
                } catch (error) {
                    console.error("Load cart count error:", error);
                }
            }

            showCheckoutModal() {
                if (!this.cartData || this.cartData.items.length === 0) {
                    this.showToast("Cart is empty", "error");
                    return;
                }
                const modal = $("#checkoutModal");
                const modalBody = modal.find(".modal-body");
                let html = `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header"><h6 class="mb-0">Order Summary</h6></div>
                                <div class="card-body">
                                    <div class="mb-2 d-flex justify-content-between"><span>Subtotal:</span><span>${POS_CONFIG.settings.currency}${parseFloat(this.cartData.summary.subtotal || 0).toFixed(2)}</span></div>
                                    <div class="mb-2 d-flex justify-content-between"><span>Tax (10%):</span><span>${POS_CONFIG.settings.currency}${parseFloat(this.cartData.summary.tax || 0).toFixed(2)}</span></div>
                                    <hr><div class="d-flex justify-content-between fw-bold fs-5"><span>Total:</span><span class="text-primary">${POS_CONFIG.settings.currency}${parseFloat(this.cartData.summary.total || 0).toFixed(2)}</span></div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header"><h6 class="mb-0">Payment Method</h6></div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        <div class="col-6"><button class="btn btn-outline-primary w-100 payment-method active" data-method="cash"><i class="fas fa-money-bill-wave me-2"></i>Cash</button></div>
                                        <div class="col-6"><button class="btn btn-outline-primary w-100 payment-method" data-method="card"><i class="fas fa-credit-card me-2"></i>Card</button></div>
                                        <div class="col-6"><button class="btn btn-outline-primary w-100 payment-method" data-method="upi"><i class="fas fa-mobile-alt me-2"></i>UPI</button></div>
                                        <div class="col-6"><button class="btn btn-outline-primary w-100 payment-method" data-method="wallet"><i class="fas fa-wallet me-2"></i>Wallet</button></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header"><h6 class="mb-0">Payment Details</h6></div>
                                <div class="card-body">
                                    <div class="mb-3"><label class="form-label">Amount Paid</label><input type="number" id="amountPaid" class="form-control form-control-lg" value="${parseFloat(this.cartData.summary.total || 0).toFixed(2)}" step="0.01" min="0" autofocus></div>
                                    <div class="mb-3" id="changeAmountContainer" style="display: none;"><label class="form-label">Change</label><input type="text" id="changeAmount" class="form-control form-control-lg text-success fw-bold" readonly></div>
                                    <div class="mb-3"><label class="form-label">Customer (Optional)</label><input type="text" id="customerName" class="form-control" placeholder="Customer name"></div>
                                    <div class="mb-3"><label class="form-label">Notes (Optional)</label><textarea id="paymentNotes" class="form-control" rows="2" placeholder="Any notes..."></textarea></div>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-success btn-lg" id="completePaymentBtn"><i class="fas fa-check-circle me-2"></i>Complete Payment</button>
                                        <button class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                modalBody.html(html);
                modal.modal("show");
                $(".payment-method").on("click", function () {
                    $(".payment-method").removeClass("active");
                    $(this).addClass("active");
                });
                $("#amountPaid").on("input", () => {
                    const total = this.cartData.summary.total;
                    const paid = parseFloat($("#amountPaid").val()) || 0;
                    const change = paid - total;
                    if (change >= 0) {
                        $("#changeAmount").val(`${POS_CONFIG.settings.currency}${change.toFixed(2)}`);
                        $("#changeAmountContainer").show();
                    } else {
                        $("#changeAmountContainer").hide();
                    }
                });
                $("#completePaymentBtn").on("click", async () => {
                    await this.processPayment();
                });
            }

            async processPayment() {
                const paymentMethod = ($(".payment-method.active").data("method") || "cash").trim();
                const amountPaid = parseFloat($("#amountPaid").val()) || 0;
                const customerName = ($("#customerName").val() || "").trim();
                const notes = ($("#paymentNotes").val() || "").trim();
                const total = parseFloat(this.cartData.summary.subtotal || 0).toFixed(2);
                const discount = (parseFloat(this.cartData.summary.discount || 0)).toFixed(2);
                const vat = parseFloat(this.cartData.summary.tax || 0).toFixed(2);
                const payable = parseFloat(this.cartData.summary.total || 0).toFixed(2);
                let InvoiceItemList = [];
                this.cartData.items.forEach((item) => {
                    InvoiceItemList.push({
                        product_id: item.id,
                        name: item.title || item.name,
                        sku: item.sku || '',
                        qty: item.quantity,
                        rate: parseFloat(item.price || 0).toFixed(2),
                        sale_price: parseFloat(item.total || 0).toFixed(2),                        
                    });
                });

                if (amountPaid < this.cartData.summary.total) {
                    this.showToast("Amount paid is less than total", "error");
                    return;
                }
                try {
                    // Simulate payment processing
                    await new Promise(resolve => setTimeout(resolve, 1000));
                    this.generateReceipt({
                        paymentMethod,
                        amountPaid,
                        customerName,
                        notes,
                        change: amountPaid - this.cartData.summary.total,
                    });
                    let Data = {
                        "total": total,
                        "discount": discount,
                        "vat": vat,
                        "payable": payable,
                        "paymentMethod":paymentMethod,
                        "customerName":customerName,
                        "notes":notes,
                        "products": InvoiceItemList
                    }
                    // console.log(Data)

                    if (InvoiceItemList.length === 0) {
                        // console.log("Product Required !")
                        this.showToast("Product Required !", "error");
                    } else {
                        let res = await axios.post("/pos-invoice-create", Data)
                        // console.log(res);
                        if (res.data === 1) {
                            await this.clearCart();
                            this.showToast("Payment completed successfully!", "success");
                            this.playSound("scan");
                            $("#checkoutModal").modal("hide");
                            // window.location.href = '/invoicePage'
                        } else {
                            this.showToast("Something Went Wrong", "error");
                        }
                    }
                    
                } catch (error) {
                    this.showToast("Error processing payment", "error");
                }
            }

            generateReceipt(paymentInfo) {                
                const receipt = $("#receiptContent");
                const now = new Date();
                const receiptNumber = "REC-" + Date.now().toString().slice(-8);
                let itemsHtml = "";
                this.cartData.items.forEach((item) => {
                    itemsHtml += `${item.title || item.name}\n${item.quantity} × ${POS_CONFIG.settings.currency}${parseFloat(item.price || 0).toFixed(2)} = ${POS_CONFIG.settings.currency}${parseFloat(item.total || 0).toFixed(2)}\n`;
                });
                const html = `
                    <div class="text-center mb-3">
                        <h5 class="fw-bold" id="shopName"></h5>
                        <p class="mb-1" id="shopAddress"></p>
                        <p class="mb-1">Phone: <span id="shopPhone"></span></p>
                        
                    </div>
                    <hr><div class="mb-2">
                        <div class="d-flex justify-content-between"><span>Receipt #:</span><span>${receiptNumber}</span></div>
                        <div class="d-flex justify-content-between"><span>Date:</span><span>${now.toLocaleDateString()}</span></div>
                        <div class="d-flex justify-content-between"><span>Time:</span><span>${now.toLocaleTimeString()}</span></div>
                        ${paymentInfo.customerName ? `<div class="d-flex justify-content-between"><span>Customer:</span><span>${paymentInfo.customerName}</span></div>` : ""}
                    </div><hr><pre class="mb-2" style="font-family: inherit;">${itemsHtml}</pre><hr>
                    <div class="mb-2">
                        <div class="d-flex justify-content-between"><span>Subtotal:</span><span>${POS_CONFIG.settings.currency}${parseFloat(this.cartData.summary.subtotal || 0).toFixed(2)}</span></div>
                        <div class="d-flex justify-content-between"><span>Tax (10%):</span><span>${POS_CONFIG.settings.currency}${parseFloat(this.cartData.summary.tax || 0).toFixed(2)}</span></div>
                        <div class="d-flex justify-content-between fw-bold"><span>Total:</span><span>${POS_CONFIG.settings.currency}${parseFloat(this.cartData.summary.total || 0).toFixed(2)}</span></div>
                    </div><hr>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between"><span>Payment Method:</span><span>${paymentInfo.paymentMethod.toUpperCase()}</span></div>
                        <div class="d-flex justify-content-between"><span>Amount Paid:</span><span>${POS_CONFIG.settings.currency}${paymentInfo.amountPaid.toFixed(2)}</span></div>
                        <div class="d-flex justify-content-between"><span>Change:</span><span>${POS_CONFIG.settings.currency}${paymentInfo.change.toFixed(2)}</span></div>
                    </div><hr>
                    <div class="text-center"><p class="mb-1">Thank you for your purchase!</p><p class="mb-1">*** Goods once sold cannot be returned ***</p><p class="mb-0">Visit Again!</p></div>`;
                receipt.html(html);
                $("#receiptModal").modal("show");
                getSiteDetails()
            }

            printReceipt() {
                if (!this.cartData || this.cartData.items.length === 0) {
                    this.showToast("Cart is empty", "error");
                    return;
                }
                this.generateReceipt({
                    paymentMethod: "cash",
                    amountPaid: this.cartData.summary.total,
                    customerName: "",
                    notes: "",
                    change: 0,
                });
            }

            quickSale() { this.showToast("Quick sale feature coming soon", "info"); }
            applyDiscount() {
                if (!this.cartData || this.cartData.items.length === 0) {
                    this.showToast("Cart is empty", "error");
                    return;
                }
                const discount = prompt("Enter discount percentage:", "10");
                if (discount && !isNaN(discount)) this.showToast(`Discount of ${discount}% applied`, "success");
            }
            processReturn() { this.showToast("Return feature coming soon", "info"); }
            loadSavedCarts() { this.showToast("Load cart feature coming soon", "info"); }
            holdCart() {
                if (!this.cartData || this.cartData.items.length === 0) {
                    this.showToast("Cart is empty", "error");
                    return;
                }
                const cartName = prompt("Enter a name for this cart:", `Cart ${new Date().toLocaleTimeString()}`);
                if (cartName) {
                    const savedCarts = JSON.parse(localStorage.getItem("savedCarts") || "[]");
                    savedCarts.push({ name: cartName, data: this.cartData, timestamp: new Date().toISOString() });
                    localStorage.setItem("savedCarts", JSON.stringify(savedCarts));
                    this.showToast(`Cart saved as "${cartName}"`, "success");
                    this.clearCart();
                }
            }

            showToast(message, type = "info") {
                const toastId = "toast-" + Date.now();
                const icons = { success: "fas fa-check-circle", error: "fas fa-exclamation-circle", warning: "fas fa-exclamation-triangle", info: "fas fa-info-circle" };
                const toast = $(`<div id="${toastId}" class="toast align-items-center border-0 bg-${type}" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"><div class="d-flex"><div class="toast-body text-white"><i class="${icons[type]} me-2"></i>${message}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button></div></div>`);
                $('body').append(toast);
                const bsToast = new bootstrap.Toast(toast[0]);
                bsToast.show();
                toast.on("hidden.bs.toast", () => toast.remove());
                setTimeout(() => { if ($(`#${toastId}`).length) bsToast.hide(); }, 3000);
            }

            playSound(type) {
                if (POS_CONFIG.sounds[type]) {
                    const audio = new Audio(POS_CONFIG.sounds[type]);
                    audio.play().catch(() => { });
                }
            }
        }

        // Initialize POS System
        $(document).ready(function () {
            window.posSystem = new POSSystem();
            setTimeout(() => $("#barcodeInput").focus(), 500);
        });
    </script>
    <script>
async function getSiteDetails() {
    try {
        const response = await axios.get('/shop-details');

        console.log('Shop Details:', response.data);

        document.getElementById('shopName').innerHTML =
            response.data.shop_name ?? '';

        document.getElementById('shopAddress').innerHTML =
            response.data.shop_address ?? '';

        document.getElementById('shopPhone').innerHTML =
            response.data.shop_phone ?? '';

    } catch (error) {
        console.error('Error loading shop details:', error);
    }
}
</script>
@endpush