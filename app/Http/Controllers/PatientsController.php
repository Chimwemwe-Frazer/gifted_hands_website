<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class PatientsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:list patients', only: ['index', 'show']),
            new Middleware('permission:add patient', only: ['create', 'store']),
            new Middleware('permission:update patient', only: ['edit', 'update']),
            new Middleware('permission:delete patient', only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $patients = Patient::latest()->get();

        return view('backend.patients.index', compact('patients'));
    }

    public function create(): View
    {
        return view('backend.patients.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Patient::create($this->validatedData($request) + [
            'patient_number' => $this->nextPatientNumber(),
        ]);

        return redirect()->route('admin.patients.index')->with('success', 'Patient successfully registered');
    }

    public function show(Patient $patient): View
    {
        $patient->load(['appointments.service', 'appointments.practitioner']);

        return view('backend.patients.show', compact('patient'));
    }

    public function edit(Patient $patient): View
    {
        return view('backend.patients.create', compact('patient'));
    }

    public function update(Request $request, Patient $patient): RedirectResponse
    {
        $patient->update($this->validatedData($request));

        return redirect()->route('admin.patients.index')->with('success', 'Patient successfully updated');
    }

    public function destroy(Patient $patient): RedirectResponse
    {
        $patient->delete();

        return redirect()->route('admin.patients.index')->with('success', 'Patient successfully deleted');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['nullable', 'string', 'max:50'],
            'date_of_birth' => ['nullable', 'date'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:50'],
            'medical_notes' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:50'],
        ]);
    }

    private function nextPatientNumber(): string
    {
        $nextId = (Patient::max('id') ?? 0) + 1;

        return 'GH-' . str_pad((string) $nextId, 5, '0', STR_PAD_LEFT);
    }
}
