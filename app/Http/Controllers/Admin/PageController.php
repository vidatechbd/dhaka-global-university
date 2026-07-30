<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display a listing of the pages.
     */
    public function index(): View
    {
        $pages = Page::with('parent')->orderBy('sort_order')->orderBy('title')->paginate(10);

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new page.
     */
    public function create(): View
    {
        $parentPages = Page::orderBy('title')->get();

        return view('admin.pages.create', compact('parentPages'));
    }

    /**
     * Store a newly created page in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
        ]);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:pages,slug'],
            'content' => ['required', 'string'],
            'parent_id' => ['nullable', 'exists:pages,id'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        Page::create($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit(Page $page): View
    {
        $parentPages = Page::where('id', '!=', $page->id)->orderBy('title')->get();

        return view('admin.pages.edit', compact('page', 'parentPages'));
    }

    /**
     * Update the specified page in storage.
     */
    public function update(Request $request, Page $page): RedirectResponse
    {
        $request->merge([
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
        ]);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:pages,slug,'.$page->id],
            'content' => ['required', 'string'],
            'parent_id' => ['nullable', 'exists:pages,id', 'different:id'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $page->update($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified page from storage.
     */
    public function destroy(Page $page): RedirectResponse
    {
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}
