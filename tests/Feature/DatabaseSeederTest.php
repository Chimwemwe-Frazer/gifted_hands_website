<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Hash;

it('provisions the configured administrator without deleting other staff', function () {
    config([
        'clinic.administrator.name' => 'Gifted Hands Administrator',
        'clinic.administrator.email' => 'giftedhandspvtclinic@gmail.com',
        'clinic.administrator.password' => 'password',
    ]);

    $legacyAdministrator = User::factory()->create(['email' => 'legacy-admin@example.com']);
    $receptionist = User::factory()->create(['email' => 'receptionist@example.com']);

    $this->seed(DatabaseSeeder::class);

    $administrator = User::query()
        ->where('email', 'giftedhandspvtclinic@gmail.com')
        ->sole();

    expect($administrator->name)->toBe('Gifted Hands Administrator')
        ->and($administrator->email)->toBe('giftedhandspvtclinic@gmail.com')
        ->and($administrator->status)->toBe('Active')
        ->and(Hash::check('password', $administrator->password))->toBeTrue()
        ->and($administrator->hasRole(User::ROLE_ADMINISTRATOR))->toBeTrue()
        ->and($administrator->hasRole(User::ROLE_RECEPTIONIST))->toBeFalse()
        ->and($legacyAdministrator->fresh())->not->toBeNull()
        ->and($receptionist->fresh())->not->toBeNull()
        ->and(User::query()->count())->toBe(3);

    User::factory()->create(['email' => 'temporary-staff@example.com']);

    $this->seed(DatabaseSeeder::class);

    expect(User::query()->count())->toBe(4)
        ->and(
            User::query()
                ->where('email', 'giftedhandspvtclinic@gmail.com')
                ->sole()
                ->is($administrator->fresh())
        )->toBeTrue();
});
