<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('backend.dashboard', [
            'patientsCount' => Patient::count(),
            'appointmentsTodayCount' => Appointment::whereDate('appointment_at', today())->count(),
            'servicesCount' => Service::where('status', 'Active')->count(),
            'staffCount' => User::count(),
            'upcomingAppointments' => Appointment::with(['patient', 'service', 'practitioner'])
                ->where('appointment_at', '>=', now())
                ->orderBy('appointment_at')
                ->take(5)
                ->get(),
        ]);
    }
}
