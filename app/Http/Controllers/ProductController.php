<?php
namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CustomerProfile;
use App\Models\Product;
use App\Models\ProductCart;
use App\Models\ProductDetail;
use App\Models\ProductReview;
use App\Models\ProductSlider;
use App\Models\ProductWish;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
// use Intervention\Image\Image;
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

        if ($request->brands) {
            $query->whereIn('brand_id', explode(',', $request->brands));
        }
        if ($request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->min_price && $request->max_price) {
            $query->whereBetween('price', [$request->min_price, $request->max_price]);
        }
        if ($request->size) {
            $query->whereHas('productDetail', function ($q) use ($request) {
                $q->where('size', 'LIKE', '%' . $request->size);
            });
        }

        if ($request->color) {
            $query->whereHas('productDetail', function ($q) use ($request) {
                $q->where('color', 'LIKE', '%' . $request->color . '%');
            });
        }

        $products = $query->paginate(12);

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

        return view('home_page_1.details-page', compact('product', 'product_reviews', 'rating_count'));
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
        return view('backend.pages.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name'        => 'required|string',
            'description' => 'required|string',
            'price'       => 'required|string',
            'quantity'    => 'required',
        ]);
        // dd($request->all());
        $product = Product::create([
            'name'        => $request->input('name'),
            'description' => $request->input('description'),
            'price'       => $request->input('price'),
            'quantity'    => $request->input('quantity'),
        ]);
        flash()->success('Product created successfully!');
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product    = Product::with('productDetail', 'category', 'brand')->find($id);
        $categories = Category::all();
        $brands     = Brand::all();

        // dd($product);
        return view('backend.pages.products.update', compact('product', 'categories', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        // dd($request->all());
         $validatedData = $request->validate([
        'title'            => 'required|string|max:255',
        'short_des'        => 'required|string|max:255',
        'price'            => 'required|string|max:255',
        'discount'         => 'required|string|max:255',
        'discount_price'   => 'required|string|max:255',
        'stock'            => 'required|string|max:255',
        'star'             => 'required|string|max:255',
        'remark'           => 'required|string|max:255',
        'category_id'      => 'required|string|max:255',
        'brand_id'         => 'required|string|max:255',
        'sku'              => 'required|string|max:255',
        'tags'             => 'required|string|max:255',
        'capacity'         => 'required|string|max:255',
        'water_resistance' => 'required|string|max:255',
        'material'         => 'required|string|max:255',
        'color'            => 'required|string|max:255',
        'size'             => 'required|string|max:255',
        'des'              => 'required|string',
        'img1'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:2048',
        'img2'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:2048',
        'img3'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:2048',
        'img4'             => 'sometimes|image|mimes:jpeg,png,jpg,webp|max:2048',
    ]);

    $imageUrls = [];
    $sizes = [
        'normal' => [540, 600],
        'zoom'   => [810, 900],
    ];

    // Handle multiple image uploads
    foreach (['img1', 'img2', 'img3', 'img4'] as $imgField) {
        if ($request->hasFile($imgField)) {
            $file = $request->file($imgField);
            $originalName = $file->getClientOriginalName();
            $timestamp = time();

            foreach ($sizes as $prefix => [$w, $h]) {
                $fileName = ($prefix === 'normal' ? '' : $prefix . '-') . $timestamp . '-' . $originalName;
                $path = public_path('products' . DIRECTORY_SEPARATOR . $fileName);

                $image = Image::make($file->getRealPath());
                $image->resize($w, $h)->save($path);

                $imageUrls[$imgField][$prefix] = "products/{$fileName}";
            }
        }
    }

    // Fetch existing product
    $product = Product::find($id);
    if (!$product) {
        return redirect()->route('products.index')->with('error', 'Product not found.');
    }

    try {
        DB::beginTransaction();

        // Update product
        $product->update([
            'title'            => $validatedData['title'],
            'short_des'        => $validatedData['short_des'],
            'price'            => $validatedData['price'],
            'discount'         => $validatedData['discount'],
            'discount_price'   => $validatedData['discount_price'],
            'stock'            => $validatedData['stock'],
            'remark'           => $validatedData['remark'],
            'star'             => $validatedData['star'],
            'capacity'         => $validatedData['capacity'],
            'water_resistance' => $validatedData['water_resistance'],
            'material'         => $validatedData['material'],
            'sku'              => $validatedData['sku'],
            'tags'             => $validatedData['tags'],
            'category_id'      => $validatedData['category_id'],
            'brand_id'         => $validatedData['brand_id'],
            'image'            => $imageUrls['img1']['normal'] ?? $product->image,
        ]);

        // Prepare product details data
        $productDetailsData = [
            'color' => $validatedData['color'],
            'size'  => $validatedData['size'],
            'des'   => $validatedData['des'],
        ];

        foreach (['img1','img2','img3','img4'] as $imgField) {
            if (!empty($imageUrls[$imgField]['normal'])) {
                $productDetailsData[$imgField] = $imageUrls[$imgField]['normal'];
            }
        }

        // Update or create product details
        $product->productDetail()->updateOrCreate(
            ['product_id' => $product->id],
            $productDetailsData
        );

        DB::commit();

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Product update failed: ' . $e->getMessage());
        return redirect()->route('products.index')->with('error', 'Product update failed: ' . $e->getMessage());
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
}
