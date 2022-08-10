<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Roles"],
        ];

        $addNewBtn = "admin.roles.create";

        $pageConfigs = ['pageHeader' => true];

        $roles = Role::where('guard_name', 'admin')->get();
        return view('backend.roles.list', compact('roles', 'breadcrumbs', 'addNewBtn', 'pageConfigs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Roles"],
        ];

        $pageConfigs = ['pageHeader' => true];

        $permissions = Permission::where('guard_name', 'admin')->orderBy('name')->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->name];
            });

        return view('backend.roles.add', compact('permissions', 'breadcrumbs', 'pageConfigs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validations = [
            'name' => 'required|unique:roles,name',
        ];
        $request->validate($validations);

        try {
            $role = Role::create([
                'name' => trim($request->name),
                'guard_name' => 'admin'
            ]);
            $role->syncPermissions($request->permissions);
            return redirect(route('admin.roles.show', $role->id))->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $breadcrumbs = [
            ['link' => "admin", 'name' => "Dashboard"], ['name' => "Roles"],
        ];

        $pageConfigs = ['pageHeader' => true];

        $permissions = Permission::where('guard_name', 'admin')->orderBy('name')->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->name];
            });

        $selected_per = $role->permissions->pluck('pivot')->pluck('permission_id')->toArray();

        return view('backend.roles.show', compact(['role', 'permissions', 'selected_per', 'breadcrumbs', 'pageConfigs']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validations = [
            'name' => 'required|unique:roles,name,' . $role->id,
        ];
        $request->validate($validations);

        try {
            $role->name = trim($request->name);
            $role->save();
            $role->syncPermissions($request->permissions);

            return redirect(route('admin.roles.show', $role->id))->with('success', __('system-messages.add'));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if ($role) {
            $users = User::all();
            foreach ($users as $value) {
                $value->removeRole($role->name);
            }
            $role->delete();
            return redirect(route('admin.roles.index'))->with('success', __('system-messages.delete'));
        } else {
            return redirect(route('admin.roles.index'))->with('error', 'roles not found');
        }
    }
}
