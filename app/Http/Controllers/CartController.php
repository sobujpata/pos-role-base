<?php
namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $product = [
            'id'       => $request->id,
            'name'     => $request->name,
            'image'    => $request->image,
            'price'    => $request->price,
            'quantity' => $request->quantity ?? 1,
        ];

        $cart = json_decode(Cookie::get('cart'), true) ?? [];

        $index = collect($cart)->search(fn($item) => $item['id'] == $product['id']);
        if ($index !== false) {
            $cart[$index]['quantity'] += $product['quantity'];
        } else {
            $cart[] = $product;
        }

        return response()->json(['success' => true])
            ->cookie('cart', json_encode($cart), 60);
    }

    public function showCart()
    {
        $cart          = json_decode(Cookie::get('cart'), true) ?? [];
        $total_product = count($cart);
        return view('home_page_1.shop-cart', compact('cart'));
    }

    public function updateCartAjax(Request $request)
    {
        $cart = json_decode(Cookie::get('cart'), true) ?? [];
        $quantities = $request->input('quantities');

        foreach ($quantities as $id => $qty) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = max(1, intval($qty));
            }
        }

        $subtotal   = 0;
        $totalItems = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $totalItems += $item['quantity'];
        }

        Cookie::queue('cart', json_encode($cart), 60 * 24 * 7);

        return response()->json([
            'success' => 'true',
        ]);
        
        // $cartHtml    = view('partials.cart-list', compact('cart'))->render();
        // $summaryHtml = view('partials.cart-summary', compact('subtotal'))->render();

        // return response()->json([
        //     'success'      => true,
        //     'cart_html'    => $cartHtml,
        //     'summary_html' => $summaryHtml,
        //     'total_items'  => $totalItems,
        // ]);

    }

    public function checkOut()
    {
        $cart = json_decode(Cookie::get('cart'), true) ?? [];

        $subtotal   = 0;
        $totalItems = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            $totalItems += $item['quantity'];
        }
        
        return response()->json([
            'cart' => $cart, 
            'subtotal' => $subtotal, 
            'totalItems' => $totalItems
            ]);
    }

    public function removeFromCart($id)
    {
        $cart = json_decode(Cookie::get('cart'), true) ?? [];
        $cart = array_filter($cart, fn($item) => $item['id'] != $id);
        return redirect()->back()
            ->cookie('cart', json_encode(array_values($cart)), 60);
    }
    public function welecomePage(){
        $orderId = json_decode(Cookie::get('last_invoice_id'), true) ?? [];
        // dd($order);
        if(empty($orderId)){
            return redirect()->route('home')->with('error','Please order confirm first.');
        }
        $order = Invoice::findOrFail($orderId);

        return view('home_page_1.welecome-page', compact('order'));
    }
}
