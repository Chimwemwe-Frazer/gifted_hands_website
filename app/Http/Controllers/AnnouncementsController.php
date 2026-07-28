<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Services\UploadedImageStorage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class AnnouncementsController extends Controller implements HasMiddleware
{
    public function __construct(
        private readonly UploadedImageStorage $images,
    ) {}

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
        $data['published_at'] = now();

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->images->store(
                $request->file('image'),
                'announcements',
            );
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

        $oldImagePath = $announcement->image_path;

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->images->store(
                $request->file('image'),
                'announcements',
            );
        } elseif ($request->boolean('remove_image')) {
            $data['image_path'] = null;
        }

        $announcement->update($data);

        if (
            $oldImagePath
            && array_key_exists('image_path', $data)
            && $oldImagePath !== $data['image_path']
        ) {
            $this->images->delete($oldImagePath);
        }

        return redirect()
            ->route('admin.announcements.index')
            ->with('success', 'Announcement successfully updated');
    }

    public function destroy(Announcement $announcement): RedirectResponse
    {
        $imagePath = $announcement->image_path;
        $announcement->delete();
        $this->images->delete($imagePath);

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
            'remove_image' => ['nullable', 'boolean'],
        ]);
    }
}
