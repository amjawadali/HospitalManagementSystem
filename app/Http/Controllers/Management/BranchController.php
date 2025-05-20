<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
     public function index()
    {
        $branches = Branch::get();
        return view('management.branch.index', compact('branches'));
    }

    public function get_data()
    {
        return Branch::all();
    }

    public function create()
    {
        return view('management.branch.create');
    }

    public function store(Request $request)
    {
        $data = $request->except('_token','id');
        Branch::create($data);

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        return view('management.branches.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $branch = Branch::findOrFail($id);
        $branch->update($request->all());

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Branch::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }

}
