<?php
namespace App\Http\Controllers;
use App\Models\Brand;
use Illuminate\Support\Str;
use App\Helper\ResponseHelper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('backend.pages.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('backend.pages.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'brandName' => 'required|string|max:255',
            'brandImg'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $brand = new Brand();
        $brand->brandName = $request->brandName;
        $brand->user_id = auth()->id();

        if ($request->hasFile('brandImg')) {
            $filename          = Str::slug($request->brandName) . '.' . $request->file('brandImg')->getClientOriginalExtension();
            $path              = $request->file('brandImg')->storeAs('brands', $filename, 'public');
            $brand->brandImg = $path;
        }

        $brand->save();

        return redirect()->route('brand.index')->with('success', 'Brand created successfully.');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('backend.pages.brands.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'brandName' => 'required|string|max:255',
            'brandImg'  => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $brand = Brand::findOrFail($id);
        $brand->brandName = $request->brandName;
        $brand->user_id = auth()->id();

        if ($request->hasFile('brandImg')) {
            if ($brand->brandImg && Storage::disk('public')->exists($brand->brandImg)) {
                Storage::disk('public')->delete($brand->brandImg);
            }
            $filename          = Str::slug($request->brandName) . '.' . $request->file('brandImg')->getClientOriginalExtension();
            $path              = $request->file('brandImg')->storeAs('brands', $filename, 'public');
            $brand->brandImg = $path;
        }

        $brand->save();

        return redirect()->route('brand.index')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Request $request, Brand $brand)
    {
        // dd($brand);
        // Optionally delete the image file
        if ($brand->brandImg && Storage::disk('public')->exists($brand->brandImg)) {
            Storage::disk('public')->delete($brand->brandImg);
        }

        // Delete the brand
        $brand->delete();

        return redirect()->route('brand.index')->with('success', 'Brand deleted successfully.');
    }   
    public function BrandList():JsonResponse
    {
        $data= Brand::all();
        return ResponseHelper::Out('success',$data,200);
    }
}
