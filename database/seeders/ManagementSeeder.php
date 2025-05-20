<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class ManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'department_name' => 'Human Resources',
                'department_status' => 1,
            ],
            [
                'department_name' => 'Information Technology',
                'department_status' => 1,
            ],
        ];
        foreach ($departments as $department) {
            Department::create($department);
        }

        $designations = [
            [
                'designation_name' => 'Manager',
                'designation_status' => 1,
            ],
            [
                'designation_name' => 'Developer',
                'designation_status' => 1,
            ],
        ];
        foreach ($designations as $designation) {
            Designation::create($designation);
        }
        $branches = [
            [
            'branch_name' => 'Islamabad',
            'branch_status' => 1,
            ],
            [
            'branch_name' => 'Peshawar',
            'branch_status' => 1,
            ],
        ];

        foreach ($branches as $branch) {
            Branch::create($branch);
        }

    }
}
