<?php

namespace App\Http\Controllers\Admin;

use App\Model\Volunteer\Department;
use App\Model\Volunteer\Type;
use App\Model\Volunteer\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Model\Admin\Permission;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    /**
     * Displays the super admin dashboard where Types/Departments/Locations can be added & removed
     */
    public function dashboard()
    {
        $types = Type::orderBy('name', 'ASC')->get();
        $departments = Department::orderBy('name', 'ASC')->get();
        $locations = Location::orderBy('id', 'ASC')->get();
        return view('admin.super.dashboard', compact('types', 'departments', 'locations'));
    }

    /**
     * Displays the add user page
     */
    public function addUserPage()
    {
        $permissions = Permission::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.super.add-user', compact('permissions'));
    }

    /**
     * After the form is submitted, this function will add that user to the database
     */
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
        session()->flash('admin-success', 'Added user: ' . $user->name);
        return redirect('admin/super/users');
    }

    /**
     * Takes in a user id and will remove that user from the database
     */
    public function removeUser($id)
    {
        $userToRemove = User::find($id);
        $userToRemove->delete();
        session()->flash('admin-error', 'Removed user: ' . $userToRemove->name);
        return redirect('admin/super/users');
    }

    /**
     * Displays the manage users page
     */
    public function manageUsers()
    {
        $users = User::all();
        $permissions = Permission::orderBy('name', 'ASC')->pluck('name', 'id');
        return view('admin.super.manage-users', compact('users', 'permissions'));
    }

    /**
     * This will be called if a form is submitted to change a user's permission level
     */
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
        session()->flash('admin-success', 'Type added successfully.');
        return redirect('admin/super/dashboard');
    }

    public function addDepartment(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:departments',
        ]);
        Department::create(['name' => $request->name]);
        session()->flash('admin-success', 'Department added successfully.');
        return redirect('admin/super/dashboard');
    }

    public function addLocation(Request $request)
    {
        $this->validate($request, [
            'ip_address' => 'required|unique:locations',
        ]);
        Location::create(['ip_address' => $request->ip_address]);
        session()->flash('admin-success', 'Location added successfully.');
        return redirect('admin/super/dashboard');
    }

    public function removeLocation($id)
    {
        Location::destroy($id);
        session()->flash('admin-error', 'Location removed successfully.');
        return redirect('admin/super/dashboard');
    }

    public function removeType($id)
    {
        Type::destroy($id);
        session()->flash('admin-error', 'Type removed successfully.');
        return redirect('admin/super/dashboard');
    }

    public function removeDepartment($id)
    {
        Department::destroy($id);
        session()->flash('admin-error', 'Department removed successfully.');
        return redirect('admin/super/dashboard');
    }
}
