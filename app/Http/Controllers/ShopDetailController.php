<?php

namespace App\Http\Controllers;

use App\Models\ShopDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Support\Facades\Storage;

class ShopDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shop = ShopDetail::first();
        return view('backend.pages.shop-details.index', compact('shop'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $shopDetails = ShopDetail::first();
        return response()->json($shopDetails);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShopDetail $shopDetail)
    {
        $shop = ShopDetail::first() ?? $shopDetail;
        return view('backend.pages.shop-details.index', compact('shop'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ShopDetail $shopDetail)
    {
        $validated = $request->validate([
            'shop_name'    => 'required|string|max:100',
            'shop_email'   => 'nullable|email|max:100',
            'shop_phone'   => 'nullable|string|max:100',
            'shop_address' => 'nullable|string|max:255',
            'logo_text'    => 'required|string|max:50',
            'logo'         => 'nullable|image|mimes:jpeg,png,gif,webp|max:2048',
        ]);

        // Get the shop (either from route parameter or first record)
        $shop = $shopDetail->id ? $shopDetail : ShopDetail::first();
        
        if (!$shop) {
            // If no shop exists, create one
            $shop = ShopDetail::create([
                'shop_name' => $validated['shop_name'],
                'logo_text' => $validated['logo_text'],
                'shop_email' => $validated['shop_email'] ?? null,
                'shop_phone' => $validated['shop_phone'] ?? null,
                'shop_address' => $validated['shop_address'] ?? null,
                'logo' => null,
            ]);
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($shop->logo && Storage::disk('public')->exists($shop->logo)) {
                Storage::disk('public')->delete($shop->logo);
            }

            // Upload new logo
            $validated['logo'] = $request->file('logo')
                ->store('shop-logos', 'public');
        }
        
        // Update shop details
        $shop->update($validated);

        return redirect()
            ->route('shop-details.edit')
            ->with('success', 'Shop details updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShopDetail $shopDetail)
    {
        $shop = ShopDetail::first() ?? $shopDetail;

        try {
            // Delete logo file if exists
            if ($shop->logo && Storage::disk('public')->exists($shop->logo)) {
                Storage::disk('public')->delete($shop->logo);
            }

            // Delete shop record
            $shop->delete();

            return redirect()->route('shop-details.index')
                ->with('success', 'Shop details deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('shop-details.index')
                ->with('error', 'Failed to delete shop details. Please try again.');
        }
    }
}
