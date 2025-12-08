<?php
namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Category;
use App\Models\MainCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function ByCategoryPage()
    {
        return view('pages.product-by-category');
    }

    public function CategoryList(): JsonResponse
    {
        $data = Category::all();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function index()
    {
        $categories = Category::with('mainCategory')->get();

        return view('backend.pages.categories.index', compact('categories'));
    }
    public function create()
    {
        // Fetch all main categories for the dropdown
        $mainCategories = MainCategory::all();
        return view('backend.pages.categories.create', compact('mainCategories'));
    }
    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'categoryName' => 'required|string|max:255',
            'categoryImg'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'mainCategory' => 'required|exists:main_categories,id', // Ensure main category exists
        ]);
        // dd($request->all());
        // Create a new Category instance
        $category                   = new Category();
        $category->categoryName     = $request->categoryName;
        $category->main_category_id = $request->mainCategory; // Set the main category ID
                                                              // Check if an image was uploaded
        if ($request->hasFile('categoryImg')) {
            $filename              = Str::slug($request->categoryName) . '.' . $request->file('categoryImg')->getClientOriginalExtension();
            $path                  = $request->file('categoryImg')->storeAs('categories', $filename, 'public');
            $category->categoryImg = $path;
        }
        // dd($category);
        // Save the category to the database
        $category->save();

        // Redirect with success message
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(Request $request, $id)
    {

        $category       = Category::find($id);
        $mainCategories = MainCategory::all();
        // dd($category);
        return view('backend.pages.categories.edit', compact('category', 'mainCategories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'categoryName' => 'required|string|max:255',
            'categoryImg'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'mainCategory' => 'required|exists:main_categories,id', // Ensure main category exists
        ]);

        $category                   = Category::find($id);
        $category->categoryName     = $request->categoryName;
        $category->main_category_id = $request->mainCategory; // Update the main category ID

        if ($request->hasFile('categoryImg')) {
            // Optionally delete old image
            if ($category->categoryImg && Storage::disk('public')->exists($category->categoryImg)) {
                Storage::disk('public')->delete($category->categoryImg);
            }

            // Store new image
            $filename              = Str::slug($request->categoryName) . '.' . $request->file('categoryImg')->getClientOriginalExtension();
            $path                  = $request->file('categoryImg')->storeAs('categories', $filename, 'public');
            $category->categoryImg = $path;
        }

        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        // Optionally delete the image file
        if ($category->categoryImg && Storage::disk('public')->exists($category->categoryImg)) {
            Storage::disk('public')->delete($category->categoryImg);
        }

        // Delete the category
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    public function CategoryMainNav()
    {
        // Fetch first 4 main categories in one query
        $mainCategories = MainCategory::take(4)->get();

        // Create an array to store subcategories
        $subCategories = [];

        foreach ($mainCategories as $mainCategory) {
            $subCategories[$mainCategory->id] = Category::where('main_category_id', $mainCategory->id)->take(5)->get();
        }

        return response()->json([
            'mainCategories' => $mainCategories,
            'subCategories'  => $subCategories,
        ]);
    }

    public function MenuBannersForProducts()
    {
        // Fetch menu banners for products
        $menuBanners = \App\Models\MenuBanner::where('status', 'active')->orderBy('order', 'asc')->get();

        return response()->json($menuBanners);
    }

    public function MainIndex()
    {
        $categories = MainCategory::all();

        return view('backend.pages.main-categories.index', compact('categories'));
    }
    public function MainCreate()
    {
        // Fetch all main categories for the dropdown
        return view('backend.pages.main-categories.create');
    }
    public function MAinStore(Request $request)
    {
        // Validate form data
        $request->validate([
            'categoryName' => 'required|string|max:255',
            'categoryImg'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4048',
        ]);
        
        if ($request->hasFile('categoryImg')) {
            $filename              = Str::slug($request->categoryName) . '.' . $request->file('categoryImg')->getClientOriginalExtension();
            $path                  = $request->file('categoryImg')->storeAs('categories', $filename, 'public');
           
        }
        
        MainCategory::create([
            'categoryName' => $request->categoryName,
            'categoryImg'  => $path,
        ]);

        // Redirect with success message
        return redirect()->route('MainCategories.index')->with('success', 'Main category created successfully.');
    }
    public function MainEdit(Request $request, $id)
    {

        $category = MainCategory::find($id);

        return view('backend.pages.main-categories.edit', compact('category'));
    }

    public function MainUpdate(Request $request, $id)
    {
        $request->validate([
            'categoryName' => 'required|string|max:255',
            'categoryImg'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4048',
        ]);

        $category               = MainCategory::find($id);
        $category->categoryName = $request->categoryName;
        if ($request->hasFile('categoryImg')) {
            // Optionally delete old image
            if ($category->categoryImg && Storage::disk('public')->exists($category->categoryImg)) {
                Storage::disk('public')->delete($category->categoryImg);
            }

            // Store new image
            $filename              = Str::slug($request->categoryName) . '.' . $request->file('categoryImg')->getClientOriginalExtension();
            $path                  = $request->file('categoryImg')->storeAs('categories', $filename, 'public');
            $category->categoryImg = $path;
        }

        $category->save();

        return redirect()->route('MainCategories.index')->with('success', 'Main Category updated successfully.');
    }

    public function MainDestroy(Request $request, MainCategory $category)
    {
        // dd($category);
        // Optionally delete the image file
        if ($category->categoryImg && Storage::disk('public')->exists($category->categoryImg)) {
            Storage::disk('public')->delete($category->categoryImg);
        }

        // Delete the category
        $category->delete();

        return redirect()->route('MainCategories.index')->with('success', 'Main Category deleted successfully.');
    }

}