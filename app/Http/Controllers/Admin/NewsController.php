<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class NewsController extends Controller
{
    /**
     * Display a listing of the news.
     */
    public function index(): View
    {
        $news = News::with('user')->latest()->paginate(10);

        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new news item.
     */
    public function create(): View
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created news item in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status' => ['required', 'string', 'in:published,draft'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = uniqid() . '_' . time() . '.webp';
            $targetDir = public_path('uploads/news');

            if (! File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $targetPath = $targetDir . '/' . $filename;

            // Resize and convert to webp format with 80% quality
            $resized = $this->resizeImage($file->getRealPath(), $targetPath, 600, 400);
            if (! $resized) {
                $file->move($targetDir, $filename);
            }

            $validated['thumbnail'] = 'uploads/news/' . $filename;
        }

        $request->user()->news()->create($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article created successfully.');
    }

    /**
     * Show the form for editing the specified news item.
     */
    public function edit(News $news): View
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified news item in storage.
     */
    public function update(Request $request, News $news): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status' => ['required', 'string', 'in:published,draft'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        if ($request->hasFile('thumbnail')) {
            // Delete old file if exists
            if ($news->thumbnail && File::exists(public_path($news->thumbnail))) {
                File::delete(public_path($news->thumbnail));
            }

            $file = $request->file('thumbnail');
            $filename = uniqid() . '_' . time() . '.webp';
            $targetDir = public_path('uploads/news');

            if (! File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $targetPath = $targetDir . '/' . $filename;

            $resized = $this->resizeImage($file->getRealPath(), $targetPath, 600, 400);
            if (! $resized) {
                $file->move($targetDir, $filename);
            }

            $validated['thumbnail'] = 'uploads/news/' . $filename;
        }

        $news->update($validated);

        return redirect()->route('admin.news.index')
            ->with('success', 'News article updated successfully.');
    }

    /**
     * Remove the specified news item from storage.
     */
    public function destroy(News $news): RedirectResponse
    {
        if ($news->thumbnail && File::exists(public_path($news->thumbnail))) {
            File::delete(public_path($news->thumbnail));
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'News article deleted successfully.');
    }

    /**
     * Resize and compress image to WebP format with 80% quality using Intervention Image library.
     */
    private function resizeImage(string $filePath, string $targetPath, int $width = 600, int $height = 400): bool
    {
        try {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($filePath);
            $image->cover($width, $height);
            $image->toWebp(80)->save($targetPath);

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
