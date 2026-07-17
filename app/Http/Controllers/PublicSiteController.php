<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Service;
use Illuminate\View\View;

class PublicSiteController extends Controller
{
    public function __invoke(): View
    {
        return view('public.home', [
            'services' => Service::where('status', 'Active')
                ->orderBy('name')
                ->get(),
            'announcements' => Announcement::published()
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
    }
}
