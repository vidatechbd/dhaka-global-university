<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class GalleryController extends Controller
{
    public function index(): View
    {
        $galleryItems = Gallery::latest()->get();

        return view('admin.gallery.index', compact('galleryItems'));
    }

    public function create(): View
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'], // 5MB
            'category' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $imagePath = '';
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = uniqid().'_'.time().'.webp';
            $targetDir = public_path('uploads/gallery');

            if (! File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $targetPath = $targetDir.'/'.$filename;

            try {
                $manager = new ImageManager(new Driver);
                $image = $manager->read($file->getRealPath());
                $image->toWebp(80)->save($targetPath);
                $imagePath = 'uploads/gallery/'.$filename;
            } catch (\Throwable $e) {
                $file->move($targetDir, $filename);
                $imagePath = 'uploads/gallery/'.$filename;
            }
        }

        Gallery::create([
            'title' => $validated['title'],
            'image_path' => $imagePath,
            'category' => $validated['category'] ?? 'Campus',
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery item added successfully.');
    }

    public function edit(Gallery $gallery): View
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'], // 5MB
            'category' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:draft,published'],
        ]);

        $imagePath = $gallery->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath && File::exists(public_path($imagePath))) {
                File::delete(public_path($imagePath));
            }

            $file = $request->file('image');
            $filename = uniqid().'_'.time().'.webp';
            $targetDir = public_path('uploads/gallery');

            if (! File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $targetPath = $targetDir.'/'.$filename;

            try {
                $manager = new ImageManager(new Driver);
                $image = $manager->read($file->getRealPath());
                $image->toWebp(80)->save($targetPath);
                $imagePath = 'uploads/gallery/'.$filename;
            } catch (\Throwable $e) {
                $file->move($targetDir, $filename);
                $imagePath = 'uploads/gallery/'.$filename;
            }
        }

        $gallery->update([
            'title' => $validated['title'],
            'image_path' => $imagePath,
            'category' => $validated['category'] ?? 'Campus',
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery item updated successfully.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        if ($gallery->image_path && File::exists(public_path($gallery->image_path))) {
            File::delete(public_path($gallery->image_path));
        }

        $gallery->delete();

        return redirect()->route('admin.gallery.index')
            ->with('success', 'Gallery item deleted successfully.');
    }
}
