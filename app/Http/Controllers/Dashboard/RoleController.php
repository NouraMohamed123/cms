<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(){

        $this->middleware('permission:roles_read')->only(['index']);
        $this->middleware('permission:roles_create')->only(['create', 'store']);
        $this->middleware('permission:roles_update')->only(['edit', 'update']);
        $this->middleware('permission:roles_delete')->only(['destroy']);

    }

    public function index()
    {
        //

        $roles = Role::whereRoleNot(['super_admin', 'admin'])
            ->WhenSearch(request()->search)
            ->with('permissions')
            ->withCount('users')
            ->paginate();

        return view('dashboard.roles.index', compact('roles'));
    }


    public function create()
    {
        //

        return view('dashboard.roles.create');
    }

    public function store(Request $request)
    {
        //
        $request->validate([
            'name'  => 'required|unique:roles,name',
            'permissions'  => 'required|array|min:1',
        ]);

        $role =  Role::create($request->all());
        $role->attachPermissions($request->permissions);

        session()->flash('success', 'Data Added Successfully');

        return redirect()->route('dashboard.roles.index');
    }


    public function edit( Role $role)
    {
        //

        return view('dashboard.roles.edit', compact('role'));
    }


    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'  => 'required|unique:roles,name,' . $role->id,
            'permissions'  => 'required|array|min:1',
        ]);

        $role->update($request->all());
        $role->syncPermissions($request->permissions);

        session()->flash('success', 'Data Updated Successfully');

        return redirect()->route('dashboard.roles.index');

    }


    public function destroy(Role $role)
    {
        $role->delete();

        session()->flash('success', 'Data Deleted Successfully');

        return redirect()->route('dashboard.roles.index');
    }
}
