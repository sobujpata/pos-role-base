<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = size::all();
        return view('backend.pages.sizes.index', compact('sizes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.sizes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'size' => 'required|string|max:50',
            'short_name' => 'nullable|string|max:20',
        ]);

        Size::create([
            'size' => $request->size,
            'short_name' => $request->short_name,
        ]);

        return redirect()->route('sizes.index')->with('success', 'size created successfully.');
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
        $size = Size::findOrFail($id);
        return view('backend.pages.sizes.edit', compact('size'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'size' => 'required|string|max:50',
            'short_name' => 'nullable|string|max:20',
        ]);

        $size = Size::findOrFail($id);
        $size->update([
            'size' => $request->size,
            'short_name' => $request->short_name,
        ]);

        return redirect()->route('sizes.index')->with('success', 'size updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        return redirect()->route('sizes.index')->with('success', 'size deleted successfully.');
    }
}
