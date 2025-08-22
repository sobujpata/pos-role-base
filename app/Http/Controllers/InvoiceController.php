<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class InvoiceController extends Controller
{
  public function invoiceCreate(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'address' => 'required|string|max:255',
        'shipping' => 'required|numeric',
        'subtotal' => 'required|numeric',
        'total' => 'required|numeric',
    ]);

    $cart = json_decode(Cookie::get('cart'), true) ?? [];

    if (empty($cart)) {
        return response()->json(['error' => 'Cart is empty'], 400);
    }

    try {
        DB::beginTransaction();

        $invoice = Invoice::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'shipping' => $request->shipping,
            'subtotal' => $request->subtotal,
            'total' => $request->total,
        ]);

        foreach ($cart as $item) {
            if (!isset($item['id'], $item['quantity'], $item['price'])) {
                throw new \Exception('Invalid cart item structure');
            }

            InvoiceProduct::create([
                'invoice_id' => $invoice->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        Cookie::queue(Cookie::forget('cart'));
        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Invoice created successfully',
            'invoice_id' => $invoice->id,
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'error' => 'Failed to create invoice',
            'details' => $e->getMessage()
        ], 500);
    }
}


}
