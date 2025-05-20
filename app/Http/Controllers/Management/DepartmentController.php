<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
       public function index()
    {
        $departments = Department::get();
        return view('management.department.index', compact('departments'));
    }

    public function get_data()
    {
        return Department::all();
    }

    public function create()
    {
        return view('management.department.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token','id');
        Department::create($data);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        return view('management.department.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);
        $department->update($request->all());

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Department::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }


}
