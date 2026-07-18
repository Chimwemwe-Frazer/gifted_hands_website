<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\View\View;

class PublicDoctorsController extends Controller
{
    public function __invoke(): View
    {
        return view('public.doctors', [
            'doctors' => Doctor::active()
                ->displayOrder()
                ->get(),
        ]);
    }
}
