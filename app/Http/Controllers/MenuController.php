<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Subscribe;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\str;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::whereNull('parent_id')
                    ->orderBy('order')
                    ->with('children')
                    ->get();
        return response()->json($menus);
    //     $menus = Menu::with('children.children')->whereNull('parent_id')->orderBy('order')->get();
    // return response()->json($menus);
    }
    public function menuView()
    {
        $menus = Menu::orderBy('order')->get();
        return view('backend.pages.menus.index', compact('menus'));
    }

    public function create()
    {
        $parents = Menu::whereNull('parent_id')->get();
        return view('backend.pages.menus.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'required|integer'
        ]);

        Menu::create($request->all());
        return redirect()->route('menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit(Menu $menu)
    {
        // dd($menu);
        $parents = Menu::whereNull('parent_id')->where('id', '!=', $menu->id)->get();
        return view('backend.pages.menus.edit', compact('menu', 'parents'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:menus,id',
            'order' => 'required|integer'
        ]);

        $menu->update($request->all());
        return redirect()->route('menus.index')->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu deleted successfully.');
    }

    public function popupShow()
    {
        $popup = Subscribe::first();

        return response()->json($popup);
    }

    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        // Store the email in the database
        Subscriber::create($request->only('email'));

        return response()->json(['message' => 'Subscribed successfully!']);
    }

    public function subscribePage(Request $request){
        $pages = Subscribe::orderBy('created_at','desc')->get();
        return view('backend.pages.subscribe-notice.index', compact('pages'));
    }
    public function subscribePageEdit(Request $request, $id){
        // dd($id);
        $page = Subscribe::find( $id );
        return view('backend.pages.subscribe-notice.edit', compact('page'));
    }
    public function subscribePageUpdate(Request $request, $id){
        $page = Subscribe::find( $id );
        // dd($page);
        $page->title = $request->title;
        $page->short_des = $request->short_des;
        if ($request->hasFile('image')) {
            // Optionally delete old image
            if ($page->image && Storage::disk('public')->exists($page->image)) {
                Storage::disk('public')->delete($page->image);
            }

            // Store new image
            $filename              = Str::slug($request->title) . '.' . $request->file('image')->getClientOriginalExtension();
            $path                  = $request->file('image')->storeAs('notice', $filename, 'public');
            $page->image = $path;
        }
        $page->save();

        return redirect()->route('subscribe-notice.index')->with('success','Updated successfully.');

    }
}
