<?php
namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\InvoiceProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('backend.pages.invoices.index');
    }

    public function invoiceSelect(Request $request)
    {
        $user_role = $request->header('role');
        $invoices  = Invoice::get();
        // Prepare a response structure
        $responseData = $invoices->map(function ($invoice) {
            $invoice_id = $invoice->id;

            // Fetch invoice products for the current invoice
            $invoiceProducts = InvoiceProduct::where('invoice_id', $invoice_id)
                ->with('product')
                ->get();

            // Calculate total buy price for this invoice
            $totalBuyPrice = InvoiceProduct::where('invoice_id', $invoice_id)
                ->join('products', 'invoice_products.product_id', '=', 'products.id')
                ->select(DB::raw('SUM(products.buy_price * invoice_products.quantity) as total_buy_price'))
                ->value('total_buy_price');

            return [
                'invoice'         => $invoice,
                'invoiceProducts' => $invoiceProducts,
                'totalBuyPrice'   => $totalBuyPrice,
            ];
        });
        return response()->json([
            'data' => $responseData,
            'role' => $user_role,
        ]);
    }
    public function invoicePrinted(Request $request)
    {
        $user_role = $request->header('role');

        // Fetch all completed invoices with customers
        $invoices = Invoice::where('complete', '1')
            ->with('customer')
            ->get();

        // Prepare a response structure
        $responseData = $invoices->map(function ($invoice) {
            $invoice_id = $invoice->id;

            // Fetch invoice products for the current invoice
            $invoiceProducts = InvoiceProduct::where('invoice_id', $invoice_id)
                ->with('product')
                ->get();

            // Calculate total buy price for this invoice
            $totalBuyPrice = InvoiceProduct::where('invoice_id', $invoice_id)
                ->join('products', 'invoice_products.product_id', '=', 'products.id')
                ->select(DB::raw('SUM(products.buy_price * invoice_products.quantity) as total_buy_price'))
                ->value('total_buy_price');

            return [
                'invoice'         => $invoice,
                'invoiceProducts' => $invoiceProducts,
                'totalBuyPrice'   => $totalBuyPrice,
            ];
        });

        return response()->json([
            'data' => $responseData,
            'role' => $user_role,
        ]);
    }

    public function InvoiceDetails(Request $request)
    {

        // $customerDetails = Customer::where('id', $request->input('cus_id'))->first();
        $invoiceTotal    = Invoice::where('id', $request->input('inv_id'))->first();
        // Fetch detailed invoice products with related products
        $invoiceProducts = InvoiceProduct::where('invoice_id', $request->input('inv_id'))
            ->with('product')
            ->get();

        // Calculate total buy price using database query
        $totalBuyPrice = InvoiceProduct::where('invoice_products.invoice_id', $request->input('inv_id'))
            ->join('products', 'invoice_products.product_id', '=', 'products.id') // Adjust table/column names
            ->select(DB::raw('SUM(products.buy_price * invoice_products.quantity) as total_buy_price'))
            ->value('total_buy_price');

        $alltotalBuyPrice = InvoiceProduct::join('products', 'invoice_products.product_id', '=', 'products.id') // Join the product table
            ->select(DB::raw('SUM(products.buy_price * invoice_products.quantity) as total_buy_price'))                  // Calculate the sum
            ->value('total_buy_price');                                                                             // Retrieve the aggregated value

        // Get the start and end dates for last month
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth()->toDateString();
        $endOfLastMonth   = Carbon::now()->subMonth()->endOfMonth()->toDateString();

        // Calculate the total for last month
        $totalBuyPriceLastMonth = InvoiceProduct::whereBetween('invoice_products.created_at', [$startOfLastMonth, $endOfLastMonth])
            ->join('products', 'invoice_products.product_id', '=', 'products.id')
            ->select(DB::raw('SUM(products.buy_price * invoice_products.quantity) as total_buy_price'))
            ->value('total_buy_price');

        // $due_amount = Collection::where('customer_id', $request->input('cus_id'))->sum('due');
        // Initialize $due_invoice as an empty collection
        // $due_invoice = collect();

        // Retrieve invoices only if the due amount is greater than 0
        // if ($due_amount > 0) {
        //     $due_invoice = Collection::where('customer_id', $request->input('cus_id'))
        //         ->where('due', '>', 0) // Exclude invoices where due is 0
        //         ->get();
        // }
        return [
            // 'customer'               => $customerDetails,
            'invoice'                => $invoiceTotal,
            'product'                => $invoiceProducts,
            'buyingPrice'            => $totalBuyPrice,
            'allbuyingPrice'         => $alltotalBuyPrice,
            'totalBuyPriceLastMonth' => $totalBuyPriceLastMonth,
            // 'due_amount'             => $due_amount,
            // 'due_invoice'            => $due_invoice,
        ];
    }

    public function invoiceDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_id = $request->header('id');
            InvoiceProduct::where('invoice_id', $request->input('inv_id'))->delete();
            Invoice::where('id', $request->input('inv_id'))->delete();
            DB::commit();
            return 1;
        } catch (Exception $e) {
            DB::rollBack();
            return 0;
        }
    }
    public function invoiceComplete(Request $request)
    {

        $user_id = $request->header('id');
        Invoice::where('id', $request->input('inv_id'))->update([
            'complete' => 1,
        ]);
        return 1;

    }
    public function invoiceCreate(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20',
            'address'  => 'required|string|max:255',
            'shipping' => 'required|numeric',
            'subtotal' => 'required|numeric',
            'total'    => 'required|numeric',
        ]);

        $cart = json_decode(Cookie::get('cart'), true) ?? [];

        if (empty($cart)) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        try {
            DB::beginTransaction();

            $invoice = Invoice::create([
                'name'     => $request->name,
                'phone'    => $request->phone,
                'address'  => $request->address,
                'shipping' => $request->shipping,
                'subtotal' => $request->subtotal,
                'total'    => $request->total,
            ]);

            foreach ($cart as $item) {
                if (! isset($item['id'], $item['quantity'], $item['price'])) {
                    throw new \Exception('Invalid cart item structure');
                }

                InvoiceProduct::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $item['id'],
                    'quantity'   => $item['quantity'],
                    'price'      => $item['price'],
                ]);
            }

            Cookie::queue(Cookie::forget('cart'));
            DB::commit();

            return response()->json([
                'success'    => true,
                'message'    => 'Invoice created successfully',
                'invoice_id' => $invoice->id,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error'   => 'Failed to create invoice',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

}
