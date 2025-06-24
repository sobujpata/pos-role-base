<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
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
            'name'=> 'required|string',
            'description'=> 'required|string',
            'price' => 'required|string',
            'quantity'=> 'required',
        ]);
        // dd($request->all());
        $product = Product::create([
            'name'     => $request->input('name'),
            'description'    => $request->input('description'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
        ]);
        flash()->success('Product created successfully!');
        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product  = Product::find($id);

        // dd($productRole);
        return view('backend.pages.products.update', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'     => 'required|string|max:255',
            'quantity'     => 'required|string|max:255',
            'description'     => 'required|string|max:255',
            
        ]);

        $product = Product::findOrFail($id);

        $product->update([
            'name'=>$request->input('name'),
            'description'=>$request->input('description'),
            'price'=>$request->input('price'),
            'quantity'=>$request->input('quantity'),
        ]);

        
        flash()->success('Product updated successfully!');
        return redirect()->route('products.index');
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
}
