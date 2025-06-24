<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with('permissions')->latest()->get();
        // dd($roles);
        return view('backend.pages.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('backend.pages.roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:roles,name',
            'permission'=>'required',
        ]);
        $permissionId = array_map('intval', $request->input('permission'));
        $role = Role::create([
            'name'=>$request->input('name'),
        ]);
        $role->syncPermissions($permissionId);
        // Add a success notification
        flash()->success('Role created successfully!');
        return redirect()->route('roles.index');
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
        $permissions = Permission::all();
        $role = Role::with('permissions')->find($id);

        $rolePermissions = $role->permissions->pluck('id')->all();
        // dd($rolePermissions);
        return view('backend.pages.roles.update', compact('permissions', 'role', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
         $request->validate([
            'name'=>'required|unique:roles,name,'.$id,
            'permission'=>'required',
        ]);
        // dd($request->all());
        $role = Role::find($id);
        $role ->name = $request->input('name');
        $role->save();
        $permissionId = array_map('intval', $request->input('permission'));
        $role->syncPermissions($permissionId);
        // Add a success notification
        flash()->success('Role updated successfully!');
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($id);
        Role::find($id)->delete();
        sweetalert()->success('Role deleted successfully.');
        return redirect()->route('roles.index');
    }
}
