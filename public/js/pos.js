// public/js/pos.js
class POSSystem {
    constructor() {
        this.currentProduct = null;
        this.searchTimeout = null;
        this.scanTimeout = null;
        this.lastBarcode = "";
        this.isScanning = false;
        this.cartData = null;

        this.init();
    }

    init() {
        this.loadCartCount();
        this.loadProducts();
        this.attachEvents();
        this.setupSearch();
        this.keepBarcodeFocus();

        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
    }

    attachEvents() {
        // Barcode scanner input
        $("#barcodeInput").on("input", (e) =>
            this.handleBarcodeInput(e.target.value)
        );
        $("#barcodeInput").on("keypress", (e) => {
            if (e.key === "Enter") {
                this.handleBarcodeScan($("#barcodeInput").val());
                $("#barcodeInput").val("");
            }
        });

        // Manual search
        $("#productSearch").on("input", (e) =>
            this.handleManualSearch(e.target.value)
        );
        $("#clearSearch").on("click", () => {
            $("#productSearch").val("").focus();
            $("#searchResults").hide();
        });

        // Category and stock filters
        $("#categoryFilter, #stockFilter").on("change", () =>
            this.loadProducts()
        );

        // Clear cart
        $("#clearCartBtn").on("click", () => this.clearCart());

        // Checkout
        $("#checkoutBtn").on("click", () => this.showCheckoutModal());

        // Print receipt
        $("#printReceiptBtn").on("click", () => this.printReceipt());

        // Quick actions
        $("#quickSaleBtn").on("click", () => this.quickSale());
        $("#applyDiscountBtn").on("click", () => this.applyDiscount());
        $("#returnBtn").on("click", () => this.processReturn());
        $("#loadCartBtn").on("click", () => this.loadSavedCarts());

        // Hold cart
        $("#holdCartBtn").on("click", () => this.holdCart());

        // Show images toggle
        $("#showImages").on("change", (e) => {
            localStorage.setItem("posShowImages", e.target.checked);
            this.loadProducts();
        });

        // Quantity modal
        $("#confirmQuantityBtn").on("click", () =>
            this.addProductWithQuantity()
        );
        $("#quantityInput").on("keypress", (e) => {
            if (e.key === "Enter") {
                this.addProductWithQuantity();
            }
        });

        // Close dropdown when clicking outside
        $(document).on("click", (e) => {
            if (!$(e.target).closest(".dropdown-search-container").length) {
                $("#searchResults").hide();
            }
        });

        // Keyboard shortcuts
        $(document).on("keydown", (e) => {
            // Ctrl + F focus search
            if (e.ctrlKey && e.key === "f") {
                e.preventDefault();
                $("#productSearch").focus();
            }

            // F2 clear cart
            if (e.key === "F2") {
                e.preventDefault();
                this.clearCart();
            }

            // F3 checkout
            if (e.key === "F3") {
                e.preventDefault();
                this.showCheckoutModal();
            }

            // F5 refresh products
            if (e.key === "F5") {
                e.preventDefault();
                this.loadProducts();
            }

            // Escape close dropdown
            if (e.key === "Escape") {
                $("#searchResults").hide();
            }
        });
    }

    setupSearch() {
        // Restore show images setting
        const showImages = localStorage.getItem("posShowImages") === "true";
        $("#showImages").prop("checked", showImages);
    }

    keepBarcodeFocus() {
        // Keep focus on barcode input
        $(document).on("click", (e) => {
            if (!$(e.target).closest("#barcodeInput, .modal").length) {
                setTimeout(() => $("#barcodeInput").focus(), 100);
            }
        });
    }

    handleBarcodeInput(value) {
        clearTimeout(this.scanTimeout);

        // Check if this is likely a barcode scan (fast input)
        if (value.length >= 8 && this.isScanning) {
            this.scanTimeout = setTimeout(() => {
                this.handleBarcodeScan(value);
                $("#barcodeInput").val("");
                this.isScanning = false;
            }, 50);
        } else {
            this.scanTimeout = setTimeout(() => {
                if (value.length >= 3) {
                    this.handleBarcodeScan(value);
                    $("#barcodeInput").val("");
                }
            }, 500);
        }
    }

    async handleBarcodeScan(barcode) {
        if (!barcode.trim()) return;

        try {
            this.showLoading(true);
            const data = await this.apiFetch(
                `${POS_CONFIG.api.pos-products}/by-barcode/${encodeURIComponent(
                    barcode
                )}`
            );

            if (data.success && data.product) {
                this.currentProduct = data.product;
                this.showQuantityModal(data.product);
            } else {
                this.showToast("Product not found", "error");
                this.playSound("error");
            }
        } catch (error) {
            console.error("Barcode scan error:", error);
            this.showToast("Error scanning product", "error");
            this.playSound("error");
        } finally {
            this.showLoading(false);
        }
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
            const category = $("#categoryFilter").val();
            const inStock = $("#stockFilter").val() === "in_stock";

            let url = `${
                POS_CONFIG.api.products
            }/search?search=${encodeURIComponent(searchTerm)}`;
            if (category) url += `&category=${encodeURIComponent(category)}`;
            if (inStock) url += `&in_stock=true`;

            const response = await fetch(url);
            const data = await response.json();

            if (data.success && data.products.length > 0) {
                this.showSearchResults(data.products, searchTerm);
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
            const highlightedName = this.highlightText(
                product.name,
                searchTerm
            );
            const stockClass =
                product.stock <= product.min_stock
                    ? product.stock === 0
                        ? "out-of-stock"
                        : "low-stock"
                    : "";

            html += `
                <div class="dropdown-search-item" 
                     data-product-id="${product.id}"
                     data-product-name="${product.title}"
                     data-product-price="${product.price}"
                     data-product-stock="${product.stock}">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="flex-grow-1">
                            <div class="fw-medium">${highlightedName}</div>
                            <div class="small text-muted">
                                <span class="me-2">${product.barcode}</span>
                                <span class="${stockClass}">
                                    <i class="fas fa-box me-1"></i>${product.formatted_stock}
                                </span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-primary">${product.formatted_price}</div>
                            <button class="btn btn-sm btn-outline-primary mt-1 add-from-search">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });

        resultsDiv.html(html).show();

        // Attach the full product object to each result DOM node to avoid extra API calls
        resultsDiv.find(".dropdown-search-item").each((i, el) => {
            $(el).data("product", products[i]);
        });

        // Attach click events
        $(".dropdown-search-item").on("click", (e) => {
            if (!$(e.target).hasClass("add-from-search")) {
                const product = $(e.currentTarget).data("product");
                if (product) {
                    this.selectProduct(product);
                } else {
                    const productId = $(e.currentTarget).data("product-id");
                    this.selectProductFromSearch(productId);
                }
            }
        });

        $(".add-from-search").on("click", (e) => {
            e.stopPropagation();
            const product = $(e.target)
                .closest(".dropdown-search-item")
                .data("product");
            if (product) {
                this.selectProduct(product);
            } else {
                const productId = $(e.target)
                    .closest(".dropdown-search-item")
                    .data("product-id");
                this.selectProductFromSearch(productId);
            }
        });

        // Keyboard navigation
        $("#productSearch")
            .off("keydown.search")
            .on("keydown.search", (e) => {
                const items = $(".dropdown-search-item");
                const active = $(".dropdown-search-item.active");
                let index = active.length ? items.index(active) : -1;

                switch (e.key) {
                    case "ArrowDown":
                        e.preventDefault();
                        if (index < items.length - 1) {
                            items.removeClass("active");
                            items
                                .eq(index + 1)
                                .addClass("active")
                                .get(0)
                                .scrollIntoView(false);
                        }
                        break;

                    case "ArrowUp":
                        e.preventDefault();
                        if (index > 0) {
                            items.removeClass("active");
                            items
                                .eq(index - 1)
                                .addClass("active")
                                .get(0)
                                .scrollIntoView(false);
                        }
                        break;

                    case "Enter":
                        e.preventDefault();
                        if (active.length) {
                            const productId = active.data("product-id");
                            this.selectProductFromSearch(productId);
                        }
                        break;
                }
            });
    }

    highlightText(text, search) {
        if (!search) return text;
        const regex = new RegExp(
            `(${search.replace(/[.*+?^${}()|[\]\\]/g, "\\$&")})`,
            "gi"
        );
        return text.replace(
            regex,
            '<span class="product-search-highlight">$1</span>'
        );
    }

    // Helper for fetching JSON from our API with proper credentials and error handling
    async apiFetch(path, options = {}) {
        const opts = Object.assign({ credentials: "same-origin" }, options);

        // Build URL: allow absolute URLs or relative paths
        let url = path;
        if (!/^https?:\/\//i.test(path) && !path.startsWith("/")) {
            url =
                POS_CONFIG.api.base.replace(/\/$/, "") +
                "/" +
                path.replace(/^\//, "");
        }

        const response = await fetch(url, opts);
        const ctype = response.headers.get("content-type") || "";

        // Read response text for richer error messages when server returns HTML
        if (!response.ok) {
            const text = await response.text();
            let body = text;
            try {
                if (ctype.indexOf("application/json") !== -1)
                    body = JSON.parse(text);
            } catch (e) {
                // ignore parse errors
            }
            const message =
                body && body.message
                    ? body.message
                    : typeof body === "string"
                    ? body
                    : JSON.stringify(body);
            throw new Error(`HTTP ${response.status}: ${message}`);
        }

        if (ctype.indexOf("application/json") !== -1) {
            return await response.json();
        }

        return await response.text();
    }

    async selectProductFromSearch(productId) {
        // Fallback: if product DOM node wasn't available, try fetching by barcode
        try {
            const data = await this.apiFetch(
                `${POS_CONFIG.api.pos-products}/by-barcode/${encodeURIComponent(
                    productId
                )}`
            );

            if (data.success && data.product) {
                this.currentProduct = data.product;
                $("#productSearch").val("").focus();
                $("#searchResults").hide();
                this.showQuantityModal(data.product);
            }
        } catch (error) {
            console.error("Select product error:", error);
            this.showToast("Error selecting product", "error");
        }
    }

    showQuantityModal(product) {
        this.currentProduct = product;
        const modal = $("#quantityModal");

        // Update modal title
        modal.find(".modal-title").text(`Add ${product.name}`);

        // Set max quantity based on stock
        const maxQty = Math.min(
            POS_CONFIG.settings.maxQuantity,
            product.stock
        );
        $("#quantityInput").val(1).attr("max", maxQty).focus().select();

        // Show modal
        modal.modal("show");
    }

    async addProductWithQuantity() {
        if (!this.currentProduct) return;

        const quantity = parseInt($("#quantityInput").val());
        if (isNaN(quantity) || quantity < 1) {
            this.showToast("Invalid quantity", "error");
            return;
        }

        if (quantity > this.currentProduct.stock) {
            this.showToast(
                `Only ${this.currentProduct.stock} items in stock`,
                "error"
            );
            return;
        }

        try {
            const data = await this.apiFetch(`${POS_CONFIG.api.pos-cart}/add`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: JSON.stringify({
                    product_id: this.currentProduct.id,
                    quantity: quantity,
                }),
            });

            if (data.success) {
                this.showToast(
                    `Added ${quantity} × ${this.currentProduct.name}`,
                    "success"
                );
                this.playSound("add");
                await this.loadCart();
                $("#quantityModal").modal("hide");
                this.currentProduct = null;
            } else {
                this.showToast(
                    data.message || "Failed to add to cart",
                    "error"
                );
                this.playSound("error");
            }
        } catch (error) {
            console.error("Add to cart error:", error);
            this.showToast("Error adding to cart: " + error.message, "error");
            this.playSound("error");
        }
    }

    async loadProducts() {
        try {
            $("#productsGrid").hide();
            $("#productsLoading").show();
            $("#noProducts").hide();

            const category = $("#categoryFilter").val();
            const stockFilter = $("#stockFilter").val();
            const showImages = $("#showImages").is(":checked");

            // let url = `${pos-products}/search?limit=50`;
            if (category) url += `&category=${encodeURIComponent(category)}`;
            if (stockFilter === "in_stock") url += "&in_stock=true";

            const response = await fetch('/pos-products');
            const data = await response.json();
            console.log(data.products.data)

            if (data.success) {
                this.renderProducts(data.products, showImages);
                $("#productCount").text(`${data.count} products`);

                if (data.count === 0) {
                    $("#productsGrid").hide();
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
            const stockClass =
                product.stock <= product.min_stock
                    ? product.stock === 0
                        ? "out-of-stock"
                        : "low-stock"
                    : "";
            const stockBadge =
                product.stock === 0
                    ? '<span class="badge bg-danger">Out of Stock</span>'
                    : product.stock <= product.min_stock
                    ? `<span class="badge bg-warning">Low Stock</span>`
                    : `<span class="badge bg-success">In Stock</span>`;

            html += `
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="card product-card h-100 cursor-pointer" 
                         data-product-id="${product.id}"
                         data-product-name="${product.title}"
                         data-product-price="${product.price}">
                        <div class="card-body">
                            <div class="d-flex align-items-start mb-2">
                                ${
                                    showImages && product.image
                                        ? `<img src="${product.image}" class="product-image me-2" alt="${product.name}">`
                                        : '<div class="product-image me-2 bg-light rounded d-flex align-items-center justify-content-center">' +
                                          '<i class="fas fa-box text-muted"></i></div>'
                                }
                                <div class="flex-grow-1">
                                    <h6 class="card-title mb-1">${
                                        product.name
                                    }</h6>
                                    <div class="small text-muted mb-2">${
                                        product.barcode
                                    }</div>
                                    ${stockBadge}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div>
                                    <div class="fw-bold text-primary fs-5">${
                                        product.formatted_price
                                    }</div>
                                    <div class="small ${stockClass}">
                                        <i class="fas fa-box me-1"></i>${
                                            product.formatted_stock
                                        }
                                    </div>
                                </div>
                                <button class="btn btn-primary add-product-btn">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        });

        grid.html(html);

        // Attach the full product object to each product card to avoid extra API calls
        grid.find(".product-card").each((i, el) => {
            $(el).data("product", products[i]);
        });

        // Attach click events
        $(".product-card").on("click", (e) => {
            if (!$(e.target).hasClass("add-product-btn")) {
                const product = $(e.currentTarget).data("product");
                if (product) {
                    this.selectProduct(product);
                } else {
                    const productId = $(e.currentTarget).data("product-id");
                    this.selectProductFromGrid(productId);
                }
            }
        });

        $(".add-product-btn").on("click", (e) => {
            e.stopPropagation();
            const product = $(e.target)
                .closest(".product-card")
                .data("product");
            if (product) {
                this.selectProduct(product);
            } else {
                const productId = $(e.target)
                    .closest(".product-card")
                    .data("product-id");
                this.selectProductFromGrid(productId);
            }
        });
    }

    async selectProductFromGrid(productId) {
        // Fallback: if product DOM node wasn't available, try fetching by barcode
        try {
            const data = await this.apiFetch(
                `${POS_CONFIG.api.pos-products}/by-barcode/${encodeURIComponent(
                    productId
                )}`
            );

            if (data.success && data.product) {
                this.currentProduct = data.product;
                this.showQuantityModal(data.product);
            }
        } catch (error) {
            console.error("Select product error:", error);
            this.showToast("Error selecting product", "error");
        }
    }

    selectProduct(product) {
        if (!product) return;
        this.currentProduct = product;
        $("#productSearch").val("").focus();
        $("#searchResults").hide();
        this.showQuantityModal(product);
    }

    // Update the loadCart method in POSSystem class
    async loadCart() {
        try {

           const { data } = await axios.get('/pos-cart'); // FIXED
            console.log(data)
            if (data.success) {
                this.cartData = data;
                this.renderCart(data);
                this.updateCartCount(
                    data.summary.item_count,
                    data.summary.total_items
                );
            } else {
                console.error("Cart API returned error:", data.message);
                this.showToast(data.message || "Error loading cart", "error");

                // Initialize empty cart if there's an error
                this.cartData = {
                    items: [],
                    summary: {
                        subtotal: 0,
                        tax: 0,
                        total: 0,
                        total_items: 0,
                        item_count: 0,
                    },
                };
                this.renderCart(this.cartData);
            }
        } catch (error) {
            console.error("Load cart error:", error);
            this.showToast("Error loading cart: " + error.message, "error");

            // Initialize empty cart on error
            this.cartData = {
                items: [],
                summary: {
                    subtotal: 0,
                    tax: 0,
                    total: 0,
                    total_items: 0,
                    item_count: 0,
                },
            };
            this.renderCart(this.cartData);
            this.updateCartCount(0, 0);
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
                <tr class="cart-item align-middle" data-item-key="${
                    item.item_key
                }">
                    <td>
                        <button class="btn btn-sm btn-outline-danger remove-item-btn">
                            <i class="fas fa-times"></i>
                        </button>
                    </td>
                    <td>
                        <div class="fw-medium">${item.name}</div>
                        <div class="small text-muted">${item.barcode}</div>
                    </td>
                    <td>${POS_CONFIG.settings.currency}${item.price.toFixed(
                2
            )}</td>
                    <td>
                        <div class="input-group input-group-sm">
                            <button class="btn btn-outline-secondary qty-decrease" type="button">-</button>
                            <input type="number" 
                                   class="form-control text-center quantity-input" 
                                   value="${item.quantity}" 
                                   min="1" 
                                   max="${item.stock}"
                                   data-product-id="${item.id}">
                            <button class="btn btn-outline-secondary qty-increase" type="button">+</button>
                        </div>
                    </td>
                    <td class="fw-bold">${
                        POS_CONFIG.settings.currency
                    }${item.total.toFixed(2)}</td>
                </tr>
            `;
        });

        table.html(html);

        // Update summary
        $("#cartSubtotal").text(
            `${POS_CONFIG.settings.currency}${cartData.summary.subtotal.toFixed(
                2
            )}`
        );
        $("#cartTax").text(
            `${POS_CONFIG.settings.currency}${cartData.summary.tax.toFixed(2)}`
        );
        $("#cartTotal").text(
            `${POS_CONFIG.settings.currency}${cartData.summary.total.toFixed(
                2
            )}`
        );

        // Attach cart item events
        this.attachCartEvents();
    }

    attachCartEvents() {
        // Remove item
        $(".remove-item-btn").on("click", async (e) => {
            const itemKey = $(e.target).closest(".cart-item").data("item-key");
            await this.removeFromCart(itemKey);
        });

        // Quantity decrease
        $(".qty-decrease").on("click", async (e) => {
            const input = $(e.target)
                .closest(".input-group")
                .find(".quantity-input");
            const productId = input.data("product-id");
            let qty = parseInt(input.val()) - 1;

            if (qty >= 1) {
                await this.updateCartQuantity(productId, qty);
            }
        });

        // Quantity increase
        $(".qty-increase").on("click", async (e) => {
            const input = $(e.target)
                .closest(".input-group")
                .find(".quantity-input");
            const productId = input.data("product-id");
            let qty = parseInt(input.val()) + 1;

            await this.updateCartQuantity(productId, qty);
        });

        // Quantity input change
        $(".quantity-input").on("change", async (e) => {
            const input = $(e.target);
            const productId = input.data("product-id");
            const qty = parseInt(input.val());

            if (qty >= 1) {
                await this.updateCartQuantity(productId, qty);
            }
        });
    }

    async removeFromCart(productId) {
        if (!confirm("Remove this item from cart?")) return;

        try {
            const data = await this.apiFetch(
                `${POS_CONFIG.api.pos-cart}/remove/${productId}`,
                {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                }
            );

            if (data.success) {
                this.showToast("Item removed from cart", "success");
                await this.loadCart();
            } else {
                this.showToast(
                    data.message || "Failed to remove item",
                    "error"
                );
            }
        } catch (error) {
            console.error("Remove from cart error:", error);
            this.showToast("Error removing item: " + error.message, "error");
        }
    }

    async updateCartQuantity(productId, quantity) {
        try {
            const data = await this.apiFetch(`${POS_CONFIG.api.cart}/update`, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity,
                }),
            });

            if (data.success) {
                await this.loadCart();
            } else {
                this.showToast(
                    data.message || "Failed to update quantity",
                    "error"
                );
            }
        } catch (error) {
            console.error("Update quantity error:", error);
            this.showToast(
                "Error updating quantity: " + error.message,
                "error"
            );
        }
    }

    async clearCart() {
        if (!this.cartData || this.cartData.items.length === 0) return;

        if (!confirm("Clear all items from cart?")) return;

        try {
            const data = await this.apiFetch(`${POS_CONFIG.api.pos-cart}/clear`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });

            if (data.success) {
                this.showToast("Cart cleared", "success");
                await this.loadCart();
            } else {
                this.showToast(data.message || "Failed to clear cart", "error");
            }
        } catch (error) {
            console.error("Clear cart error:", error);
            this.showToast("Error clearing cart: " + error.message, "error");
        }
    }

    async loadCartCount() {
        try {
            const response = await fetch(`${POS_CONFIG.api.pos-cart}/count`);
            const data = await response.json();

            if (data.success) {
                this.updateCartCount(data.count, data.total_items);
            }
        } catch (error) {
            console.error("Load cart count error:", error);
        }
    }

    updateCartCount(count, totalItems) {
        const badge = $("#cartCountBadge");
        if (count === 0) {
            badge.text("Cart empty");
            badge.removeClass("bg-primary").addClass("bg-secondary");
        } else {
            badge.text(`${count} items (${totalItems} units)`);
            badge.removeClass("bg-secondary").addClass("bg-primary");
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
                        <div class="card-header">
                            <h6 class="mb-0">Order Summary</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-2 d-flex justify-content-between">
                                <span>Subtotal:</span>
                                <span>${
                                    POS_CONFIG.settings.currency
                                }${this.cartData.summary.subtotal.toFixed(
            2
        )}</span>
                            </div>
                            <div class="mb-2 d-flex justify-content-between">
                                <span>Tax (10%):</span>
                                <span>${
                                    POS_CONFIG.settings.currency
                                }${this.cartData.summary.tax.toFixed(2)}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Total:</span>
                                <span class="text-primary">${
                                    POS_CONFIG.settings.currency
                                }${this.cartData.summary.total.toFixed(
            2
        )}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Payment Method</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-6">
                                    <button class="btn btn-outline-primary w-100 payment-method" data-method="cash">
                                        <i class="fas fa-money-bill-wave me-2"></i>Cash
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-outline-primary w-100 payment-method" data-method="card">
                                        <i class="fas fa-credit-card me-2"></i>Card
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-outline-primary w-100 payment-method" data-method="upi">
                                        <i class="fas fa-mobile-alt me-2"></i>UPI
                                    </button>
                                </div>
                                <div class="col-6">
                                    <button class="btn btn-outline-primary w-100 payment-method" data-method="wallet">
                                        <i class="fas fa-wallet me-2"></i>Wallet
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">Payment Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Amount Paid</label>
                                <input type="number" 
                                       id="amountPaid" 
                                       class="form-control form-control-lg" 
                                       value="${this.cartData.summary.total.toFixed(
                                           2
                                       )}"
                                       step="0.01"
                                       min="0"
                                       autofocus>
                            </div>
                            
                            <div class="mb-3" id="changeAmountContainer" style="display: none;">
                                <label class="form-label">Change</label>
                                <input type="text" 
                                       id="changeAmount" 
                                       class="form-control form-control-lg text-success fw-bold" 
                                       readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Customer (Optional)</label>
                                <input type="text" 
                                       id="customerName" 
                                       class="form-control" 
                                       placeholder="Customer name">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Notes (Optional)</label>
                                <textarea id="paymentNotes" class="form-control" rows="2" placeholder="Any notes..."></textarea>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button class="btn btn-success btn-lg" id="completePaymentBtn">
                                    <i class="fas fa-check-circle me-2"></i>Complete Payment
                                </button>
                                <button class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        modalBody.html(html);
        modal.modal("show");

        // Attach payment events
        this.attachPaymentEvents();
    }

    attachPaymentEvents() {
        // Payment method selection
        $(".payment-method").on("click", function () {
            $(".payment-method").removeClass("active");
            $(this).addClass("active");
        });

        // Calculate change
        $("#amountPaid").on("input", () => {
            const total = this.cartData.summary.total;
            const paid = parseFloat($("#amountPaid").val()) || 0;
            const change = paid - total;

            if (change >= 0) {
                $("#changeAmount").val(
                    `${POS_CONFIG.settings.currency}${change.toFixed(2)}`
                );
                $("#changeAmountContainer").show();
            } else {
                $("#changeAmountContainer").hide();
            }
        });

        // Complete payment
        $("#completePaymentBtn").on("click", async () => {
            await this.processPayment();
        });
    }

    async processPayment() {
        const paymentMethod =
            $(".payment-method.active").data("method") || "cash";
        const amountPaid = parseFloat($("#amountPaid").val()) || 0;
        const customerName = $("#customerName").val();
        const notes = $("#paymentNotes").val();

        if (amountPaid < this.cartData.summary.total) {
            this.showToast("Amount paid is less than total", "error");
            return;
        }

        try {
            this.showLoading(true);

            // In a real app, you would save the sale to database here
            await new Promise((resolve) => setTimeout(resolve, 1000)); // Simulate API call

            // Generate receipt
            this.generateReceipt({
                paymentMethod,
                amountPaid,
                customerName,
                notes,
                change: amountPaid - this.cartData.summary.total,
            });

            // Clear cart
            await this.clearCart();

            // Show success message
            this.showToast("Payment completed successfully!", "success");
            this.playSound("scan");

            // Close checkout modal
            $("#checkoutModal").modal("hide");
        } catch (error) {
            console.error("Payment error:", error);
            this.showToast("Error processing payment", "error");
        } finally {
            this.showLoading(false);
        }
    }

    generateReceipt(paymentInfo) {
        const receipt = $("#receiptContent");
        const now = new Date();
        const receiptNumber = "REC-" + Date.now().toString().slice(-8);

        let itemsHtml = "";
        this.cartData.items.forEach((item) => {
            itemsHtml += `
                ${item.name}
                ${item.quantity} × ${
                POS_CONFIG.settings.currency
            }${item.price.toFixed(2)} = ${
                POS_CONFIG.settings.currency
            }${item.total.toFixed(2)}
            `;
        });

        const html = `
            <div class="text-center mb-3">
                <h5 class="fw-bold">POS SYSTEM</h5>
                <p class="mb-1">123 Main Street, City</p>
                <p class="mb-1">Phone: (123) 456-7890</p>
                <p class="mb-1">GSTIN: 29ABCDE1234F1Z5</p>
            </div>
            
            <hr>
            
            <div class="mb-2">
                <div class="d-flex justify-content-between">
                    <span>Receipt #:</span>
                    <span>${receiptNumber}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Date:</span>
                    <span>${now.toLocaleDateString()}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Time:</span>
                    <span>${now.toLocaleTimeString()}</span>
                </div>
                ${
                    paymentInfo.customerName
                        ? `
                <div class="d-flex justify-content-between">
                    <span>Customer:</span>
                    <span>${paymentInfo.customerName}</span>
                </div>`
                        : ""
                }
            </div>
            
            <hr>
            
            <pre class="mb-2" style="font-family: inherit;">${itemsHtml}</pre>
            
            <hr>
            
            <div class="mb-2">
                <div class="d-flex justify-content-between">
                    <span>Subtotal:</span>
                    <span>${
                        POS_CONFIG.settings.currency
                    }${this.cartData.summary.subtotal.toFixed(2)}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Tax (10%):</span>
                    <span>${
                        POS_CONFIG.settings.currency
                    }${this.cartData.summary.tax.toFixed(2)}</span>
                </div>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Total:</span>
                    <span>${
                        POS_CONFIG.settings.currency
                    }${this.cartData.summary.total.toFixed(2)}</span>
                </div>
            </div>
            
            <hr>
            
            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <span>Payment Method:</span>
                    <span>${paymentInfo.paymentMethod.toUpperCase()}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Amount Paid:</span>
                    <span>${
                        POS_CONFIG.settings.currency
                    }${paymentInfo.amountPaid.toFixed(2)}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Change:</span>
                    <span>${
                        POS_CONFIG.settings.currency
                    }${paymentInfo.change.toFixed(2)}</span>
                </div>
            </div>
            
            <hr>
            
            <div class="text-center">
                <p class="mb-1">Thank you for your purchase!</p>
                <p class="mb-1">*** Goods once sold cannot be returned ***</p>
                <p class="mb-0">Visit Again!</p>
            </div>
        `;

        receipt.html(html);
        $("#receiptModal").modal("show");
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

    quickSale() {
        // Implementation for quick sale
        this.showToast("Quick sale feature coming soon", "info");
    }

    applyDiscount() {
        if (!this.cartData || this.cartData.items.length === 0) {
            this.showToast("Cart is empty", "error");
            return;
        }

        const discount = prompt("Enter discount percentage:", "10");
        if (discount && !isNaN(discount)) {
            this.showToast(`Discount of ${discount}% applied`, "success");
        }
    }

    processReturn() {
        this.showToast("Return feature coming soon", "info");
    }

    loadSavedCarts() {
        this.showToast("Load cart feature coming soon", "info");
    }

    holdCart() {
        if (!this.cartData || this.cartData.items.length === 0) {
            this.showToast("Cart is empty", "error");
            return;
        }

        const cartName = prompt(
            "Enter a name for this cart:",
            `Cart ${new Date().toLocaleTimeString()}`
        );
        if (cartName) {
            // Save cart to localStorage
            const savedCarts = JSON.parse(
                localStorage.getItem("savedCarts") || "[]"
            );
            savedCarts.push({
                name: cartName,
                data: this.cartData,
                timestamp: new Date().toISOString(),
            });
            localStorage.setItem("savedCarts", JSON.stringify(savedCarts));

            this.showToast(`Cart saved as "${cartName}"`, "success");
            this.clearCart();
        }
    }

    showLoading(show) {
        const overlay = $("#loadingOverlay");
        show ? overlay.show() : overlay.hide();
    }

    showToast(message, type = "info") {
        const toastContainer = $("#toastContainer");
        const toastId = "toast-" + Date.now();

        const icons = {
            success: "fas fa-check-circle",
            error: "fas fa-exclamation-circle",
            warning: "fas fa-exclamation-triangle",
            info: "fas fa-info-circle",
        };

        const toast = $(`
            <div id="${toastId}" class="toast align-items-center border-0 bg-${type}" role="alert">
                <div class="d-flex">
                    <div class="toast-body text-white">
                        <i class="${icons[type]} me-2"></i>${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `);

        toastContainer.append(toast);
        const bsToast = new bootstrap.Toast(toast[0]);
        bsToast.show();

        toast.on("hidden.bs.toast", () => toast.remove());
    }

    playSound(type) {
        if (POS_CONFIG.sounds[type]) {
            const audio = new Audio(POS_CONFIG.sounds[type]);
            audio.play().catch(() => {
                // Sound play failed, ignore
            });
        }
    }
}

// Initialize POS System when DOM is ready
$(document).ready(function () {
    window.posSystem = new POSSystem();

    // Set initial focus
    setTimeout(() => $("#barcodeInput").focus(), 500);
});
