@extends('layouts.app')

@section('title')
    {{ isset($faq) ? 'Edit FAQ' : 'Add FAQ' }}
@endsection

@section('content')
    @php
        $isCurrentlyPinned = isset($faq) && $faq->show_on_home;
        $homepageLimitReached = $homepageFaqCount >= $homepageFaqLimit && ! $isCurrentlyPinned;
    @endphp

    <div class="flex flex-col items-start gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="page-heading">{{ isset($faq) ? 'Edit FAQ' : 'Add FAQ' }}</h1>
        <a href="{{ route('admin.faqs.index') }}" class="service-action-button service-action-button--secondary">Back</a>
    </div>

    <div class="page-content-container">
        <form action="{{ isset($faq) ? route('admin.faqs.update', $faq) : route('admin.faqs.store') }}" method="POST">
            @csrf
            @isset($faq)
                @method('PUT')
            @endisset

            <div class="mb-6 rounded-lg border border-blue-100 bg-blue-50 p-4 text-sm leading-6 text-blue-800">
                Active FAQs appear on the public FAQs page. You can pin up to {{ $homepageFaqLimit }} FAQs to the homepage.
                {{ $homepageFaqCount }} of {{ $homepageFaqLimit }} homepage slots are currently in use.
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div class="space-y-2 md:col-span-2">
                    <label class="label">Question <span class="text-red-500">*</span></label>
                    <input name="question" class="input" required maxlength="500" value="{{ old('question', $faq->question ?? '') }}">
                    <span class="text-sm text-red-500">{{ $errors->first('question') }}</span>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="label">Brief answer <span class="text-red-500">*</span></label>
                    <textarea name="brief_answer" rows="3" class="input" required maxlength="1000" placeholder="A short answer shown before the visitor expands the FAQ.">{{ old('brief_answer', $faq->brief_answer ?? '') }}</textarea>
                    <span class="text-sm text-red-500">{{ $errors->first('brief_answer') }}</span>
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="label">Full answer <span class="text-red-500">*</span></label>
                    <textarea name="full_answer" rows="7" class="input" required maxlength="10000" placeholder="The complete answer shown when the visitor expands the FAQ.">{{ old('full_answer', $faq->full_answer ?? '') }}</textarea>
                    <span class="text-sm text-red-500">{{ $errors->first('full_answer') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Status <span class="text-red-500">*</span></label>
                    <select name="status" class="input" required>
                        @foreach (['Active', 'Inactive'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $faq->status ?? 'Active') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500">Inactive FAQs remain in admin but are hidden publicly.</p>
                    <span class="text-sm text-red-500">{{ $errors->first('status') }}</span>
                </div>

                <div class="space-y-2">
                    <label class="label">Display order <span class="text-red-500">*</span></label>
                    <input type="number" min="1" max="9999" name="display_order" class="input" required value="{{ old('display_order', $faq->display_order ?? $nextDisplayOrder ?? 1) }}">
                    <p class="text-xs text-gray-500">Lower numbers appear first.</p>
                    <span class="text-sm text-red-500">{{ $errors->first('display_order') }}</span>
                </div>

                <div class="md:col-span-2">
                    <label class="inline-flex items-center gap-3 text-sm font-semibold text-gray-700">
                        <input type="hidden" name="show_on_home" value="0">
                        <input type="checkbox" name="show_on_home" value="1" class="rounded border-gray-300 text-mustGreen focus:ring-mustGreen disabled:cursor-not-allowed disabled:opacity-50" @checked(! $homepageLimitReached && old('show_on_home', $faq->show_on_home ?? false)) @disabled($homepageLimitReached)>
                        Show this FAQ on the homepage
                    </label>
                    @if ($homepageLimitReached)
                        <p class="mt-2 text-xs text-amber-700">All homepage slots are in use. Unpin another FAQ before pinning this one.</p>
                    @else
                        <p class="mt-2 text-xs text-gray-500">Pinned active FAQs appear on the homepage, with the newest shown first.</p>
                    @endif
                    <span class="mt-2 block text-sm text-red-500">{{ $errors->first('show_on_home') }}</span>
                </div>
            </div>

            <div class="mt-6 flex justify-stretch sm:justify-end">
                <button type="submit" class="service-action-button service-action-button--primary w-full sm:w-auto">{{ isset($faq) ? 'Update FAQ' : 'Save FAQ' }}</button>
            </div>
        </form>
    </div>
@endsection
