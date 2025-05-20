<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Module;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder

{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            'SuperAdmin',
            'Doctor',
            'Receptionist',
            'Patient',
            'Staff',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        $role = Role::where('name', 'SuperAdmin')->first();

        $user = User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'phone' => '1234567890',
            'address' => '123 Admin St, Admin City',
            'email' => 'jawad@admin.com',
            'password' => bcrypt('123456'),
            'role_id' => $role->id,
            'branch_id' => 1,
        ]);


        $role->givePermissionTo(Permission::all());
        $user->assignRole($role);


        $role = Role::where('name', 'Patient')->first();

        $patient = User::create([
            'name' => 'Patient',
            'username' => 'patient',
            'phone' => '2424234',
            'address' => '123 Admin St, Admin City',
            'email' => 'patient@hospital.com',
            'password' => bcrypt('123456'),
            'role_id' => 4,
            'branch_id' => 1,
        ]);

        Patient::create([

            'name' => 'Patinet',
            'patient_code' => 'P0001',
            'age' => 30,
            'cnic' => '12345-6789012-3',
            'profile_image' => null,
            'user_id' => $patient->id,
            'date_of_birth' => '1994-01-01',
            'gender' => 'Male',
            'contact_number' => '2424234',
            'email' => 'patient@admin.com',
            'address' => '123 Admin St, Admin City',
            'emergency_contact_name' => 'John Doe',
            'emergency_contact_number' => '9876543210',
            'blood_type' => 'A+',
            'allergies' => null,
            'registration_date' => now(),
            'last_visit_date' => null,
        ]);

        // Find the User Management module IDs
        $userManagementModuleIds = Module::whereIn('module_name', ['User Management', 'Doctor Management','Patient Management'])->pluck('id');

        // Get all permissions EXCEPT those in the User Management, Doctor Management, and Patient Management modules
        $doctorPermissions = Permission::whereNotIn('module_id', $userManagementModuleIds)->get();

        // Assign these permissions to the Doctor role
        $role->syncPermissions($doctorPermissions);

        // Assign the role to the doctor user
        $patient->assignRole($role);


        // First, create the doctor role if it doesn't exist
        $role = Role::where('name', 'Doctor')->first();
        if (!$role) {
            $role = Role::create(['name' => 'Doctor']);
        }

        // Create doctor user
        $doctor = User::create([
            'name' => 'Doctor Name',
            'username' => 'doctor',
            'phone' => '9876543210',
            'address' => '456 Medical Dr, Health City',
            'email' => 'doctor@hospital.com',
            'password' => bcrypt('123456'),
            'role_id' => 2, // Assuming 2 is the role_id for doctors
            'branch_id' => 1,
        ]);

        // Create doctor profile record
        Doctor::create([
            'name' => 'Doctor Name',
            'profile_image' => null,
            'user_id' => $doctor->id,
            'contact_number' => '9876543210',
            'email' => 'doctor@hospital.com',
            'department_id' => 1,
            'designation_id' => 1,
            'status' => 'Active',
        ]);

        // Find the User Management module ID
        $userManagementModuleId = Module::where('module_name', 'User Management')->first()->id;

        // Get all permissions EXCEPT those in the User Management module
        $doctorPermissions = Permission::where('module_id', '!=', $userManagementModuleId)->get();

        // Assign these permissions to the Doctor role
        $role->syncPermissions($doctorPermissions);

        // Assign the role to the doctor user
        $doctor->assignRole($role);
    }
}
