<?php

namespace App\Repositories\UserManagement\Users;

use App\Models\User;
use App\Repositories\UserManagement\Users\UserInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserRepository implements UserInterface
{
    public function storeUser($request)
    {
        try {
            $data = $request->except(['password_confirmation']);

            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }
            // image upload
            if ($request->hasFile('user_image')) {
                $file = $request->file('user_image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/users'), $filename);
                $data['user_image'] = 'images/users/' . $filename;
            }

            $user = User::create($data);

            return ['status' => 'success', 'message' => 'User Created Successfully'];
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'User Creation Failed: ' . $e->getMessage()];
        }
    }

    public function findUser($id)
    {
        return User::with(['role', 'department', 'designation', 'branch'])->findOrFail($id);
    }

    public function updateUser($request, $id)
    {
        try {
            $user = $this->findUser($id);
            $data = $request->except('password_confirmation');

            if (isset($data['password']) && $data['password']) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            if ($request->hasFile('user_image')) {
                if ($user->user_image && file_exists(public_path($user->user_image))) {
                    @unlink(public_path($user->user_image));
                }
                $file = $request->file('user_image');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('images/users'), $filename);
                $data['user_image'] = 'images/users/' . $filename;
            }
            if (!isset($data['user_image'])) {
                unset($data['user_image']);
            }

            $user->update($data);

            toastr()->success('User updated successfully.');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            toastr()->error('User update failed: ' . $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function destroyUser($id)
    {
        try {
            $user = $this->findUser($id);
            $user->delete();
            toastr()->success('User deleted successfully.');
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            toastr()->error('User deletion failed: ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function statusUser($request)
    {
        $user = User::findOrFail($request->id);
        $user->user_status = $user->user_status == 1 ? 0 : 1;
        $user->save();

        return $user;
    }
}
