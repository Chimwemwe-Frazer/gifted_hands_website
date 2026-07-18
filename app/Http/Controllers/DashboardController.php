<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('backend.dashboard', [
            'newAppointmentRequestsCount' => Appointment::where(
                'status',
                Appointment::STATUS_PENDING
            )->count(),
            'appointmentsTodayCount' => Appointment::where(
                'status',
                Appointment::STATUS_APPROVED
            )->whereDate('appointment_at', today())->count(),
            'servicesCount' => Service::where('status', 'Active')->count(),
            'staffCount' => User::count(),
            'upcomingAppointments' => Appointment::with(['service', 'practitioner'])
                ->where('status', Appointment::STATUS_APPROVED)
                ->where('appointment_at', '>=', now())
                ->orderBy('appointment_at')
                ->take(5)
                ->get(),
        ]);
    }
}
