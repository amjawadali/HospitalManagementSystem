<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Http\Requests\Patient\PatientRequest;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Patient;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    public function index()
    {
            $patients = Patient::get();


        return view('patient.index', compact('patients'));
    }

    public function create()
    {
        $roles = Role::get();
        $departments = Department::get();
        $designations = Designation::get();

        return view('patient.create', compact('roles', 'departments', 'designations'));
    }
    public function store(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'role_id' => 4,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $data = $request->except('password');

        $user->assignRole('doctor');

        try{
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/patients'), $filename);
                $data['profile_image'] = 'images/patients/' . $filename;
            }
            $data['user_id'] = $user->id;

            Patient::create($data);

            toastr()->success('Patient Created successfully.');
        }
        catch (\Exception $e) {
            toastr()->error($e->getMessage());
        }


        return redirect()->route('patient.index');
    }
    public function edit($id)
    {
        $patient = Patient::findOrFail($id);

        return view('patient.update', compact('patient'));
    }

    public function update(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        $data = $request->all();

        try {
            if ($request->hasFile('profile_image')) {
                // Optionally delete old image
                if ($patient->profile_image && file_exists(public_path($patient->profile_image))) {
                    unlink(public_path($patient->profile_image));
                }
                $file = $request->file('profile_image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/patients'), $filename);
                $data['profile_image'] = 'images/patients/' . $filename;
            } else {
                // Prevent overwriting profile_image with null if not uploading a new image
                unset($data['profile_image']);
            }

            $patient->update($data);

            toastr()->success('Patient updated successfully.');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
        }

        return redirect()->route('patient.index');
    }

    public function destroy($id)
    {
        try {
            $patient = Patient::findOrFail($id);
            if ($patient->profile_image && file_exists(public_path($patient->profile_image))) {
                unlink(public_path($patient->profile_image));
            }
            $patient->delete();
            $user = User::findOrFail($patient->user_id);
            $user->delete();

            toastr()->success('Patient deleted successfully.');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
        }

        return redirect()->route('patient.index');
    }

    public function medicalHistory($id)
    {
        $patient = Patient::findOrFail($id);

        // Assuming relation is 'checkins' (plural)
        $data = $patient->checkins()->with(['vitals', 'chiefComplaint', 'medicalHistory', 'medicalCondition'])->get();

        return view('patient.medical_history', compact('patient', 'data'));
    }


}
