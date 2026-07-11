<?php

namespace App\Http\Controllers;

use App\Models\AnnouncementSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PublicAnnouncementSubscriptionController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:announcement_subscribers,email'],
        ]);

        AnnouncementSubscriber::create($data);

        return redirect()
            ->route('announcements')
            ->with('subscription_success', 'Thank you for subscribing to Gifted Hands updates.');
    }
}
