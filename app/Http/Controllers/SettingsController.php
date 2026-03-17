<?php

namespace App\Http\Controllers;

use App\Models\Subscribe;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('backend.pages.settings.index');
    }

    public function updatePopUp(Request $request)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'id'        => 'required|exists:subscribes,id',
            'title'     => 'required|string|max:255',
            'short_des' => 'required|string|max:500',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // dd($request->all());
        if ($request->image) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            //storage as storage/app/public/all images
            $request->file('image')->storeAs('popup_images', $imageName, 'public');
            $validatedData['image'] = 'popup_images/' . $imageName;
            

        }
        Subscribe::updateOrCreate(
            ['id' => $validatedData['id']],
            $validatedData        
        );
            
            return redirect()->back()->with('success', 'Pop-up updated successfully.');

    }
}
