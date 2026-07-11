<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email'=> 'promisemphoola2@gmail.com',
        ], [
            'name' => 'Test User',
            'password' => Hash::make('1234567890'),
        ]);

        User::factory(5)->create();

        (new RolesAndPermissionsSeeder())->run();
    }
}
