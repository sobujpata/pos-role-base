<?php
namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\CustomerProfile;
use App\Models\ImportProduct;
use App\Models\Product;
use App\Models\ProductCart;
use App\Models\ProductDetail;
use App\Models\ProductReview;
use App\Models\ProductSlider;
use App\Models\ProductWish;
use App\Models\Size;
use App\Models\Tag;
// use Intervention\Image\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function ProductIndex()
    {
        $categories = Category::all();
        $brands     = Brand::all();
        $maxPrice   = Product::pluck('price')->max();
        $products   = Product::with('category', 'brand')->paginate(12);

        return view('home_page_1.products', compact('products', 'categories', 'brands', 'maxPrice'));

    }

    public function filter(Request $request)
    {
        $query = Product::query()->with('category', 'brand');

        // Brand filter
        if ($request->filled('brands')) {
            // comma-separated ids
            $brandIds = explode(',', $request->brands);
            $query->whereIn('brand_id', $brandIds);
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Price filter (0-inclusive)
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('price', [(int) $request->min_price, (int) $request->max_price]);
        }

        // Size filter
        if ($request->filled('size')) {
            $query->whereHas('productDetail', function ($q) use ($request) {
                $q->where('size', 'LIKE', '%' . $request->size . '%');
            });
        }

        // Color filter
        if ($request->filled('color')) {
            $query->whereHas('productDetail', function ($q) use ($request) {
                $q->where('color', 'LIKE', '%' . $request->color . '%');
            });
        }
        // --- Sorting Logic ---
        if ($request->sort == 'popular') {
            $query->where('remark', 'popular');
        } elseif ($request->sort == 'date') {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->sort == 'price') {
            $query->orderBy('discount_price', 'asc');
        } elseif ($request->sort == 'price-desc') {
            $query->orderBy('discount_price', 'desc');
        } else {
            $query->latest(); // default
        }

        $perPage  = $request->perPage ?? 9; // default 9
        $products = $query->paginate($perPage);

        // Return rendered HTML
        return view('home_page_1.partials.product-list', compact('products'))->render();
    }

    public function show($slug)
    {
                                                         // Example slug: samsung-galaxy-s24-15  (15 is the product id)
        $id      = (int) substr(strrchr($slug, '-'), 1); // Get the part after the last dash
        $product = Product::with('productDetail', 'category', 'brand')->findOrFail($id);

        $product_reviews = $product->product_reviews()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        $rating_count = $product_reviews->count();

        $category_id = $product->category_id;

        // dd($category_id);
        $related_products = Product::where('category_id', $category_id)->get();

        return view('home_page_1.details-page', compact('product', 'product_reviews', 'rating_count', 'related_products'));
        // dd($product);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
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
        $remarks    = Product::remark;
        $colors     = Color::all();
        $sizes      = Size::all();
        $tags       = Tag::all();
        return view('backend.pages.products.create', compact('categories', 'brands', 'remarks', 'colors', 'sizes', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     $validatedData = $request->validate([
    //         'title'            => 'required|string|max:255',
    //         'short_des'        => 'required|string|max:255',
    //         'buy_price'        => 'required|numeric',
    //         'price'            => 'required|numeric',
    //         'discount'         => 'required|numeric',
    //         'discount_price'   => 'required|numeric',
    //         'stock'            => 'required|integer',
    //         'star'             => 'required|integer|min:1|max:5',
    //         'remark'           => 'required|string|max:255',
    //         'category_id'      => 'required|integer',
    //         'brand_id'         => 'required|integer',
    //         'capacity'         => 'required|string|max:255',
    //         'water_resistance' => 'required|string|max:255',
    //         'material'         => 'required|string|max:255',
    //         'des'              => 'required|string',
    //         'img1'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:4048',
    //         'img2'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:4048',
    //         'img3'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:4048',
    //         'img4'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:4048',
    //     ]);
    //     $sku = strtoupper(uniqid());

    //     $colors = $request->colors; // array
    //     $colorString = implode(',', $colors);
    //     $tags = $request->tags; // array
    //     $tagString = implode(',', $tags);
    //     $sizes = $request->sizes; // array
    //     $sizeString = implode(',', $sizes);

    //     $imageUrls = [];
    //     $sizes     = [
    //         'normal' => [540, 600],
    //         'zoom'   => [810, 900],
    //     ];

    //     foreach (['img1', 'img2', 'img3', 'img4'] as $imgField) {
    //         if ($request->hasFile($imgField)) {
    //             $file      = $request->file($imgField);
    //             $extension = $file->getClientOriginalExtension();
    //             $timestamp = time();

    //             foreach ($sizes as $prefix => [$w, $h]) {
    //                 $fileName = ($prefix === 'normal' ? '' : $prefix . '-') . $timestamp . '-' . uniqid() . '.' . $extension;
    //                 $path     = storage_path('app/public/products/' . $fileName);

    //                 // Ensure directory exists
    //                 if (! file_exists(dirname($path))) {
    //                     mkdir(dirname($path), 0777, true);
    //                 }

    //                 $image = Image::make($file->getRealPath());
    //                 $image->resize($w, $h)->save($path);

    //                 $imageUrls[$imgField][$prefix] = "storage/products/{$fileName}";
    //             }
    //         }
    //     }

    //     // dd($imageUrls);
    //     try {
    //         DB::beginTransaction();

    //         $product = Product::create([
    //             'title'            => $validatedData['title'],
    //             'short_des'        => $validatedData['short_des'],
    //             'buy_price'        => $validatedData['buy_price'],
    //             'price'            => $validatedData['price'],
    //             'discount'         => $validatedData['discount'],
    //             'discount_price'   => $validatedData['discount_price'],
    //             'stock'            => $validatedData['stock'],
    //             'remark'           => $validatedData['remark'],
    //             'star'             => $validatedData['star'],
    //             'capacity'         => $validatedData['capacity'],
    //             'water_resistance' => $validatedData['water_resistance'],
    //             'material'         => $validatedData['material'],
    //             'sku'              => $sku,
    //             'tags'             => $tagString,
    //             'category_id'      => $validatedData['category_id'],
    //             'brand_id'         => $validatedData['brand_id'],
    //             'image'            => $imageUrls['img1']['normal'] ?? null,
    //         ]);
    //         // dd($product);
    //         $productDetailsData = [
    //             'color' => $colorString,
    //             'size'  => $sizeString,
    //             'des'   => $validatedData['des'],
    //         ];

    //         foreach (['img1', 'img2', 'img3', 'img4'] as $imgField) {
    //             if (! empty($imageUrls[$imgField]['normal'])) {
    //                 $productDetailsData[$imgField] = $imageUrls[$imgField]['normal'];
    //             }
    //         }
    //         foreach (['img1', 'img2', 'img3', 'img4'] as $imgField) {
    //             if (! empty($imageUrls[$imgField]['zoom'])) {
    //                 $productDetailsData['zoom_' . $imgField] = $imageUrls[$imgField]['zoom'];
    //             }
    //         }

    //         ProductDetail::create(array_merge(
    //             ['product_id' => $product->id],
    //             $productDetailsData
    //         ));

    //         DB::commit();
    //         return redirect()->route('products.index')->with('success', 'Product created successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Product create failed: ' . $e->getMessage());
    //         return redirect()->route('products.index')->with('error', 'Product create failed: ' . $e->getMessage());
    //     }
    // }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'            => 'required|string|max:255',
            'short_des'        => 'required|string|max:255',
            'buy_price'        => 'required|numeric',
            'price'            => 'required|numeric',
            'discount'         => 'required|numeric',
            'discount_price'   => 'required|numeric',
            'stock'            => 'required|integer',
            'star'             => 'required|integer|min:1|max:5',
            'remark'           => 'required|string|max:255',
            'category_id'      => 'required|integer',
            'brand_id'         => 'required|integer',
            'capacity'         => 'required|string|max:255',
            'water_resistance' => 'required|string|max:255',
            'material'         => 'required|string|max:255',
            'des'              => 'required|string',
            'img1'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:4048',
            'img2'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:4048',
            'img3'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:4048',
            'img4'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:4048',
        ]);

        $sku = strtoupper(uniqid());

        // Convert arrays to strings
        $colorString = implode(',', $request->colors ?? []);
        $tagString   = implode(',', $request->tags ?? []);
        $sizeString  = implode(',', $request->sizes ?? []);

        // Image sizes
        $imageSizes = [
            'normal' => [540, 600],
            'zoom'   => [810, 900],
        ];

        $imageUrls = [];

        foreach (['img1', 'img2', 'img3', 'img4'] as $imgField) {
            if ($request->hasFile($imgField)) {
                $file      = $request->file($imgField);
                $extension = $file->getClientOriginalExtension();

                foreach ($imageSizes as $prefix => [$width, $height]) {

                    $fileName = ($prefix === 'normal' ? '' : $prefix . '-')
                    . time() . '-' . uniqid() . '.' . $extension;

                    $path = storage_path('app/public/products/' . $fileName);

                    if (! file_exists(dirname($path))) {
                        mkdir(dirname($path), 0755, true);
                    }

                    Image::make($file->getRealPath())
                        ->resize($width, $height, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->save($path);

                    // ✅ STORE RELATIVE PATH ONLY (NO "storage/")
                    $imageUrls[$imgField][$prefix] = "products/{$fileName}";
                }
            }
        }

        try {
            DB::beginTransaction();

            $product = Product::create([
                'title'            => $validatedData['title'],
                'short_des'        => $validatedData['short_des'],
                'buy_price'        => $validatedData['buy_price'],
                'price'            => $validatedData['price'],
                'discount'         => $validatedData['discount'],
                'discount_price'   => $validatedData['discount_price'],
                'stock'            => $validatedData['stock'],
                'remark'           => $validatedData['remark'],
                'star'             => $validatedData['star'],
                'capacity'         => $validatedData['capacity'],
                'water_resistance' => $validatedData['water_resistance'],
                'material'         => $validatedData['material'],
                'sku'              => $sku,
                'tags'             => $tagString,
                'category_id'      => $validatedData['category_id'],
                'brand_id'         => $validatedData['brand_id'],
                'image'            => $imageUrls['img1']['normal'] ?? null,
            ]);

            $productDetailsData = [
                'product_id' => $product->id,
                'color'      => $colorString,
                'size'       => $sizeString,
                'des'        => $validatedData['des'],
            ];

            foreach (['img1', 'img2', 'img3', 'img4'] as $imgField) {
                if (! empty($imageUrls[$imgField]['normal'])) {
                    $productDetailsData[$imgField] = $imageUrls[$imgField]['normal'];
                }
                if (! empty($imageUrls[$imgField]['zoom'])) {
                    $productDetailsData['zoom_' . $imgField] = $imageUrls[$imgField]['zoom'];
                }
            }

            ProductDetail::create($productDetailsData);

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
        $product     = Product::with('productDetail', 'category', 'brand')->find($id);
        $categories  = Category::all();
        $brands      = Brand::all();
        $remarks     = Product::remark;
        $colors      = Color::all();
        $sizes       = Size::all();
        $tags        = Tag::all();
        $savedColors = explode(',', $product->productDetail->color ?? '');
        $savedSizes  = explode(',', $product->productDetail->size ?? '');
        $savedTags   = explode(',', $product->tags ?? '');
        $remarks     = Product::remark;
        // dd($savedTags);
        return view('backend.pages.products.update', compact(
            'product',
            'categories',
            'brands',
            'colors',
            'sizes',
            'tags',
            'savedColors',
            'savedSizes',
            'savedTags',
            'remarks'
        ));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title'            => 'required|string|max:255',
            'short_des'        => 'required|string|max:255',
            'buy_price'        => 'required|numeric',
            'price'            => 'required|numeric',
            'discount'         => 'required|numeric',
            'discount_price'   => 'required|numeric',
            'stock'            => 'required|integer',
            'star'             => 'required|integer|min:1|max:5',
            'remark'           => 'required|string|max:255',
            'category_id'      => 'required|integer',
            'brand_id'         => 'required|integer',
            'capacity'         => 'required|string|max:255',
            'water_resistance' => 'required|string|max:255',
            'material'         => 'required|string|max:255',
            'des'              => 'required|string',
            'img1'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:4048',
            'img2'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:4048',
            'img3'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:4048',
            'img4'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:4048',
        ]);

        $product = Product::findOrFail($id);

        $colorString = implode(',', $request->colors ?? []);
        $tagString   = implode(',', $request->tags ?? []);
        $sizeString  = implode(',', $request->sizes ?? []);

        $imageSizes = [
            'normal' => [540, 600],
            'zoom'   => [810, 900],
        ];

        $imageUrls = [];

        foreach (['img1', 'img2', 'img3', 'img4'] as $imgField) {
            if ($request->hasFile($imgField)) {
                $file      = $request->file($imgField);
                $extension = $file->getClientOriginalExtension();

                foreach ($imageSizes as $prefix => [$w, $h]) {

                    $fileName = ($prefix === 'normal' ? '' : $prefix . '-')
                    . time() . '-' . uniqid() . '.' . $extension;

                    $path = storage_path('app/public/products/' . $fileName);

                    if (! file_exists(dirname($path))) {
                        mkdir(dirname($path), 0755, true);
                    }

                    Image::make($file->getRealPath())
                        ->resize($w, $h, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        })
                        ->save($path);

                    // ✅ store RELATIVE path only
                    $imageUrls[$imgField][$prefix] = "products/{$fileName}";
                }
            }
        }

        try {
            DB::beginTransaction();

            $product->update([
                'title'            => $validatedData['title'],
                'short_des'        => $validatedData['short_des'],
                'buy_price'        => $validatedData['buy_price'],
                'price'            => $validatedData['price'],
                'discount'         => $validatedData['discount'],
                'discount_price'   => $validatedData['discount_price'],
                'stock'            => $validatedData['stock'],
                'remark'           => $validatedData['remark'],
                'star'             => $validatedData['star'],
                'capacity'         => $validatedData['capacity'],
                'water_resistance' => $validatedData['water_resistance'],
                'material'         => $validatedData['material'],
                'tags'             => $tagString,
                'category_id'      => $validatedData['category_id'],
                'brand_id'         => $validatedData['brand_id'],
                'image'            => $imageUrls['img1']['normal'] ?? $product->image,
            ]);

            $detailsData = [
                'color' => $colorString,
                'size'  => $sizeString,
                'des'   => $validatedData['des'],
            ];

            foreach (['img1', 'img2', 'img3', 'img4'] as $imgField) {
                if (! empty($imageUrls[$imgField]['normal'])) {
                    $detailsData[$imgField] = $imageUrls[$imgField]['normal'];
                }
                if (! empty($imageUrls[$imgField]['zoom'])) {
                    $detailsData['zoom_' . $imgField] = $imageUrls[$imgField]['zoom'];
                }
            }

            $product->productDetail()->updateOrCreate(
                ['product_id' => $product->id],
                $detailsData
            );

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

    //Font end
    public function WishList()
    {
        return view('pages.wish-list-page');
    }

    public function CartListPage()
    {
        return view('pages.cart-list-page');
    }

    public function Details()
    {
        return view('pages.details-page');
    }

    public function ListProductByCategory(Request $request): JsonResponse
    {
        $data = Product::where('category_id', $request->id)->with('brand', 'category')->get();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function ListProductByRemark(Request $request): JsonResponse
    {
        $data = Product::where('remark', $request->remark)->with('brand', 'category')->get();

        return ResponseHelper::Out('success', $data, 200);
    }
    public function featuredProducts(Request $request): JsonResponse
    {
        $data = Product::where('remark', 'featured')->get();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function ListProductByBrand(Request $request): JsonResponse
    {
        $data = Product::where('brand_id', $request->id)->with('brand', 'category')->get();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function ListProductSlider(): JsonResponse
    {
        $data = ProductSlider::all();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function ProductDetailById(Request $request): JsonResponse
    {

        $data = ProductDetail::where('product_id', $request->id)->with('product', 'product.brand', 'product.category')->get();

        return ResponseHelper::Out('success', $data, 200);
    }

    public function ListReviewByProduct(Request $request): JsonResponse
    {
        $data = ProductReview::where('product_id', $request->product_id)
            ->with(['profile' => function ($query) {
                $query->select('id', 'cus_name');
            }])->get();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function CreateProductReview(Request $request): JsonResponse
    {
        $user_id = $request->header('id');
        $profile = CustomerProfile::where('user_id', $user_id)->first();

        if ($profile) {
            $request->merge(['customer_id' => $profile->id]);
            $data = ProductReview::updateOrCreate(
                ['customer_id' => $profile->id, 'product_id' => $request->input('product_id')],
                $request->input()
            );
            return ResponseHelper::Out('success', $data, 200);
        } else {
            return ResponseHelper::Out('fail', 'Customer profile not exists', 200);
        }

    }

    public function ProductWishList(Request $request): JsonResponse
    {
        $user_id = $request->header('id');
        $data    = ProductWish::where('user_id', $user_id)->with('product')->get();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function CreateWishList(Request $request): JsonResponse
    {
        $user_id = $request->header('id');
        $data    = ProductWish::updateOrCreate(
            ['user_id' => $user_id, 'product_id' => $request->product_id],
            ['user_id' => $user_id, 'product_id' => $request->product_id],
        );
        return ResponseHelper::Out('success', $data, 200);
    }

    public function RemoveWishList(Request $request)
    {
        $user_id = $request->header('id');
        $data    = ProductWish::where(['user_id' => $user_id, 'product_id' => $request->product_id])->delete();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function CreateCartList(Request $request)
    {
        $user_id    = $request->header('id');
        $product_id = $request->input('product_id');
        $color      = $request->input('color');
        $size       = $request->input('size');
        $qty        = $request->input('qty');

        $UnitPrice = 0;

        $productDetail = Product::where('id', '=', $product_id)->first();
        if ($productDetail->discount == 1) {
            $UnitPrice = $productDetail->discount_price;
        } else {
            $UnitPrice = $productDetail->price;
        }
        $totalPrice = $qty * $UnitPrice;

        $data = ProductCart::updateOrCreate(
            ['user_id' => $user_id, 'product_id' => $product_id],
            [
                'user_id'    => $user_id,
                'product_id' => $product_id,
                'color'      => $color,
                'size'       => $size,
                'qty'        => $qty,
                'price'      => $totalPrice,
            ]
        );

        return ResponseHelper::Out('success', $data, 200);
    }

    public function CartList(Request $request): JsonResponse
    {
        $user_id = $request->header('id');
        $data    = ProductCart::where('user_id', $user_id)->with('product')->get();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function DeleteCartList(Request $request): JsonResponse
    {
        $user_id = $request->header('id');
        $data    = ProductCart::where('user_id', '=', $user_id)->where('product_id', '=', $request->product_id)->delete();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function ImportProductPage()
    {
        return view('backend.pages.products.import-product-page');
    }

    public function ImportProductAll()
    {
        $importProducts = ImportProduct::with('product')->orderBy('created_at', 'desc')->get();
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

    public function ImportProduct(Request $request)
    {
        $user_id = Auth::user()->id;

        // Validation for import product creation
        $validatedData = $request->validate([
            'product_id'   => 'required|integer',
            'import_price' => 'required|numeric',
            'sale_price'   => 'required|numeric',
            'quantity'     => 'required|integer',
        ]);

        try {
            // Save the import product to the database
            $importProduct = ImportProduct::create([
                'user_id'      => $user_id,
                'product_id'   => $request->input('product_id'),
                'import_price' => $request->input('import_price'),
                'sale_price'   => $request->input('sale_price'),
                'quantity'     => $request->input('quantity'),
            ]);

            // Update the product's buy_qty and prices
            $product = Product::find($request->input('product_id'));
            $product->stock += $request->input('quantity');
            $product->buy_price = $request->input('import_price');
            $product->price     = $request->input('sale_price');
            $product->save();

            // Return a success response
            return response()->json(['message' => 'Product imported successfully', 'import_product' => $importProduct], 201);

        } catch (\Exception $e) {
            // Return error response in case of failure
            return response()->json(['message' => 'Product import failed', 'error' => $e->getMessage()], 500);
        }
    }
}
