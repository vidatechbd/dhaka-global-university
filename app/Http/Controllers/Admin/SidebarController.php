<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sidebar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SidebarController extends Controller
{
    /**
     * Display a listing of the sidebars.
     */
    public function index(): View
    {
        $sidebars = Sidebar::withCount('contents', 'pages')->get();

        return view('admin.sidebars.index', compact('sidebars'));
    }

    /**
     * Show the form for creating a new sidebar.
     */
    public function create(): View
    {
        return view('admin.sidebars.create');
    }

    /**
     * Store a newly created sidebar in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contents' => ['nullable', 'array'],
        ]);

        $sidebar = Sidebar::create(['name' => $validated['name']]);

        $this->saveContents($sidebar, $validated['contents'] ?? []);

        return redirect()->route('admin.sidebars.index')
            ->with('success', 'Sidebar created successfully.');
    }

    /**
     * Show the form for editing the specified sidebar.
     */
    public function edit(Sidebar $sidebar): View
    {
        $sidebar->load('contents');

        return view('admin.sidebars.edit', compact('sidebar'));
    }

    /**
     * Update the specified sidebar in storage.
     */
    public function update(Request $request, Sidebar $sidebar): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contents' => ['nullable', 'array'],
        ]);

        $sidebar->update(['name' => $validated['name']]);

        // Clean old and save new
        $sidebar->contents()->delete();
        $this->saveContents($sidebar, $validated['contents'] ?? []);

        return redirect()->route('admin.sidebars.index')
            ->with('success', 'Sidebar updated successfully.');
    }

    /**
     * Remove the specified sidebar from storage.
     */
    public function destroy(Sidebar $sidebar): RedirectResponse
    {
        $sidebar->delete();

        return redirect()->route('admin.sidebars.index')
            ->with('success', 'Sidebar deleted successfully.');
    }

    /**
     * Process and save sidebar widgets/contents.
     */
    private function saveContents(Sidebar $sidebar, array $contentsInput): void
    {
        foreach ($contentsInput as $index => $item) {
            if (empty($item['title']) && empty($item['content'])) {
                continue;
            }

            $type = $item['type'] ?? 'html';
            $contentValue = $item['content'] ?? '';

            if ($type === 'links') {
                // Parse links input and convert to JSON
                $links = [];
                $titles = $item['link_titles'] ?? [];
                $urls = $item['link_urls'] ?? [];
                foreach ($titles as $k => $title) {
                    if (! empty($title)) {
                        $links[] = [
                            'title' => $title,
                            'url' => $urls[$k] ?? '#',
                        ];
                    }
                }
                $contentValue = json_encode($links);
            }

            $sidebar->contents()->create([
                'title' => $item['title'] ?? null,
                'type' => $type,
                'content' => $contentValue,
                'sort_order' => $item['sort_order'] ?? $index,
            ]);
        }
    }
}
