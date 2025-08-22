<?php

namespace App\Http\Controllers;

use App\Models\ProductReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        // Validate inputs
        $validated = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'message' => 'required|string|max:1000',
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
        ]);
        

        // Store in DB
        ProductReview::create([
            'rating'          => $validated['rating']*20,
            'description'     => $validated['message'],
            'customer_name'   => $validated['name'],
            'customer_email'  => $validated['email'],
            'product_id'      => $request->input('product_id'), // Assuming product_id is passed in the request
        ]);
        flash()->success('Thank you! Your review has been submitted.');

        return redirect()->back()->with('success', 'Thank you! Your review has been submitted.');
    }
}
