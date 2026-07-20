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
        $services = Service::active()
            ->displayOrder()
            ->get();

        return view('public.home', [
            'services' => $services,
            'featuredServices' => $services->take(5),
            'doctors' => Doctor::active()
                ->displayOrder()
                ->take(3)
                ->get(),
            'faqs' => Faq::active()
                ->latest('created_at')
                ->latest('id')
                ->take(4)
                ->get(),
            'announcements' => Announcement::published()
                ->latest('published_at')
                ->take(3)
                ->get(),
        ]);
    }
}
