<?php

namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ImportProduct;
use App\Models\Product;
// use Intervention\Image\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::all();
        
        if ($request->ajax()) {
            return response()->json($products);
        }
        
        // dd($products);
        return view('backend.pages.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $brands     = Brand::all();
        return view('backend.pages.products.create', compact('categories', 'brands'));
    }    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'            => 'required|string|max:255',
            'short_des'        => 'nullable|string|max:255',
            'original_price'   => 'required|numeric',
            'price'            => 'required|numeric',            
            'discount'         => 'required|numeric',            
            'discount_price'   => 'required|numeric',            
            'stock'            => 'required|integer',            
            'category_id'      => 'required|integer',
            'brand_id'         => 'required|integer',            
            'image'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:4048',
            
        ]);
        do {
            $sku = 'SKU-' . strtoupper(Str::random(6));
        } while (Product::where('sku', $sku)->exists());
        // Check if an image was uploaded
        if ($request->hasFile('image')) {
            $filename              = Str::slug($request->title) . '.' . $request->file('image')->getClientOriginalExtension();
            $path                  = $request->file('image')->storeAs('products', $filename, 'public');
            $imageUrls['image']['normal'] = $path;
        }
        try {
            DB::beginTransaction();

            $product = Product::create([
                'title'            => $validatedData['title'],
                'short_des'        => $validatedData['short_des'],
                'original_price'        => $validatedData['original_price'],
                'price'            => $validatedData['price'],
                'discount'         => $validatedData['discount'],
                'discount_price'   => $validatedData['discount_price'],
                'stock'            => $validatedData['stock'],
                
                'sku'              => $sku,
                'category_id'      => $validatedData['category_id'],
                'brand_id'         => $validatedData['brand_id'],
                'image'            => $imageUrls['image']['normal'] ?? null,
                'user_id'          => auth()->id(),
            ]);

            DB::commit();

            return redirect()
                ->route('products.index')
                ->with('success', 'Product created successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Product create failed', ['error' => $e->getMessage()]);

            return redirect()
                ->route('products.index')
                ->with('error', 'Product create failed');
        }
    }

    public function edit(string $id)
    {
        $product     = Product::with('category', 'brand')->find($id);
        $categories  = Category::all();
        $brands      = Brand::all();     
        
        // dd($savedTags);
        return view('backend.pages.products.update', compact(
            'product',
            'categories',
            'brands',
        ));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title'            => 'required|string|max:255',
            'short_des'        => 'nullable|string|max:255',
            'original_price'   => 'required|numeric',
            'price'            => 'required|numeric',
            'discount'         => 'required|numeric',
            'discount_price'   => 'required|numeric',
            'stock'            => 'required|integer',            
            'category_id'      => 'required|integer',
            'brand_id'         => 'required|integer',
            'image'            => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:4048',
        ]);

        $product = Product::findOrFail($id);
        if ($request->hasFile('image')) {
            $filename              = Str::slug($request->title) . '.' . $request->file('image')->getClientOriginalExtension();
            $path                  = $request->file('image')->storeAs('products', $filename, 'public');
            $imageUrls['image']['normal'] = $path;
        }        
        try {
            DB::beginTransaction();

            $product->update([
                'title'            => $validatedData['title'],
                'short_des'        => $validatedData['short_des'],
                'original_price'   => $validatedData['original_price'],
                'price'            => $validatedData['price'], 
                'discount'         => $validatedData['discount'],
                'discount_price'   => $validatedData['discount_price'],
                'stock'            => $validatedData['stock'],                
                'category_id'      => $validatedData['category_id'],
                'brand_id'         => $validatedData['brand_id'],
                'image'            => $imageUrls['image']['normal'] ?? $product->image,
            ]);

            DB::commit();

            return redirect()
                ->route('products.index')
                ->with('success', 'Product updated successfully!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Product update failed', ['error' => $e->getMessage()]);

            return redirect()
                ->route('products.index')
                ->with('error', 'Product update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::find($id)->delete();
        sweetalert()->success('Product deleted successfully.');
        return redirect()->route('products.index');
    }

    public function ListProductByCategory(Request $request): JsonResponse
    {
        $data = Product::where('category_id', $request->id)->with('brand', 'category')->get();
        return ResponseHelper::Out('success', $data, 200);
    }
    public function ImportProductPage()
    {
        return view('backend.pages.products.import-product-page');
    }

    public function ImportProductAll()
    {
        $importProducts = ImportProduct::with('product', 'user')->orderBy('created_at', 'desc')->get();
        //orderBy('created_at','desc')->get();

        return response()->json([
            'data' => $importProducts,
        ]);
    }

    public function ImportProductList($id)
    {
        $product = Product::find($id);
        return response()->json(['data' => $product], 200);
    }

    

    public function ListProductByBrand(Request $request): JsonResponse
    {
        $data = Product::where('brand_id', $request->id)->with('brand', 'category')->get();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function ImportProduct(Request $request)
    {
        // return response()->json($request->all(), 200);
        $validated = $request->validate([
            'product_id'   => 'required|integer|exists:products,id',
            'import_price' => 'required|numeric|min:0',
            'sale_price'   => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'discount_price' => 'nullable|numeric|min:0',
            'quantity'     => 'required|integer|min:1',
        ]);
        
        try {
            DB::transaction(function () use ($validated) {

                $userId = auth()->id();

                // Lock product row to prevent race conditions
                $product = Product::where('id', $validated['product_id'])
                    ->lockForUpdate()
                    ->first();

                ImportProduct::create([
                    'user_id'      => $userId,
                    'product_id'   => $product->id,
                    'import_price' => $validated['import_price'],
                    'sale_price'   => $validated['sale_price'],
                    'discount' => $validated['discount'],
                    'discount_price' => $validated['discount_price'],
                    'quantity'     => $validated['quantity'],
                ]);

                // Safe stock update
                $product->update([
                    'original_price' => $validated['import_price'],
                    'price'     => $validated['sale_price'],
                    'discount' => $validated['discount'],
                    'discount_price' => $validated['discount_price'],
                    'stock'     => $product->stock + $validated['quantity'],
                ]);
            });

            return response()->json([
                'message' => 'Product imported successfully'
            ], 201);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Product import failed',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }


    public function ImportProductsById(Request $request)
    {
        $user_id = Auth::user()->id;
        $importProduct = ImportProduct::with('product')->find($request->id);

        return response()->json(['data' => $importProduct], 200);
    }

    public function ImportProductsUpdate(Request $request)
    {
        // return response()->json($request->all(), 200);
        $validated = $request->validate([
            'id'           => 'required|integer|exists:import_products,id',
            'product_id'   => 'required|integer|exists:products,id',
            'import_price' => 'required|numeric|min:0',
            'sale_price'   => 'required|numeric|min:0',
            'discount'     => 'nullable|numeric|min:0|max:100',
            'discount_price' => 'nullable|numeric|min:0',
            'quantity'     => 'required|integer|min:1',
        ]);

        try {
            DB::transaction(function () use ($validated) {

                $userId = Auth::user()->id;

                // Lock import product
                $importProduct = ImportProduct::lockForUpdate()
                    ->find($validated['id']);

                // Calculate quantity difference safely
                $oldQuantity = $importProduct->quantity;
                $newQuantity = $validated['quantity'];
                $netIncrease = $newQuantity - $oldQuantity;

                // Update import product
                $importProduct->update([
                    'user_id'      => $userId,
                    'product_id'   => $validated['product_id'],
                    'import_price' => $validated['import_price'],
                    'sale_price'   => $validated['sale_price'],
                    'quantity'     => $newQuantity,
                ]);

                // Lock product row
                $product = Product::lockForUpdate()
                    ->find($validated['product_id']);

                // Update product stock & prices
                $product->update([
                    'original_price' => $validated['import_price'],
                    'price'     => $validated['sale_price'],
                    'discount' => $validated['discount'],
                    'discount_price' => $validated['discount_price'],
                    'stock'     => $product->stock + $netIncrease,
                ]);
            });

            return response()->json([
                'message' => 'Import product updated successfully'
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => 'Import product update failed',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function destroyImportProduct(Request $request)
    {
        $id = $request->id;
        $importProduct = ImportProduct::findOrFail($id);
        $importQuantity = $importProduct->quantity;
        $importProductId = $importProduct->product_id;
        $product = Product::findOrFail($importProductId);
        $product->stock = max(0, $product->stock - $importQuantity);
        $product->save();
        ImportProduct::destroy($id);
        return response()->json(['message' => 'Import product deleted successfully'], 200);
    }
}
