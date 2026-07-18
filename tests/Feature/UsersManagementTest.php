<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\UserCreatedPasswordNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UsersManagementTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => ':memory:',
        ]);

        DB::purge();
        DB::reconnect();

        foreach ([
            '0001_01_01_000000_create_users_table.php',
            '2025_04_02_065725_create_permission_tables.php',
        ] as $migrationFile) {
            $migration = require database_path('migrations/'.$migrationFile);
            $migration->up();
        }
    }

    public function test_fixed_roles_are_created_and_roleless_users_are_repaired_safely(): void
    {
        Permission::findOrCreate('list users');

        $legacyAdministratorRole = Role::create(['name' => 'Admin']);
        $administrator = User::factory()->create();
        $administrator->assignRole($legacyAdministratorRole);

        $rolelessUser = User::factory()->create([
            'name' => 'Unassigned Staff Member',
        ]);

        $this->runFixedRoleMigration();

        $this->assertSame(
            [User::ROLE_ADMINISTRATOR, User::ROLE_RECEPTIONIST],
            Role::orderBy('name')->pluck('name')->all(),
        );
        $this->assertTrue($administrator->fresh()->hasRole(User::ROLE_ADMINISTRATOR));
        $this->assertTrue($rolelessUser->fresh()->hasRole(User::ROLE_RECEPTIONIST));
        $this->assertSame('Suspended', $rolelessUser->fresh()->status);

        $this
            ->actingAs($administrator->fresh())
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee($rolelessUser->name)
            ->assertSee(User::ROLE_RECEPTIONIST);

        $this->assertFalse(Route::has('admin.roles.create'));
        $this->assertFalse(Route::has('admin.roles.destroy'));
    }

    public function test_an_administrator_creates_a_receptionist_without_choosing_a_role(): void
    {
        Notification::fake();

        foreach (['add user', 'list users'] as $permission) {
            Permission::findOrCreate($permission);
        }

        $legacyAdministratorRole = Role::create(['name' => 'Admin']);
        $administrator = User::factory()->create();
        $administrator->assignRole($legacyAdministratorRole);

        $this->runFixedRoleMigration();

        $this
            ->actingAs($administrator->fresh())
            ->post(route('admin.users.store'), [
                'name' => 'Clinic Receptionist',
                'email' => 'receptionist@example.com',
                'role' => User::ROLE_ADMINISTRATOR,
            ])
            ->assertRedirect(route('admin.users.index'));

        $receptionist = User::where('email', 'receptionist@example.com')->firstOrFail();

        $this->assertTrue($receptionist->hasRole(User::ROLE_RECEPTIONIST));
        $this->assertFalse($receptionist->hasRole(User::ROLE_ADMINISTRATOR));

        Notification::assertSentTo($receptionist, UserCreatedPasswordNotification::class);
    }

    public function test_an_administrator_can_add_and_remove_receptionist_privileges(): void
    {
        foreach (['add user permissions', 'list services'] as $permission) {
            Permission::findOrCreate($permission);
        }

        $legacyAdministratorRole = Role::create(['name' => 'Admin']);
        $administrator = User::factory()->create();
        $administrator->assignRole($legacyAdministratorRole);

        $this->runFixedRoleMigration();

        $receptionist = User::factory()->create();
        $receptionist->assignRole(User::ROLE_RECEPTIONIST);

        $this
            ->actingAs($administrator->fresh())
            ->put(route('admin.user.update-permissions', $receptionist), [
                'permissions' => ['list services'],
            ])
            ->assertRedirect();

        $this->assertTrue($receptionist->fresh()->hasDirectPermission('list services'));
        $this->assertTrue($receptionist->hasRole(User::ROLE_RECEPTIONIST));

        $this
            ->actingAs($administrator->fresh())
            ->put(route('admin.user.update-permissions', $receptionist), [])
            ->assertRedirect();

        $this->assertFalse($receptionist->fresh()->hasDirectPermission('list services'));
        $this->assertTrue($receptionist->hasRole(User::ROLE_RECEPTIONIST));
    }

    public function test_a_suspended_receptionist_cannot_log_in(): void
    {
        $rolelessUser = User::factory()->create();

        $this->runFixedRoleMigration();

        $this
            ->post(route('login'), [
                'email' => $rolelessUser->email,
                'password' => 'password',
            ])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    private function runFixedRoleMigration(): void
    {
        $migration = require database_path(
            'migrations/2026_07_18_000012_enforce_fixed_staff_roles.php'
        );

        $migration->up();
    }
}
