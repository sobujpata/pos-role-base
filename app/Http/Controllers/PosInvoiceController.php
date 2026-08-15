<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PosInvoice;
use App\Models\PosInvoiceProduct;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class PosInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        // dd($user->id);
        $user_id = $user->id;
        return view('backend.pages.pos-system.sale-page', compact('user_id'));
    }

    public function InvoicePage()
    {
        // dd('Invoice page');
        return view('backend.pages.pos-system.invoice-page');
    }

    public function posByScanner()
    {
        $categories = Category::all();
        return view('backend.pages.pos-system.create-sale-by-barcode-scanner', compact('categories'));
    }
    public function ProductList()
    {
        $products = Product::all();

        return response()->json($products);
    }

    public function invoiceCreate(Request $request)
    {
        
        $validated = $request->validate([
            'paymentMethod' => ['required', 'string', 'max:50'],
            'customerName' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'total' => ['required', 'numeric'],
            'discount' => ['required', 'numeric'],
            'vat' => ['nullable', 'numeric'],
            'payable' => ['required', 'numeric'],
            'products' => ['required', 'array'],
            'products.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'products.*.qty' => ['required', 'integer', 'min:1'],
            'products.*.sale_price' => ['required', 'numeric', 'min:0'],
        ]);

        DB::beginTransaction();
        try {
            $user_id = Auth::id();

            $invoice = PosInvoice::create([
                'total' => $validated['total'],
                'discount' => $validated['discount'],
                'vat' => $validated['vat'] ?? 0,
                'payable' => $validated['payable'],
                'user_id' => $user_id,
                'payMethod' => trim($validated['paymentMethod']),
                'custName' => $validated['customerName'] !== null ? trim($validated['customerName']) : null,
                'notes' => $validated['notes'] !== null ? trim($validated['notes']) : null,
            ]);

            foreach ($validated['products'] as $item) {

                $qty        = is_numeric($item['qty']) ? $item['qty'] : 0;
                $sale_price = is_numeric($item['sale_price']) ? $item['sale_price'] : 0;
                $product = Product::find($item['product_id']);
                $buy_price = $product ? $product->original_price : 0;
                // unit price
                $rate = $sale_price / $qty;

                // Check what is being sent from frontend
                $total_buy_price = $qty * $buy_price; // adjust if needed
                // return $invoice->id;
                PosInvoiceProduct::create([
                    'invoice_id'      => $invoice->id,
                    'user_id'         => $user_id,
                    'product_id'      => $item['product_id'],
                    'qty'             => $qty,
                    'sale_price'      => $sale_price,
                    'rate'            => $rate,
                    'total_buy_price' => $total_buy_price,
                ]);

                // Update stock
                Product::where('id', $item['product_id'])
                    ->decrement('stock', $qty);
            }

            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
            // return 0;
        }
    }

    public function invoiceSelect(Request $request)
    {
        $invoices = PosInvoice::where('is_read', '0')->with('user')->get();
        // Prepare a response structure
        $responseData = $invoices->map(function ($invoice) {
            $invoice_id = $invoice->id;

            // Fetch invoice products for the current invoice
            $invoiceProducts = PosInvoiceProduct::where('invoice_id', $invoice_id)
                ->with('product')
                ->get();

            // Calculate total buy price for this invoice
            $totalBuyPrice = PosInvoiceProduct::where('invoice_id', $invoice_id)
                ->join('products', 'pos_invoice_products.product_id', '=', 'products.id')
                ->select(DB::raw('SUM(products.original_price * pos_invoice_products.qty) as total_buy_price'))
                ->value('total_buy_price');

            return [
                'invoice'         => $invoice,
                'invoiceProducts' => $invoiceProducts,
                'totalBuyPrice'   => $totalBuyPrice,
            ];
        });
        return response()->json([
            'data' => $responseData,
        ]);
    }

    public function InvoiceDetails(Request $request)
    {

        $ShopManDetails = User::where('id', $request->input('user_id'))->first();

        $invoiceTotal = PosInvoice::where('id', $request->input('inv_id'))->first();
        // Fetch detailed invoice products with related products
        $invoiceProducts = PosInvoiceProduct::where('invoice_id', $request->input('inv_id'))
            ->with('product')
            ->get();

        // Calculate total buy price using database query
        $totalBuyPrice = PosInvoiceProduct::where('pos_invoice_products.invoice_id', $request->input('inv_id'))
            ->join('products', 'pos_invoice_products.product_id', '=', 'products.id') // Adjust table/column names
            ->select(DB::raw('SUM(products.original_price * pos_invoice_products.qty) as total_buy_price'))
            ->value('total_buy_price');

        $alltotalBuyPrice = PosInvoiceProduct::join('products', 'pos_invoice_products.product_id', '=', 'products.id') // Join the product table
            ->select(DB::raw('SUM(products.original_price * pos_invoice_products.qty) as total_buy_price'))                     // Calculate the sum
            ->value('total_buy_price');                                                                                    // Retrieve the aggregated value

        // Get the start and end dates for last month
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $endOfLastMonth   = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        // Calculate the total for last month
        $totalBuyPriceLastMonth = PosInvoiceProduct::whereBetween('pos_invoice_products.created_at', [$startOfLastMonth, $endOfLastMonth])
            ->join('products', 'pos_invoice_products.product_id', '=', 'products.id')
            ->select(DB::raw('SUM(products.original_price * pos_invoice_products.qty) as total_buy_price'))
            ->value('total_buy_price');

        return [
            'user'                   => $ShopManDetails,
            'invoice'                => $invoiceTotal,
            'product'                => $invoiceProducts,
            'buyingPrice'            => $totalBuyPrice,
            'allbuyingPrice'         => $alltotalBuyPrice,
            'totalBuyPriceLastMonth' => $totalBuyPriceLastMonth,
        ];
    }

    public function invoiceDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id = $request->header('id');
            PosInvoiceProduct::where('invoice_id', $request->input('inv_id'))->delete();
            PosInvoice::where('id', $request->input('inv_id'))->delete();
            DB::commit();
            return 1;
        } catch (Exception $e) {
            DB::rollBack();
            return 0;
        }
    }

    // Get all products for initial load
    public function posProducts()
    {
        $products = Product::with(['category'])->active()->get();

        return response()->json([
            'success'  => true,
            'products' => $products->map([$this, 'formatProduct']),
            'count'    => $products->count(),
        ]);
    }

    // Search product by barcode
    public function getByBarcode($barcode)
    {
        try {
            Log::info('Searching product by barcode:', ['barcode' => $barcode]);

            // First try exact match
            $product = Product::where('sku', $barcode)
                ->orWhere('title', 'like', "%{$barcode}%")
                ->active()
                ->with(['category'])
                ->first();

            if (! $product) {
                Log::warning('Product not found for barcode:', ['barcode' => $barcode]);

                return response()->json([
                    'success' => false,
                    'message' => 'Product not found',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'product' => $this->formatProduct($product),
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getByBarcode:', [
                'barcode' => $barcode,
                'error'   => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Search products
    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search'   => 'nullable|string|min:1|max:100',
            'category' => 'nullable|exists:categories,id',
            'in_stock' => 'nullable|boolean',
            'limit'    => 'nullable|integer|min:1|max:50',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $search     = $request->get('search', '');
            $categoryId = $request->get('category');
            $inStock    = $request->get('in_stock', false);
            $limit      = $request->get('limit', 100);

            $query = Product::with(['category'])->active();

            if (! empty($search)) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%")
                        ->orWhere('short_des', 'like', "%{$search}%");
                });
            }

            if (! empty($categoryId)) {
                $query->where('category_id', $categoryId);
            }

            if ($inStock) {
                $query->where('stock', '>', 0);
            }

            $products = $query->orderBy('title')
                ->limit($limit)
                ->get()
                ->map([$this, 'formatProduct']);

            return response()->json([
                'success'  => true,
                'products' => $products,
                'count'    => $products->count(),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Get categories
    public function getCategories()
    {
        try {
            $categories = Category::all();

            return response()->json([
                'success'    => true,
                'categories' => $categories,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Format product for response
    public function formatProduct($product)
    {
        return [
            'id'              => $product->id,
            'sku'             => $product->sku,
            'barcode'         => $product->sku, // Alias for frontend
            'title'           => $product->title,
            'name'            => $product->title, // Alias for frontend
            'short_des'       => $product->short_des,
            'description'     => $product->description,
            'price'           => (float) $product->price,
            'buy_price'       => $product->buy_price ? (float) $product->buy_price : null,
            'discount'        => $product->discount,
            'discount_price'  => $product->discount_price ? (float) $product->discount_price : null,
            'image'           => $product->image ? asset('storage/' . $product->image) : null,
            'stock'           => $product->stock,
            'min_stock'       => $product->min_stock,
            'unit'            => $product->unit,
            'star'            => $product->star,
            'remark'          => $product->remark,
            'is_active'       => $product->is_active,
            'category_id'     => $product->category_id,
            'category_name'   => $product->category ? $product->category->name : null,
            'brand_id'        => $product->brand_id,
            'is_low_stock'    => $product->stock <= $product->min_stock,
            'formatted_price' => '₹' . number_format($product->price, 2),
            'formatted_stock' => $product->stock . ' ' . $product->unit,
            'created_at'      => $product->created_at,
            'updated_at'      => $product->updated_at,
        ];
    }

    // Cart operations
    public function getCart(Request $request)
    {
        try {
            $cart       = session()->get('pos_cart', []);
            $cartItems  = [];
            $subtotal   = 0;
            $totalItems = 0;

            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);

                if (! $product) {
                    unset($cart[$productId]);
                    continue;
                }

                // ✅ POS price priority:
                // 1. session sale_price
                // 2. discounted price
                // 3. regular price
                $price = isset($item['sale_price']) && $item['sale_price'] > 0
                    ? (float) $item['sale_price']
                    : (
                        $product->discount && $product->discount_price
                        ? (float) $product->discount_price
                        : (float) $product->price
                    );

                $quantity  = (int) $item['quantity'];
                $itemTotal = $price * $quantity;

                $subtotal += $itemTotal;
                $totalItems += $quantity;

                $cartItems[] = [
                    'id'             => $product->id,
                    'sku'            => $product->sku,
                    'barcode'        => $product->sku,
                    'title'          => $product->title,
                    'name'           => $product->title,
                    'price'          => $price,
                    'quantity'       => $quantity,
                    'total'          => $itemTotal,
                    'stock'          => $product->stock,
                    'unit'           => $product->unit,
                    'image'          => $product->image
                        ? asset('storage/' . $product->image)
                        : null,
                    'has_discount'   => (bool) $product->discount,
                    'original_price' => (float) $product->price,
                    'item_key'       => $productId,
                ];
            }

            session()->put('pos_cart', $cart);

            $taxRate = 0.00; // 10%
            $tax     = round($subtotal * $taxRate, 2);
            $total   = round($subtotal + $tax, 2);

            return response()->json([
                'success' => true,
                'items'   => $cartItems,
                'summary' => [
                    'subtotal'    => round($subtotal, 2),
                    'tax'         => $tax,
                    'total'       => $total,
                    'total_items' => $totalItems,
                    'item_count'  => count($cartItems),
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Error in getCart', ['error' => $e]);

            return response()->json([
                'success' => false,
                'message' => 'Server error',
                'items'   => [],
                'summary' => [
                    'subtotal'    => 0,
                    'tax'         => 0,
                    'total'       => 0,
                    'total_items' => 0,
                    'item_count'  => 0,
                ],
            ], 500);
        }
    }

    // Add item to cart
    public function addItem(Request $request)
    {
        // return response()->json($request->all());
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1|max:999',
            'salePrice'  => 'required|numeric|min:0.01|max:1000000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $product = Product::where('id', $request->product_id)
                ->where('is_active', 1)
                ->first();

            if (! $product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product is not available',
                ], 400);
            }

            $quantity   = (int) $request->quantity;
            $sale_price = (float) $request->salePrice;
            $cart       = session()->get('pos_cart', []);

            // Optional price safety check
            // if ($sale_price >= $product->discount_price) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Sale price cannot be lower than purchase price',
            //     ], 400);
            // }

            $existingQty = $cart[$product->id]['quantity'] ?? 0;
            $newQuantity = $existingQty + $quantity;

            if ($product->stock < $newQuantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Available: ' . $product->stock,
                ], 400);
            }

            $cart[$product->id] = [
                'product_id' => $product->id,
                'name'       => $product->title,
                'quantity'   => $newQuantity,
                'sale_price' => $sale_price,
                'added_at'   => now()->toDateTimeString(),
            ];

            session()->put('pos_cart', $cart);

            return response()->json([
                'success'     => true,
                'message'     => 'Product added to cart',
                'cart_count'  => count($cart),
                'total_items' => array_sum(array_column($cart, 'quantity')),
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error',
            ], 500);
        }
    }

    // Update cart item quantity
    public function updateItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1|max:999',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors(),
            ], 422);
        }

        try {
            $product = Product::find($request->product_id);
            $cart    = session()->get('pos_cart', []);

            if (! isset($cart[$product->id])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in cart',
                ], 404);
            }

            if ($product->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Insufficient stock. Available: ' . $product->stock . ' ' . $product->unit,
                ], 400);
            }

            $cart[$product->id]['quantity'] = $request->quantity;
            session()->put('pos_cart', $cart);

            return response()->json([
                'success' => true,
                'message' => 'Quantity updated',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Remove item from cart
    public function removeItem($productId)
    {
        try {
            $cart = session()->get('pos_cart', []);

            if (isset($cart[$productId])) {
                unset($cart[$productId]);
                session()->put('pos_cart', $cart);

                return response()->json([
                    'success' => true,
                    'message' => 'Product removed from cart',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Clear cart
    public function clearCart()
    {
        try {
            session()->forget('pos_cart');

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Get cart count
    public function getCartCount()
    {
        $cart       = session()->get('pos_cart', []);
        $totalItems = 0;

        foreach ($cart as $item) {
            $totalItems += $item['quantity'];
        }

        return response()->json([
            'success'     => true,
            'count'       => count($cart),
            'total_items' => $totalItems,
        ]);
    }

    // Checkout (optional - you can expand this)
    public function checkout(Request $request)
    {
        // Implement checkout logic here
        return response()->json([
            'success' => true,
            'message' => 'Checkout completed successfully',
        ]);
    }

    public function invoiceReport()
    {
        $responseData = [];
        return view('backend.pages.pos-system.invoice-report', compact('responseData'));
    }



    public function invoiceReportGenerate(Request $request)
    {

        $fromDate = $request->input('from-date');
        $toDate   = $request->input('to-date');

        // Validate dates
        if (!$fromDate || !$toDate) {
            return redirect()->back()
                ->withErrors([
                    'error' => 'Both From Date and To Date are required.'
                ]);
        }



        try {

            // Full day date range
            $from = Carbon::parse($fromDate)->startOfDay();
            $to   = Carbon::parse($toDate)->endOfDay();

            // Get invoices with products
            $invoices = PosInvoice::whereBetween('created_at', [$from, $to])
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->get();
            
            $totalInv = $invoices->count();
            $totalAmount = $invoices->sum('total') ?? null;
            $totalPaidAmount = $invoices->sum('payable');

            // dd($totalInv);

            $responseData = $invoices->map(function ($invoice) {
                $invoice_id = $invoice->id;

                // Fetch invoice products for the current invoice
                // $invoiceProducts = PosInvoiceProduct::where('invoice_id', $invoice_id)
                //     ->with('product')
                //     ->get();

                // Calculate total buy price for this invoice
                $totalBuyPrice = PosInvoiceProduct::where('invoice_id', $invoice_id)
                    ->join('products', 'pos_invoice_products.product_id', '=', 'products.id')
                    ->select(DB::raw('SUM(products.original_price * pos_invoice_products.qty) as total_buy_price'))
                    ->value('total_buy_price');

                return [
                    'invoice'         => $invoice,
                    'totalBuyPrice'   => $totalBuyPrice,
                ];
            });
            $totalProfit = $totalPaidAmount-$responseData->sum('totalBuyPrice');
            // dd($totalProfit);
            return view(
                'backend.pages.pos-system.invoice-report',
                compact(
                    'responseData',
                    'fromDate',
                    'toDate',
                    'totalInv',
                    'totalAmount',
                    'totalPaidAmount',
                    'totalProfit'
                )
            );
        } catch (\Exception $e) {

            return redirect()->back()
                ->withErrors([
                    'error' => 'Error fetching invoices: ' . $e->getMessage()
                ]);
        }
    }

    public function ReportPage()
    {
        return view('backend.pages.pos-system.invoice-report-page');
    }
    public function listCategory()
    {
        $category = Category::get();

        return response()->json([
            'data'=>$category
        ]);
    }
    function SalesReport(Request $request){

        $FormDate=date('Y-m-d',strtotime($request->FormDate));
        $ToDate=date('Y-m-d',strtotime($request->ToDate));

        $total=PosInvoice::whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('total');
        $vat=PosInvoice::whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('vat');
        $payable=PosInvoice::whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('payable');
        $discount=PosInvoice::whereDate('created_at', '>=', $FormDate)->whereDate('created_at', '<=', $ToDate)->sum('discount');



        $list=PosInvoice::whereDate('created_at', '>=', $FormDate)
            ->whereDate('created_at', '<=', $ToDate)
            ->with('user')
            ->get();




        $data=[
            'payable'=> $payable,
            'discount'=>$discount,
            'total'=> $total,
            'vat'=> $vat,
            'list'=>$list,
            'FormDate'=>$request->FormDate,
            'ToDate'=>$request->ToDate
        ];


        $pdf = Pdf::loadView('report.SalesReport',$data);


        return $pdf->download('invoice.pdf');

    }

    function CategoryWiseProduct(Request $request){
        $category_id = $request->categoryId;

        if($category_id == "all"){
            $products = Product::orderBy('title', 'ASC')->get();

            $data = [
                'products'=>$products,
            ];
            $pdf = Pdf::loadView('report.categoryProducts', $data);
    
            return $pdf->download('products.pdf');
        }else{
            $products = Product::where('category_id', $category_id)->orderBy('title', "ASC")->get();

            $data = [
                'products'=>$products,
            ];
            $pdf = Pdf::loadView('report.categoryProducts', $data);
    
            return $pdf->download('products.pdf');
        }
        
    }
}
