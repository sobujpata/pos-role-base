@extends('backend.layouts.app')
@section('title', 'Products Sales Page')
@section('content')
    <style>
        .product-image {
            width: 80px;
            height: 95px;
            object-fit: cover;
            border-radius: 5px;
            
        }
        .product-image:hover{
            transform: scale(2.1);
            border: 2px solid #000;
            transition: all 0.3s ease-in-out;

        }

        @media (max-width: 768px) {
            .mobile-view {
                padding: 0 !important;
            }

            .product-image {
                width: 60px;
                height: 65px;
            }
        }
    </style>
    <div class="page-wrapper app-container">
        <div class="page-content">
            <!-- start-content -->

            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
                <div class="breadcrumb-title pe-3">Sale Tables</div>
                <div class="ps-3">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0 p-0">
                            <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">POS System</li>
                        </ol>
                    </nav>
                </div>
                @can('pos-create')
                    <div class="ms-auto">
                        <div class="btn-group">
                            <a href="{{ url('/invoicePage') }}" class="btn btn-primary">POS Invoice</a>
                        </div>
                    </div>
                @endcan
            </div>
            <!--end breadcrumb-->
            <hr>
            <div class="container-fluid mobile-view">
                <div class="row">
                    <div class="col-md-4 col-lg-4 px-1 py-2">
                        <div class="shadow-sm h-100 bg-white rounded-3 px-3 py-3">
                            <div class="row">
                                <div class="col-8">
                                    <span class="text-bold text-dark">BILLED SYSTEM </span>
                                    {{-- <p class="text-xs mx-0 my-1">Name: <span id="CName"></span> </p>
                                    <p class="text-xs mx-0 my-1">Mobile: <span id="CMobile"></span> </p>
                                    <p class="text-xs mx-0 my-1">Address: <span id="CAddress"></span></p> --}}
                                    <p class="text-xs mx-0 my-1">User ID: <span id="CId">{{ $user_id }}</span></p>
                                    <p class="text-xs mx-0 my-1">Date: {{ date('Y-m-d') }} </p>
                                </div>
                                <div class="col-4">
                                    {{-- <img class="w-50" src="{{"images/logo.png"}}"> --}}
                                    {{-- <span class="text-bold text-primary">Auto Parts </span>
                                    <p class="text-bold mx-0 my-1 text-dark">Invoice </p> --}}
                                    
                                </div>
                            </div>
                            <hr class="mx-0 my-2 p-0 bg-secondary" />
                            <div class="row">
                                <div class="col-12">
                                    <table class="table w-100" id="invoiceTable">
                                        <thead class="w-100">
                                            <tr class="text-xs">
                                                <td>Name</td>
                                                <td>Qty</td>
                                                <td>Total</td>
                                                <td>Remove</td>
                                            </tr>
                                        </thead>
                                        <tbody class="w-100" id="invoiceList">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr class="mx-0 my-2 p-0 bg-secondary" />
                            <div class="row">
                                <div class="col-12">
                                    <p class="text-bold text-xs my-1 text-dark"> TOTAL: </i> <span id="total"></span>
                                        Tk</p>
                                    <p class="text-bold text-xs my-2 text-dark"> PAYABLE: </i> <span
                                            id="payable"></span> Tk</p>
                                    <p class="text-bold text-xs my-1 text-dark d-none"> VAT(0%): </i> <span
                                            id="vat"></span> Tk</p>
                                    <p class="text-bold text-xs my-1 text-dark d-none"> Discount: </i> <span
                                            id="discount"></span> Tk</p>
                                    <span class="text-xxs d-none">Discount(%):</span>
                                    <input onkeydown="return false" value="0" min="0" type="number"
                                        step="0.25" onchange="DiscountChange()" class="form-control d-none w-40 "
                                        id="discountP" />
                                    <p>
                                        <button onclick="createInvoice()"
                                            class="btn  my-3 bg-success w-40">Confirm</button>
                                    </p>
                                </div>
                                <div class="col-12 p-2">

                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-8 col-lg-8 px-1 py-2">
                        <div class="shadow-sm h-100 bg-white rounded-3 px-1 py-3">
                            <table class="table  w-100" id="productTable">
                                <thead class="w-100">
                                    <tr class="text-xs text-bold">
                                        <td width="50%">Product</td>
                                        <td width="30%">Buy & Sale Price</td>
                                        <td class="text-center" width="20%">Pick</td>
                                    </tr>
                                </thead>
                                <tbody class="w-100" id="productList">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title fs-6" id="exampleModalLabel">Add Product</h6>
                        </div>
                        <div class="modal-body">
                            <form id="add-form">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-12">
                                            {{-- <label class="form-label">Product ID *</label> --}}
                                            <input type="text" class="form-control d-none" id="PId">
                                            <label class="form-label mt-2">Product Name *</label>
                                            <input type="text" class="form-control" id="PName" readonly>
                                            <label class="form-label mt-2">Product Price *</label>
                                            <input type="text" class="form-control" id="BuyPrice" readonly>
                                            <label class="form-label mt-2">Product Sale Price *</label>
                                            <input type="text" class="form-control" id="PPrice">
                                            <label class="form-label mt-2">Product Qty *</label>
                                            <input type="text" class="form-control" id="PQty">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal"
                                aria-label="Close">Close</button>
                            <button onclick="add()" id="save-btn" class="btn bg-gradient-success">Add</button>
                        </div>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

            <script>
                (async () => {
                    // showLoader();
                    await ProductList();
                    // hideLoader();
                })()


                let InvoiceItemList = [];


                function ShowInvoiceItem() {

                    let invoiceList = $('#invoiceList');

                    invoiceList.empty();

                    InvoiceItemList.forEach(function(item, index) {
                        let row = `<tr class="text-xs">
                        <td>${item['product_name']}</td>
                        <td>${item['qty']}</td>
                        <td>${item['sale_price']}</td>
                        <td style="display:none;">${item['total_original_price']}</td>
                        <td><a data-index="${index}" class="btn remove text-xxs px-2 py-1  btn-sm m-0">Remove</a></td>
                     </tr>`
                        invoiceList.append(row)
                    })

                    CalculateGrandTotal();

                    $('.remove').on('click', async function() {
                        let index = $(this).data('index');
                        removeItem(index);
                    })

                }

                function removeItem(index) {
                    InvoiceItemList.splice(index, 1);
                    ShowInvoiceItem()
                }

                function DiscountChange() {
                    CalculateGrandTotal();
                }

                function CalculateGrandTotal() {
                    let Total = 0;
                    let Vat = 0;
                    let Payable = 0;
                    let Discount = 0;
                    let discountPercentage = (parseFloat(document.getElementById('discountP').value));

                    InvoiceItemList.forEach((item, index) => {
                        Total = Total + parseFloat(item['sale_price'])
                    })

                    if (discountPercentage === 0) {
                        Vat = ((Total * 0) / 100).toFixed(2);
                    } else {
                        Discount = ((Total * discountPercentage) / 100).toFixed(2);
                        Total = (Total - ((Total * discountPercentage) / 100)).toFixed(2);
                        Vat = ((Total * 0) / 100).toFixed(2);
                    }

                    Payable = (parseFloat(Total) + parseFloat(Vat)).toFixed(2);


                    document.getElementById('total').innerText = Total;
                    document.getElementById('payable').innerText = Payable;
                    document.getElementById('vat').innerText = Vat;
                    document.getElementById('discount').innerText = Discount;
                }

                function add() {
                    let PId = document.getElementById('PId').value;
                    let PName = document.getElementById('PName').value;
                    let PPrice = document.getElementById('PPrice').value;
                    let original_price = document.getElementById('BuyPrice').value;
                    let PQty = document.getElementById('PQty').value;
                    let PTotalPrice = (parseFloat(PPrice) * parseFloat(PQty)).toFixed(2);
                    let PTotalBuyPrice = (parseFloat(original_price) * parseFloat(PQty)).toFixed(2);
                    if (PId.length === 0) {
                        errorToast("Product ID Required");
                    } else if (PName.length === 0) {
                        errorToast("Product Name Required");
                    } else if (PPrice.length === 0) {
                        errorToast("Product Price Required");
                    } else if (PQty.length === 0) {
                        errorToast("Product Quantity Required");
                    } else {
                        let item = {
                            product_name: PName,
                            product_id: PId,
                            qty: PQty,
                            sale_price: PTotalPrice,
                            total_original_price: PTotalBuyPrice
                        };
                        InvoiceItemList.push(item);
                        $('#create-modal').modal('hide')
                        ShowInvoiceItem();
                    }
                }

                function addModal(id, name, price, original_price) {
                    document.getElementById('PId').value = id
                    document.getElementById('PName').value = name
                    document.getElementById('PPrice').value = price
                    document.getElementById('BuyPrice').value = original_price

                    $('#create-modal').modal('show')
                }


                async function ProductList() {
                    let res = await axios.get("/list-products");
                    let productList = $("#productList");
                    let productTable = $("#productTable");
                    productTable.DataTable().destroy();
                    productList.empty();

                    res.data.forEach(function(item, index) {
                        let row = `<tr class="${item['stock'] <= '0' ? 'bg-danger text-white' : ''}">
                        <td>
                            <div class="row">
                                <div class="col-4">
                                    <img src="storage/${item['image']}" alt="No Image" class="me-2 product-image" style="width:100px; object-fit:cover; border-radius:5px;">
                                </div>
                                <div class="col-8">
                                    ${item['title']}<br>${item['sku']}
                                </div>    
                            </div>
                        </td>
                        <td>
                            Product Price : ${item['price']}<br>
                            <span class="text-bold">Discount Price : ${item['discount_price']}</span>
                        </td>
                        <td style="vertical-align: middle; text-align:center;">
                            <a 
                            data-name="${item['title']}" 
                            data-price="${item['discount_price']}" 
                            data-original_price="${item['price']}" 
                            data-id="${item['id']}"
                            class="btn btn-success text-xxs px-2 py-1 addProduct  btn-sm m-0">Add</a></td>
                     </tr>`
                        productList.append(row)
                    })

                    $('.addProduct').on('click', async function() {
                        let PName = $(this).data('name');
                        let PPrice = $(this).data('price')
                        let original_price = $(this).data('original_price')
                        let PId = $(this).data('id');
                        addModal(PId, PName, PPrice, original_price)
                    })

                    new DataTable('#productTable', {
                        // order:[[2,'desc']],
                        scrollCollapse: false,
                        info: false,
                        lengthChange: true,
                        pageLength: 5,
			            lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
                    });
                }

                async function createInvoice() {
                    let total = document.getElementById('total').innerText;
                    let discount = document.getElementById('discount').innerText
                    let vat = document.getElementById('vat').innerText
                    let payable = document.getElementById('payable').innerText

                    let Data = {
                        "total": total,
                        "discount": discount,
                        "vat": vat,
                        "payable": payable,
                        "paymentMethod": "cash",
                        "customerName": "",
                        "notes": "",
                        "products": InvoiceItemList
                    }
                    if (InvoiceItemList.length === 0) {
                        console.log("Product Required !")
                    } else {
                        let res = await axios.post("/pos-invoice-create", Data)
                        console.log(res);
                        if (res.data === 1) {
                            console.log("Invoice Created");
                            window.location.href = '/invoicePage'
                        } else {
                            console.log("Something Went Wrong")
                        }
                    }

                }
            </script>
            <!-- end-content -->
        </div>
    </div>
@endsection
