<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Milon\Barcode\Facades\DNS1D;

class BarcodeGenerateController extends Controller
{
    public function index()
    {
        return view('backend.pages.barcode-generate.index');
    }

    public function BarcodeGenerateById(Request $request)
    {
        $request->validate([
            'id' => 'required|integer'
        ]);

        $product = Product::find($request->id);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Product not found'
            ], 404);
        }

        // Use SKU or fallback to product ID if SKU is empty
        $code = $product->sku ?: 'PROD-' . $product->id;

        try {
            $barcode = DNS1D::getBarcodePNG($code, 'C128', 2, 60);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'title'   => $product->title,
                    'barcode' => 'data:image/png;base64,' . $barcode
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to generate barcode: ' . $e->getMessage()
            ], 500);
        }
    }
}
