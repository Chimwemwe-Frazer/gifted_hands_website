<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\View\View;

class PublicAnnouncementsController extends Controller
{
    public function __invoke(): View
    {
        return view('public.announcements', [
            'announcements' => Announcement::published()
                ->latest('published_at')
                ->paginate(8),
        ]);
    }
}
