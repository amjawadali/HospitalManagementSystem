<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::get();
        return view('management.roles.index', compact('roles'));
    }

    public function get_data()
    {
        return Role::all();
    }


    public function create()
    {
        return view('management.roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name'
        ]);

        Role::create(['name' => $request->name]);
        // Assign default permissions to the new role

        return response()->json(['success' => true]);
    }


    public function edit($id)
    {
        return view('management.roles.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id
        ]);

        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);

        return response()->json(['success' => true]);
    }


    public function destroy($id)
    {
        Role::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

    public function status(Request $request)
    {
        // Change role status logic
    }
}
