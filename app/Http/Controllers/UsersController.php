<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUsersRequest;
use App\Models\User;
use App\Notifications\PasswordChangedNotification;
use App\Notifications\UserCreatedPasswordNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class UsersController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:list users', only: ['index', 'show']),
            new Middleware('permission:add user', only: ['create', 'store']),
            new Middleware('permission:update user', only: ['edit', 'update']),
            new Middleware('permission:suspend user', only: ['activate', 'deactivate']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $users = User::with('roles')->get();

        return view('backend.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('backend.users.create', [
            'roleName' => User::ROLE_RECEPTIONIST,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUsersRequest $request): RedirectResponse
    {
        $password = Str::password(16);

        $user = DB::transaction(function () use ($request, $password): User {
            $user = User::create([
                'name' => $request->validated()['name'],
                'email' => $request->validated()['email'],
                'password' => Hash::make($password),
            ]);

            $user->assignRole(User::ROLE_RECEPTIONIST);

            return $user;
        });

        $user->notify(new UserCreatedPasswordNotification($password));

        return redirect()->route('admin.users.index')->with('success', 'User Successfully Created');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        $all_permissions = Permission::all()->pluck('name');

        $user->load('roles');

        $user_permissions = $user->getAllPermissions()->pluck('name');
        $direct_permissions = $user->getDirectPermissions()->pluck('name');

        return view('backend.users.show', compact(
            'user',
            'all_permissions',
            'user_permissions',
            'direct_permissions',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $user->load('roles');

        return view('backend.users.create', [
            'user' => $user,
            'roleName' => $user->roles->first()?->name,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User Successfully Updated');
    }

    public function deactivate(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->deactivate();

        return redirect()->back()->with('success', 'User has been Deactivated');
    }

    public function activate(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->activate();

        return redirect()->back()->with('success', 'User has been Activated');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = $request->user();

        if (Hash::check($request->{'password'}, $user->password)) {
            return redirect()->back()->with('error', 'New password cannot be the same as old password');
        }

        $user->password = Hash::make($request->{'password'});
        $user->{'has_changed_password'} = true;
        $user->save();

        $user->notify(new PasswordChangedNotification);

        return redirect()->route('admin.dashboard')->with('success', 'password updated successfully');
    }
}
