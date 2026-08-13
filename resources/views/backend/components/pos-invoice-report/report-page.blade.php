<div class="page-wrapper">
    <div class="page-content">
        <!-- start-content -->
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Report Page</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">POS Invoice Reports</li>
                    </ol>
                </nav>
            </div>
            
        </div>
        <!--end breadcrumb-->
        <div class="container-fluid mobile-view">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4>Sales Report</h4>
                            <label class="form-label mt-2">Date From</label>
                            <input id="FormDate" type="date" class="form-control" value="{{ old('FormDate') }}"/>
                            <label class="form-label mt-2">Date To</label>
                            <input id="ToDate" type="date" class="form-control" value="{{ old('ToDate') }}"/>
                            <button onclick="SalesReport()" class="btn mt-3 btn-primary">Download</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4>Products Download</h4>
                            <label class="form-label mt-2">Category Name</label>
                            <select name="category" id="productCategory" class="form-control">
                                <option value="">Select Category</option>
                                <option value="all">All Products</option>
                            </select>
                            <button onclick="productDownload()" class="btn mt-3 btn-success">Download</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('script')
    <script>
        FillCategoryDropDownProduct();
    
        async function FillCategoryDropDownProduct(){
            let res = await axios.get("/list-category")
            // console.log(res);
            res.data.data.forEach(function (item,i) {
                let option=`<option value="${item['id']}">${item['categoryName']}</option>`
                $("#productCategory").append(option);
            })
        }
        function SalesReport() {
            let FormDate = document.getElementById('FormDate').value;
            let ToDate = document.getElementById('ToDate').value;
            if(FormDate.length === 0 || ToDate.length === 0){
                errorToast("Date Range Required !")
            }else{
                window.open('/sales-report/'+FormDate+'/'+ToDate);
            }
        }

        function productDownload() {
            // Get the selected category value
            let category = document.getElementById('productCategory').value;

            // Check if a category is selected
            if (!category) {
                errorToast("Select Category First.");
            } else {
                // console.log(category);
                // Uncomment this line to perform the actual download
                window.open('/category-product/' + category);
            }
        }
    
    </script>
@endpush