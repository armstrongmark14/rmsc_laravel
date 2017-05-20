<?php

namespace App\Http\Controllers\Admin;

use App\Model\Volunteer\Department;
use App\Model\Volunteer\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Admin\Permission;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    //
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View displays the super admin dash
     */
    public function dashboard()
    {
        $types = Type::orderBy('name', 'ASC')->get();
        $departments = Department::orderBy('name', 'ASC')->get();
        return view('admin.super.dashboard', compact('types', 'departments'));
    }

    public function addUserPage()
    {
        $permissions = Permission::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.super.add-user', compact('permissions'));
    }

    public function addUser(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users',
            'password' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'permission_id' => $request->permission,
            'email' => 'rmsc@rmsc.org'
        ]);

        $user->save();
        return redirect('admin/super/users');
    }

    public function removeUser($id)
    {
        $userToRemove = User::find($id);
        $userToRemove->delete();
        return redirect('admin/super/users');
    }

    public function manageUsers()
    {
        $users = User::all();
        $permissions = Permission::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.super.manage-users', compact('users', 'permissions'));
    }

    public function changePermissions(Request $request)
    {
        $user = User::find($request->user_id);
        $user->permission_id = $request->permission;
        $user->save();
        session()->flash('admin-success', 'Permissions updated for ' . $user->name . '.');
        return redirect('admin/super/users');
    }

    public function addType(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:types',
        ]);
        Type::create(['name' => $request->name]);
        return redirect('admin/super/dashboard');
    }

    public function addDepartment(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:departments',
        ]);
        Department::create(['name' => $request->name]);
        return redirect('admin/super/dashboard');
    }

    public function removeType($id)
    {
        Type::destroy($id);
        return redirect('admin/super/dashboard');
    }

    public function removeDepartment($id)
    {
        Department::destroy($id);
        return redirect('admin/super/dashboard');
    }
}
