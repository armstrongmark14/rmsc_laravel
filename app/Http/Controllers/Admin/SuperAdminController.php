<?php

namespace App\Http\Controllers\Admin;

use App\Model\Volunteer\Department;
use App\Model\Volunteer\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
