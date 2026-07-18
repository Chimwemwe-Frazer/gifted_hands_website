<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DoctorsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:list doctors', only: ['index']),
            new Middleware('permission:add doctor', only: ['create', 'store']),
            new Middleware('permission:update doctor', only: ['edit', 'update']),
            new Middleware('permission:delete doctor', only: ['destroy']),
        ];
    }

    public function index(): View
    {
        return view('backend.doctors.index', [
            'doctors' => Doctor::displayOrder()->get(),
        ]);
    }

    public function create(): View
    {
        return view('backend.doctors.create', [
            'nextDisplayOrder' => (int) Doctor::max('display_order') + 1,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        unset($data['image'], $data['remove_image']);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('doctors', 'public');
        }

        Doctor::create($data);

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor successfully added');
    }

    public function edit(Doctor $doctor): View
    {
        return view('backend.doctors.create', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor): RedirectResponse
    {
        $data = $this->validatedData($request, $doctor);
        unset($data['image'], $data['remove_image']);

        $oldImagePath = $doctor->image_path;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('doctors', 'public');
        } elseif ($request->boolean('remove_image')) {
            $data['image_path'] = null;
        }

        $doctor->update($data);

        if (
            $oldImagePath
            && array_key_exists('image_path', $data)
            && $oldImagePath !== $data['image_path']
        ) {
            $this->deleteManagedImage($oldImagePath);
        }

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor successfully updated');
    }

    public function destroy(Doctor $doctor): RedirectResponse
    {
        $imagePath = $doctor->image_path;
        $doctor->delete();
        $this->deleteManagedImage($imagePath);

        return redirect()
            ->route('admin.doctors.index')
            ->with('success', 'Doctor successfully deleted');
    }

    private function validatedData(Request $request, ?Doctor $doctor = null): array
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('doctors', 'name')->ignore($doctor),
            ],
            'specialization' => ['required', 'string', 'max:255'],
            'qualification' => ['required', 'string', 'max:2000'],
            'experience' => ['required', 'string', 'max:255'],
            'bio' => ['required', 'string', 'max:5000'],
            'languages' => ['required', 'string', 'max:2000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_image' => ['nullable', 'boolean'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
            'display_order' => ['required', 'integer', 'min:1', 'max:9999'],
        ]);

        $data['languages'] = array_values(array_filter(
            array_map(
                'trim',
                preg_split('/\r\n|\r|\n/', trim($data['languages'])) ?: []
            )
        ));

        return $data;
    }

    private function deleteManagedImage(?string $imagePath): void
    {
        if ($imagePath && ! str_starts_with($imagePath, 'imgs/')) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
