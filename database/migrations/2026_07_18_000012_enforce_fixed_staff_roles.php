<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    private const GUARD = 'web';

    /**
     * Enforce the two fixed staff roles and repair existing role assignments.
     */
    public function up(): void
    {
        if (! Schema::hasTable('users')
            || ! Schema::hasTable('roles')
            || ! Schema::hasTable('permissions')
            || ! Schema::hasTable('model_has_roles')
            || ! Schema::hasTable('role_has_permissions')) {
            return;
        }

        DB::transaction(function (): void {
            $now = now();
            $userModel = User::class;

            $administratorId = DB::table('roles')
                ->where('name', User::ROLE_ADMINISTRATOR)
                ->where('guard_name', self::GUARD)
                ->value('id');

            $legacyAdministratorIds = DB::table('roles')
                ->where('name', 'Admin')
                ->where('guard_name', self::GUARD)
                ->pluck('id');

            if (! $administratorId && $legacyAdministratorIds->isNotEmpty()) {
                $administratorId = $legacyAdministratorIds->shift();

                DB::table('roles')
                    ->where('id', $administratorId)
                    ->update([
                        'name' => User::ROLE_ADMINISTRATOR,
                        'updated_at' => $now,
                    ]);
            }

            if (! $administratorId) {
                $administratorId = DB::table('roles')->insertGetId([
                    'name' => User::ROLE_ADMINISTRATOR,
                    'guard_name' => self::GUARD,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $legacyAdministratorIds = $legacyAdministratorIds
                ->merge(
                    DB::table('roles')
                        ->where('name', 'Admin')
                        ->where('guard_name', self::GUARD)
                        ->pluck('id')
                )
                ->unique()
                ->reject(fn ($roleId) => (int) $roleId === (int) $administratorId)
                ->values();

            $administratorUserIds = DB::table('model_has_roles')
                ->where('model_type', $userModel)
                ->whereIn('role_id', $legacyAdministratorIds->push($administratorId)->unique())
                ->pluck('model_id')
                ->unique();

            $receptionistId = DB::table('roles')
                ->where('name', User::ROLE_RECEPTIONIST)
                ->where('guard_name', self::GUARD)
                ->value('id');

            if (! $receptionistId) {
                $receptionistId = DB::table('roles')->insertGetId([
                    'name' => User::ROLE_RECEPTIONIST,
                    'guard_name' => self::GUARD,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $usersWithAnyRole = DB::table('model_has_roles')
                ->where('model_type', $userModel)
                ->pluck('model_id')
                ->unique();

            DB::table('users')
                ->when(
                    $usersWithAnyRole->isNotEmpty(),
                    fn ($query) => $query->whereNotIn('id', $usersWithAnyRole)
                )
                ->update([
                    'status' => 'Suspended',
                    'updated_at' => $now,
                ]);

            $userIds = DB::table('users')->pluck('id');

            DB::table('model_has_roles')
                ->where('model_type', $userModel)
                ->delete();

            foreach ($userIds as $userId) {
                DB::table('model_has_roles')->insert([
                    'role_id' => $administratorUserIds->contains($userId)
                        ? $administratorId
                        : $receptionistId,
                    'model_type' => $userModel,
                    'model_id' => $userId,
                ]);
            }

            DB::table('roles')
                ->where('guard_name', self::GUARD)
                ->whereNotIn('id', [$administratorId, $receptionistId])
                ->delete();

            DB::table('role_has_permissions')
                ->whereIn('role_id', [$administratorId, $receptionistId])
                ->delete();

            $administratorPermissionIds = DB::table('permissions')
                ->where('guard_name', self::GUARD)
                ->pluck('id');

            foreach ($administratorPermissionIds as $permissionId) {
                DB::table('role_has_permissions')->insert([
                    'permission_id' => $permissionId,
                    'role_id' => $administratorId,
                ]);
            }

            $receptionistPermissionIds = DB::table('permissions')
                ->where('guard_name', self::GUARD)
                ->whereIn('name', [
                    'add appointment',
                    'list appointments',
                    'update appointment',
                ])
                ->pluck('id');

            foreach ($receptionistPermissionIds as $permissionId) {
                DB::table('role_has_permissions')->insert([
                    'permission_id' => $permissionId,
                    'role_id' => $receptionistId,
                ]);
            }
        });

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * This data normalization is intentionally not reversible because doing so
     * would recreate role-less accounts.
     */
    public function down(): void
    {
        //
    }
};
