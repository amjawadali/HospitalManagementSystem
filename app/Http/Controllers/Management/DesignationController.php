<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index()
    {
        
        $designations = Designation::get();
        return view('management.designation.index', compact('designations'));
    }

    public function get_data()
    {
        return Designation::all();
    }

    public function create()
    {
        return view('management.designation.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token','id');
        Designation::create($data);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        return view('management.designation.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $designation = Designation::findOrFail($id);
        $designation->update($request->all());

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Designation::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
