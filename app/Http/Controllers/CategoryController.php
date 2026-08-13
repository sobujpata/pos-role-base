<?php
namespace App\Http\Controllers;

use App\Helper\ResponseHelper;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function CategoryList(): JsonResponse
    {
        $data = Category::all();
        return ResponseHelper::Out('success', $data, 200);
    }

    public function index()
    {
        $categories = Category::all();

        return view('backend.pages.categories.index', compact('categories'));
    }
    public function create()
    {
        
        return view('backend.pages.categories.create');
    }
    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'categoryName' => 'required|string|max:255',
            'categoryImg'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);
        // dd($request->all());
        // Create a new Category instance
        $category                   = new Category();
        $category->categoryName     = $request->categoryName;
        $category->user_id = auth()->id(); // Set the user ID
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
        return view('backend.pages.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'categoryName' => 'required|string|max:255',
            'categoryImg'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            // 'mainCategory' => 'required|exists:main_categories,id', // Ensure main category exists
        ]);

        $category                   = Category::find($id);
        $category->categoryName     = $request->categoryName;
        $category->user_id = auth()->id(); // Update the user ID

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

}