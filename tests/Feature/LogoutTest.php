<?php

use App\Models\User;

it('logs users out from the admin side and redirects to the public home footer', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('logout'))
        ->assertRedirect(route('home').'#site-footer');

    $this->assertGuest();
});

it('does not show page expired when a stale logout form is posted', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->withMiddleware()
        ->post(route('logout'))
        ->assertRedirect(route('home').'#site-footer');

    $this->assertGuest();
});
