<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\View\View;

class PublicServicesController extends Controller
{
    public function __invoke(): View
    {
        return view('public.services', [
            'services' => Service::active()
                ->displayOrder()
                ->get(),
        ]);
    }
}
