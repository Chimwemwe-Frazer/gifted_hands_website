<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
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
        $services = Service::displayOrder()->get();

        return view('backend.services.index', compact('services'));
    }

    public function create(): View
    {
        $nextDisplayOrder = (int) Service::max('display_order') + 1;

        return view('backend.services.create', compact('nextDisplayOrder'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        unset($data['image'], $data['remove_image']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('services', 'public');
        }

        Service::create($data);

        return redirect()->route('admin.services.index')->with('success', 'Service successfully added');
    }

    public function show(Service $service): View
    {
        $service->load('appointments');

        return view('backend.services.show', compact('service'));
    }

    public function edit(Service $service): View
    {
        return view('backend.services.create', compact('service'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $data = $this->validatedData($request, $service);
        unset($data['image'], $data['remove_image']);

        $oldImagePath = $service->image_path;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('services', 'public');
        } elseif ($request->boolean('remove_image')) {
            $data['image_path'] = null;
        }

        $service->update($data);

        if (
            $oldImagePath
            && array_key_exists('image_path', $data)
            && $oldImagePath !== $data['image_path']
        ) {
            $this->deleteManagedImage($oldImagePath);
        }

        return redirect()->route('admin.services.index')->with('success', 'Service successfully updated');
    }

    public function destroy(Service $service): RedirectResponse
    {
        if ($service->appointments()->exists()) {
            return redirect()->route('admin.services.index')->with('error', 'You cannot delete a service with appointments');
        }

        $imagePath = $service->image_path;
        $service->delete();
        $this->deleteManagedImage($imagePath);

        return redirect()->route('admin.services.index')->with('success', 'Service successfully deleted');
    }

    private function validatedData(Request $request, ?Service $service = null): array
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services', 'name')->ignore($service),
            ],
            'description' => ['required', 'string', 'max:2000'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:1440'],
            'fee' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_image' => ['nullable', 'boolean'],
            'included_items' => ['required', 'string', 'max:10000'],
            'needs_treated' => ['required', 'string', 'max:5000'],
            'items_to_bring' => ['required', 'string', 'max:10000'],
            'appointment_details' => ['required', 'string', 'max:5000'],
            'display_order' => ['required', 'integer', 'min:1', 'max:9999'],
        ]);

        $data['included_items'] = $this->lineItems($data['included_items']);
        $data['items_to_bring'] = $this->lineItems($data['items_to_bring']);

        return $data;
    }

    private function lineItems(string $value): array
    {
        return array_values(array_filter(
            preg_split('/\r\n|\r|\n/', trim($value)) ?: [],
            fn (string $item): bool => trim($item) !== ''
        ));
    }

    private function deleteManagedImage(?string $imagePath): void
    {
        if ($imagePath && ! str_starts_with($imagePath, 'imgs/')) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
