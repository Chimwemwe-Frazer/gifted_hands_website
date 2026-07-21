<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Hash;

it('keeps only the configured Gifted Hands administrator', function () {
    config([
        'clinic.administrator.name' => 'Gifted Hands Administrator',
        'clinic.administrator.email' => 'giftedhandspvtclinic@gmail.com',
        'clinic.administrator.password' => 'password',
    ]);

    User::factory()->create(['email' => 'legacy-admin@example.com']);
    User::factory()->create(['email' => 'receptionist@example.com']);

    $this->seed(DatabaseSeeder::class);

    $administrator = User::sole();

    expect($administrator->name)->toBe('Gifted Hands Administrator')
        ->and($administrator->email)->toBe('giftedhandspvtclinic@gmail.com')
        ->and($administrator->status)->toBe('Active')
        ->and(Hash::check('password', $administrator->password))->toBeTrue()
        ->and($administrator->hasRole(User::ROLE_ADMINISTRATOR))->toBeTrue()
        ->and($administrator->hasRole(User::ROLE_RECEPTIONIST))->toBeFalse();

    User::factory()->create(['email' => 'temporary-staff@example.com']);

    $this->seed(DatabaseSeeder::class);

    expect(User::query()->count())->toBe(1)
        ->and(User::sole()->is($administrator->fresh()))->toBeTrue();
});
