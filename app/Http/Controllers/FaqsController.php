<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FaqsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:list faqs', only: ['index']),
            new Middleware('permission:add faq', only: ['create', 'store']),
            new Middleware('permission:update faq', only: ['edit', 'update']),
            new Middleware('permission:delete faq', only: ['destroy']),
        ];
    }

    public function index(): View
    {
        return view('backend.faqs.index', [
            'faqs' => Faq::displayOrder()->get(),
        ]);
    }

    public function create(): View
    {
        return view('backend.faqs.create', [
            'nextDisplayOrder' => (int) Faq::max('display_order') + 1,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        Faq::create($this->validatedData($request));

        return redirect()
            ->route('admin.faqs.index')
            ->with('success', 'FAQ successfully added');
    }

    public function edit(Faq $faq): View
    {
        return view('backend.faqs.create', compact('faq'));
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $faq->update($this->validatedData($request, $faq));

        return redirect()
            ->route('admin.faqs.index')
            ->with('success', 'FAQ successfully updated');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()
            ->route('admin.faqs.index')
            ->with('success', 'FAQ successfully deleted');
    }

    private function validatedData(Request $request, ?Faq $faq = null): array
    {
        $data = $request->validate([
            'question' => [
                'required',
                'string',
                'max:500',
                Rule::unique('faqs', 'question')->ignore($faq),
            ],
            'brief_answer' => ['required', 'string', 'max:1000'],
            'full_answer' => ['required', 'string', 'max:10000'],
            'show_on_home' => ['nullable', 'boolean'],
            'status' => ['required', Rule::in(['Active', 'Inactive'])],
            'display_order' => ['required', 'integer', 'min:1', 'max:9999'],
        ]);

        $data['show_on_home'] = $request->boolean('show_on_home');

        return $data;
    }
}
