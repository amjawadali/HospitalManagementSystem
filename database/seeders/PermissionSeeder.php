<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\SubModule;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            // 1,2,3,4,5,6,7,8,9
            [
                'module_name' => 'User Management',
                'submodules' => [
                    ['submodule_name' => 'User', 'permissions' => ['user.list', 'user.create', 'user.update', 'user.delete']],
                    ['submodule_name' => 'Role', 'permissions' => ['role.list', 'role.create', 'role.update', 'role.delete']],
                    ['submodule_name' => 'Permission', 'permissions' => ['permission.list', 'permission.create', 'permission.update', 'permission.delete']],
                    ['submodule_name' => 'Branch', 'permissions' => ['branch.list', 'branch.create', 'branch.update', 'branch.delete']],
                    ['submodule_name' => 'Department', 'permissions' => ['department.list', 'department.create', 'department.update', 'department.delete']],
                    ['submodule_name' => 'Designation', 'permissions' => ['designation.list', 'designation.create', 'designation.update', 'designation.delete']],
                ],

            ],
            [
                'module_name' => 'Doctor Management',
                'submodules' => [
                    ['submodule_name' => 'Doctor', 'permissions' => ['doctor.list', 'doctor.create', 'doctor.update', 'doctor.delete']],
                    ['submodule_name' => 'Schedule', 'permissions' => ['schedule.list', 'schedule.create', 'schedule.update', 'schedule.delete']],
                ],
            ],
            [
                'module_name' => 'Patient Management',
                'submodules' => [
                    ['submodule_name' => 'Patient', 'permissions' => ['patient.list', 'patient.create', 'patient.update', 'patient.delete']],
                ],
            ],
            [
                'module_name' => 'Appointment Management',
                'submodules' => [
                    ['submodule_name' => 'Appointment', 'permissions' => ['appointment.list', 'appointment.create', 'appointment.update', 'appointment.delete']],
                    ['submodule_name' => 'Prescription', 'permissions' => ['prescription.list', 'prescription.create', 'prescription.update', 'prescription.delete']],
                    ['submodule_name' => 'Doctor Availability', 'permissions' => ['doctor_availability.list', 'doctor_availability.create', 'doctor_availability.update', 'doctor_availability.delete']],
                    ['submodule_name' => 'Approved Appointments', 'permissions' => ['approved_appointments.list', 'approved_appointments.create', 'approved_appointments.update', 'approved_appointments.delete']],
                ],
            ],
            [
               'module_name' => 'Doctor Consultation',
               'submodules' => [
                   ['submodule_name' => 'Checkin', 'permissions' => ['checkin.list', 'checkin.create', 'checkin.update', 'checkin.delete']],
               ]
           ]

        ];

        foreach ($modules as $module) {
            $submodules = $module['submodules'];
            foreach ($submodules as $submodule) {
                $submodule['submodule_name'];
                foreach ($submodule['permissions'] as $permission) {
                }
            }
        }

        foreach ($modules as $moduleData) {
            $module = Module::create([
                'module_name' => $moduleData['module_name']
            ]);

            foreach ($moduleData['submodules'] as $submoduleData) {
                $submodule = SubModule::create([
                    'module_id' => $module->id,
                    'submodule_name' => $submoduleData['submodule_name']
                ]);

                foreach ($submoduleData['permissions'] as $permission) {
                    Permission::create([
                        'module_id' => $module->id,
                        'submodule_id' => $submodule->id,
                        'permission_name' => Str::snake($submoduleData['submodule_name']),
                        'name' => $permission
                    ]);
                }
            }
        }
    }
}
