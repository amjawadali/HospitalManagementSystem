<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Management\UserRequest;
use App\Models\Branch;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use App\Repositories\UserManagement\Users\UserRepository;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('id', '!=', 1)->with('role', 'department', 'designation', 'branch')->get();
        $roles = Role::get();
        $branches = Branch::get();
        $departments = Department::get();
        $designations = Designation::get();
        return view('management.users.index', get_defined_vars());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $this->userRepository->storeUser($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->userRepository->findUser($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        return view('management.users.update', [
            'user' => $this->userRepository->findUser($id),
            'roles' => Role::get(),
            'branches' => Branch::get(),
            'departments' => Department::get(),
            'designations' => Designation::get(),
        ]);
        // return $this->userRepository->findUser($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        return $this->userRepository->updateUser($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->userRepository->destroyUser($id);
    }
}
