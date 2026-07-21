<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Seed the fixed staff roles and their permissions.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'add service',
            'list services',
            'update service',
            'delete service',
            'add doctor',
            'list doctors',
            'update doctor',
            'delete doctor',
            'add faq',
            'list faqs',
            'update faq',
            'delete faq',
            'add appointment',
            'list appointments',
            'update appointment',
            'delete appointment',
            'add user',
            'list users',
            'update user',
            'delete user',
            'suspend user',
            'list roles',
            'add user permissions',
            'update settings',
            'add announcement',
            'list announcements',
            'update announcement',
            'delete announcement',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        $administrator = Role::findOrCreate(User::ROLE_ADMINISTRATOR);
        $receptionist = Role::findOrCreate(User::ROLE_RECEPTIONIST);

        $administrator->syncPermissions(Permission::all());
        $receptionist->syncPermissions([
            'add appointment',
            'list appointments',
            'update appointment',
        ]);

        Role::where('guard_name', 'web')
            ->whereNotIn('name', [User::ROLE_ADMINISTRATOR, User::ROLE_RECEPTIONIST])
            ->with('users')
            ->get()
            ->each(function (Role $role) use ($administrator, $receptionist): void {
                foreach ($role->users as $user) {
                    $user->syncRoles(
                        $role->name === 'Admin'
                            || $user->hasAnyRole(User::ROLE_ADMINISTRATOR, 'Admin')
                                ? $administrator
                                : $receptionist
                    );
                }

                $role->delete();
            });

        User::with('roles')->get()->each(function (User $user) use ($administrator, $receptionist): void {
            if ($user->roles->contains('name', User::ROLE_ADMINISTRATOR)) {
                $user->syncRoles($administrator);

                return;
            }

            $user->syncRoles($receptionist);
        });

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
