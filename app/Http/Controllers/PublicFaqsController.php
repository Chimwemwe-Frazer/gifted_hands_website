<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\View\View;

class PublicFaqsController extends Controller
{
    public function __invoke(): View
    {
        return view('public.faqs', [
            'faqs' => Faq::active()
                ->displayOrder()
                ->get(),
        ]);
    }
}
