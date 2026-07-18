<?php

namespace App\Http\Controllers;

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
}
