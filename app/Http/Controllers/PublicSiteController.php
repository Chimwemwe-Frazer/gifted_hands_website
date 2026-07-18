<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Doctor;
use App\Models\Faq;
use App\Models\Service;
use Illuminate\View\View;

class PublicSiteController extends Controller
{
    public function __invoke(): View
    {
        return view('public.home', [
            'services' => Service::active()
                ->displayOrder()
                ->get(),
            'doctors' => Doctor::active()
                ->displayOrder()
                ->take(3)
                ->get(),
            'faqs' => Faq::active()
                ->where('show_on_home', true)
                ->displayOrder()
                ->take(2)
                ->get(),
            'announcements' => Announcement::published()
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
    }
}
