<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class AppointmentsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:list appointments', only: ['index', 'show']),
            new Middleware('permission:add appointment', only: ['create', 'store']),
            new Middleware('permission:update appointment', only: ['edit', 'update']),
            new Middleware('permission:delete appointment', only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $appointments = Appointment::with(['patient', 'service', 'practitioner'])
            ->orderByDesc('appointment_at')
            ->get();

        return view('backend.appointments.index', compact('appointments'));
    }

    public function create(): View
    {
        return view('backend.appointments.create', $this->formData());
    }

    public function store(Request $request): RedirectResponse
    {
        Appointment::create($this->validatedData($request));

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment successfully scheduled');
    }

    public function show(Appointment $appointment): View
    {
        $appointment->load(['patient', 'service', 'practitioner']);

        return view('backend.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment): View
    {
        return view('backend.appointments.create', $this->formData() + compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment): RedirectResponse
    {
        $appointment->update($this->validatedData($request));

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment successfully updated');
    }

    public function destroy(Appointment $appointment): RedirectResponse
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment successfully deleted');
    }

    private function formData(): array
    {
        return [
            'patients' => Patient::where('status', 'Active')->orderBy('first_name')->get(),
            'services' => Service::where('status', 'Active')->orderBy('name')->get(),
            'practitioners' => User::orderBy('name')->get(),
            'statuses' => ['Scheduled', 'Checked In', 'Completed', 'Cancelled'],
        ];
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'patient_id' => ['required', 'exists:patients,id'],
            'service_id' => ['required', 'exists:services,id'],
            'practitioner_id' => ['nullable', 'exists:users,id'],
            'appointment_at' => ['required', 'date'],
            'status' => ['required', 'string', 'max:50'],
            'reason' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
