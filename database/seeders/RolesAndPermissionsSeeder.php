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
        $admin = Role::create(['name' => 'Admin']);

        Permission::create(['name' => 'add user']);
        Permission::create(['name' => 'list users']);
        Permission::create(['name' => 'update user']);
        Permission::create(['name' => 'delete user']);
        Permission::create(['name' => 'suspend user']);

        Permission::create(['name' => 'add role']);
        Permission::create(['name' => 'list roles']);
        Permission::create(['name' => 'update role']);
        Permission::create(['name' => 'delete role']);

        Permission::create(['name' => 'add user permissions']);
        Permission::create(['name' => 'update user role']);

        Permission::create(['name' => 'update settings']);

        $admin->givePermissionTo(Permission::all());

        $user = User::find(1);
        $user->assignRole('Admin');
    }
}
