<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class ServicesController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:list services', only: ['index', 'show']),
            new Middleware('permission:add service', only: ['create', 'store']),
            new Middleware('permission:update service', only: ['edit', 'update']),
            new Middleware('permission:delete service', only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $services = Service::latest()->get();

        return view('backend.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('backend.services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Service::create($this->validatedData($request));

        return redirect()->route('admin.services.index')->with('success', 'Service successfully added');
    }

    public function show(Service $service): View
    {
        $service->load('appointments.patient');

        return view('backend.services.show', compact('service'));
    }

    public function edit(Service $service): View
    {
        return view('backend.services.create', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $service->update($this->validatedData($request, $service));

        return redirect()->route('admin.services.index')->with('success', 'Service successfully updated');
    }

    public function destroy(Service $service): RedirectResponse
    {
        if ($service->appointments()->exists()) {
            return redirect()->route('admin.services.index')->with('error', 'You cannot delete a service with appointments');
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service successfully deleted');
    }

    private function validatedData(Request $request, ?Service $service = null): array
    {
        $ignoreId = $service?->id ? ',' . $service->id : '';

        return $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:services,name' . $ignoreId],
            'description' => ['nullable', 'string'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:1440'],
            'fee' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'max:50'],
        ]);
    }
}
