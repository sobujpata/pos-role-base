<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::all();

        return view('backend.pages.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:permissions,name',
            'guard_name'=>'required',
        ]);
        Permission::create([
            'name'=>$request->input('name'),
            'guard_name'=>$request->input('guard_name')
        ]);
        // Add a success notification
        flash()->success('Permission created successfully!');
        return redirect()->route('permission.index');
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
        $permission = Permission::find($id);
        return view('backend.pages.permissions.update', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|unique:permissions,name'
        ]);
        $permission = Permission::find($id);
        $permission->update([
            'name'=>$request->input('name')
        ]);
        // Add a success notification
        flash()->success('Permission updated successfully!');
        return redirect()->route('permission.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Permission::find($id)->delete();
        sweetalert()->success(message: 'Permission deleted successfully.');
        return redirect()->route('permission.index');
    }
}
