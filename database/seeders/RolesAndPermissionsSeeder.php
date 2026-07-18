<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::firstOrCreate(['name' => 'Admin']);

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
            'add role',
            'list roles',
            'update role',
            'delete role',
            'add user permissions',
            'update user role',
            'update settings',
            'add announcement',
            'list announcements',
            'update announcement',
            'delete announcement',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin->givePermissionTo(Permission::all());

        $user = User::where('email', 'promisemphoola2@gmail.com')->first();

        if ($user) {
            $user->assignRole('Admin');
        }
    }
}
