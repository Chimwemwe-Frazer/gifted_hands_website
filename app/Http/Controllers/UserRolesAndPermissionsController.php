<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserRolesAndPermissionsController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:add user permissions', only: ['changePermissions']),
            new Middleware('permission:update user role', only: ['changeRole'])
        ];
    }

    public function changeRole(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'role' => 'required|exists:roles,name'
        ]);

        $user->syncRoles($request->{'role'});

        return redirect()->back()->with('success', 'Role changed successfully');
    }

    public function changePermissions(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'permissions' => 'required|array|min:1'
        ]);

        $user->syncPermissions($request->{'permissions'});

        return redirect()->back()->with('success', 'Permissions changed successfully');
    }
}
