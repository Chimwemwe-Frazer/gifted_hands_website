<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use RuntimeException;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $name = trim((string) config('clinic.administrator.name'));
        $email = Str::lower(trim((string) config('clinic.administrator.email')));
        $password = (string) config('clinic.administrator.password');

        if ($name === '') {
            throw new RuntimeException('ADMIN_NAME must be configured before running the database seeder.');
        }

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException('ADMIN_EMAIL must contain a valid email address before running the database seeder.');
        }

        if ($password === '') {
            throw new RuntimeException('ADMIN_PASSWORD must be configured before running the database seeder.');
        }

        $this->call(RolesAndPermissionsSeeder::class);

        $administratorRole = Role::findByName(User::ROLE_ADMINISTRATOR);

        DB::transaction(function () use ($name, $email, $password, $administratorRole): void {
            $administrator = User::firstOrNew(['email' => $email]);
            $administrator->forceFill([
                'name' => $name,
                'password' => Hash::make($password),
                'status' => 'Active',
            ])->save();

            $administrator->syncRoles($administratorRole);
        });

        $this->command?->info("Gifted Hands administrator ready: {$email}");
    }
}
