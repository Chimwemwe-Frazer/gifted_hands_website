@extends('layouts.app')

@section('title')
    FAQs
@endsection

@section('content')
    <div class="flex items-center justify-between gap-4">
        <div>
            <h1 class="page-heading">FAQs</h1>
            <p class="mt-1 text-sm text-gray-600">Manage frequently asked questions displayed on the public website.</p>
        </div>
        @can('add faq')
            <a href="{{ route('admin.faqs.create') }}" class="service-action-button service-action-button--primary shrink-0">Add FAQ</a>
        @endcan
    </div>

    <div class="space-y-4">
        @forelse ($faqs as $faq)
            <article class="rounded-lg bg-white p-5 shadow">
                <div class="flex flex-col justify-between gap-4 md:flex-row md:items-start">
                    <div class="min-w-0">
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-lg font-bold text-mustBlue">{{ $faq->question }}</h2>
                            <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $faq->status === 'Active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ $faq->status }}
                            </span>
                            @if ($faq->show_on_home)
                                <span class="rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">Homepage</span>
                            @endif
                        </div>
                        <p class="mt-2 text-sm leading-6 text-gray-600">{{ $faq->brief_answer }}</p>
                        <p class="mt-3 text-xs text-gray-500">Display order: {{ $faq->display_order }}</p>
                    </div>

                    <div class="flex shrink-0 gap-3">
                        @can('update faq')
                            <a href="{{ route('admin.faqs.edit', $faq) }}" class="service-action-button service-action-button--secondary">Edit</a>
                        @endcan
                        @can('delete faq')
                            <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete_item service-action-button service-action-button--danger">Delete</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </article>
        @empty
            <div class="page-content-container text-center text-gray-500">
                No FAQs have been created yet.
            </div>
        @endforelse
    </div>
@endsection
