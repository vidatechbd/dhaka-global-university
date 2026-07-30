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
        $pages = Page::latest()->paginate(10);

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new page.
     */
    public function create(): View
    {
        return view('admin.pages.create');
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
        return view('admin.pages.edit', compact('page'));
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
