<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AnnouncementsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:list announcements', only: ['index']),
            new Middleware('permission:add announcement', only: ['create', 'store']),
            new Middleware('permission:update announcement', only: ['edit', 'update']),
            new Middleware('permission:delete announcement', only: ['destroy']),
        ];
    }

    public function index(): View
    {
        $announcements = Announcement::with('author')
            ->latest('published_at')
            ->latest()
            ->paginate(12);

        return view('backend.announcements.index', compact('announcements'));
    }

    public function create(): View
    {
        return view('backend.announcements.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        unset($data['image'], $data['remove_image']);

        $data['user_id'] = $request->user()->id;
        $data['published_at'] = $this->resolvePublishedAt($data);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('announcements', 'public');
        }

        Announcement::create($data);

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement successfully added');
    }

    public function edit(Announcement $announcement): View
    {
        return view('backend.announcements.create', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement): RedirectResponse
    {
        $data = $this->validatedData($request);
        unset($data['image'], $data['remove_image']);

        $data['published_at'] = $this->resolvePublishedAt($data, $announcement);
        $oldImagePath = $announcement->image_path;

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('announcements', 'public');
        } elseif ($request->boolean('remove_image')) {
            $data['image_path'] = null;
            $data['image_alt'] = null;
        }

        $announcement->update($data);

        if (
            $oldImagePath
            && array_key_exists('image_path', $data)
            && $oldImagePath !== $data['image_path']
        ) {
            Storage::disk('public')->delete($oldImagePath);
        }

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement successfully updated');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        if ($announcement->image_path) {
            Storage::disk('public')->delete($announcement->image_path);
        }

        $announcement->delete();

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement successfully deleted');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'category' => ['required', 'string', 'max:80'],
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:10000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'image_alt' => ['nullable', 'string', 'max:255'],
            'image_position' => ['required', 'in:left,right'],
            'status' => ['required', 'in:Draft,Published'],
            'published_at' => ['nullable', 'date'],
            'remove_image' => ['nullable', 'boolean'],
        ]);
    }

    private function resolvePublishedAt(array $data, ?Announcement $announcement = null): mixed
    {
        if ($data['status'] !== 'Published') {
            return $data['published_at'] ?? null;
        }

        return $data['published_at']
            ?? $announcement?->published_at
            ?? now();
    }
}
