<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Services\AppointmentNotifier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PublicAppointmentController extends Controller
{
    public function __invoke(Request $request, AppointmentNotifier $notifier): RedirectResponse
    {
        $data = $request->validate([
            'client_name' => ['required', 'string', 'max:255'],
            'client_phone' => ['required', 'string', 'max:50'],
            'client_email' => ['required', 'email', 'max:255'],
            'service_id' => [
                'required',
                Rule::exists('services', 'id')->where('status', 'Active'),
            ],
            'preferred_at' => ['nullable', 'date', 'after:now'],
            'request_message' => ['nullable', 'string', 'max:2000'],
        ]);

        $appointment = Appointment::create($data + [
            'status' => Appointment::STATUS_PENDING,
        ]);

        $notifier->requestReceived($appointment);

        return redirect()
            ->to(route('home').'#book-appointment')
            ->with(
                'success',
                'Your appointment request is pending review. We have emailed you a confirmation and will email you again after the clinic team responds.'
            );
    }
}
