<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        
        $color_codes = Color::all();
        return view('backend.pages.color-codes.index', compact('color_codes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.color-codes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'color' => 'required|string|max:50',
            'color_code' => 'nullable|string|max:20',
        ]);

        Color::create([
            'color' => $request->color,
            'color_code' => $request->color_code,
        ]);

        return redirect()->route('colors.index')->with('success', 'Color created successfully.');
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
        $color = Color::findOrFail($id);
        return view('backend.pages.color-codes.edit', compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'color' => 'required|string|max:50',
            'color_code' => 'nullable|string|max:20',
        ]);

        $color = Color::findOrFail($id);
        $color->update([
            'color' => $request->color,
            'color_code' => $request->color_code,
        ]);

        return redirect()->route('colors.index')->with('success', 'Color updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        return redirect()->route('colors.index')->with('success', 'Color deleted successfully.');
    }
}
