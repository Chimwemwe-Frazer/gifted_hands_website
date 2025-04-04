<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:list roles', only: ['index', 'show']),
            new Middleware('permission:add role', only: ['create', 'store']),
            new Middleware('permission:update role', only: ['edit', 'update']),
            new Middleware('permission:delete role', only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $roles = Role::with('permissions', 'users')->get();

        $permissions = Permission::all()->pluck('name');

        return view('backend.roles.index', compact('roles', 'permissions'));
    }

    public function show(Role $role): View
    {

        $role->load('permissions', 'users');

        return view('backend.roles.show', compact('role'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array|min:1'
        ]);

        $role = Role::create(['name' => $request->{'name'}]);

        $role->syncPermissions($request->{'permissions'});

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully');
    }

    public function edit(Role $role): View
    {
        $permissions = Permission::all();

        return view('backend.roles.create', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'required|array|min:1'
        ]);

        $role->update(['name' => $request->{'name'}]);

        $role->syncPermissions($request->{'permissions'});

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully');
    }

    public function destroy(Role $role): RedirectResponse
    {
        if ($role->name === 'Admin') {
            return redirect()->route('admin.roles.index')->with('error', 'You cannot delete the Admin role');
        }

        if ($role->users()->count() > 0) {
            return redirect()->route('admin.roles.index')->with('error', 'You cannot delete a role with users');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully');
    }
}
