@extends('layouts.app')

@section('title')
    Announcements
@endsection

@section('content')
    <div class="flex items-center justify-between">
        <h1 class="page-heading">Announcements</h1>
        @can('add announcement')
            <a href="{{ route('admin.announcements.create') }}" class="btn-primary">Add Announcement</a>
        @endcan
    </div>

    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        @forelse ($announcements as $announcement)
            <article class="overflow-hidden rounded-lg bg-white shadow">
                @if ($announcement->image_path)
                    <img src="{{ $announcement->image_url }}" alt="{{ $announcement->image_alt ?: $announcement->title }}" class="h-48 w-full object-cover">
                @endif

                <div class="p-5">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <p class="text-xs font-semibold uppercase tracking-[.16em] text-mustGreen">{{ $announcement->category }}</p>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $announcement->status === 'Published' ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                            {{ $announcement->status }}
                        </span>
                    </div>

                    <h2 class="mt-3 text-xl font-bold text-mustBlue">{{ $announcement->title }}</h2>
                    <p class="mt-2 whitespace-pre-line text-sm leading-6 text-gray-600">{{ Str::limit($announcement->message, 180) }}</p>

                    <div class="mt-4 flex flex-wrap items-end justify-between gap-3 border-t border-gray-100 pt-4 text-xs text-gray-500">
                        <div>
                            <p>{{ $announcement->author?->name ?? 'Clinic team' }}</p>
                            <p class="mt-1">
                                {{ $announcement->published_at?->format('M d, Y H:i') ?? 'Not scheduled' }}
                                @if ($announcement->image_path)
                                    &middot; Image {{ $announcement->image_position }}
                                @endif
                            </p>
                        </div>

                        <div class="flex gap-3 text-sm">
                            @can('update announcement')
                                <a href="{{ route('admin.announcements.edit', $announcement) }}" class="text-mustBlue hover:text-mustGreen">Edit</a>
                            @endcan
                            @can('delete announcement')
                                <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete_item text-red-500 hover:text-red-700">Delete</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </article>
        @empty
            <div class="page-content-container text-center text-gray-500 lg:col-span-2">
                No announcements have been created yet.
            </div>
        @endforelse
    </div>

    @if ($announcements->hasPages())
        <div class="mt-6">{{ $announcements->links() }}</div>
    @endif
@endsection
