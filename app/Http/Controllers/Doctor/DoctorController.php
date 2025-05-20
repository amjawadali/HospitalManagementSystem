<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Doctor;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::get();

        return view('doctor.index', compact('doctors'));
    }

    public function create()
    {
        $roles = Role::get();
        $departments = Department::get();
        $designations = Designation::get();

        return view('doctor.create', compact('roles', 'departments', 'designations'));
    }
    public function store(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'role_id' => 2,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $data = $request->except('password');

        $user->assignRole('doctor');

        try {
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/doctors'), $filename);
                $data['profile_image'] = 'images/doctors/' . $filename;
            }

            $data['user_id'] = $user->id;
            Doctor::create($data);

            toastr()->success('doctor Created successfully.');
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
        }


        return redirect()->route('doctor.index');
    }
    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        $departments = Department::get();
        $designations = Designation::get();
        return view('doctor.update', compact('doctor', 'departments', 'designations'));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        $data = $request->all();



        try {
            // Handle profile image update
            if ($request->hasFile('profile_image')) {
                if ($doctor->profile_image && file_exists(public_path($doctor->profile_image))) {
                    unlink(public_path($doctor->profile_image));
                }
                $file = $request->file('profile_image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/doctors'), $filename);
                $data['profile_image'] = 'images/doctors/' . $filename;
            } else {
                unset($data['profile_image']);
            }

            // Update password if provided
            if ($request->filled('password')) {
                $doctor->user->password = bcrypt($request->password);
                $doctor->user->save();
            }

            $doctor->update($data);

            toastr()->success('doctor updated successfully.');
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
        }

        return redirect()->route('doctor.index');
    }

    public function destroy($id)
    {
        try {
            $doctor = Doctor::findOrFail($id);
            if ($doctor->profile_image && file_exists(public_path($doctor->profile_image))) {
                unlink(public_path($doctor->profile_image));
            }
            $doctor->user->delete();
            $doctor->delete();
            toastr()->success('doctor deleted successfully.');
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
        }

        return redirect()->route('doctor.index');
    }
}
