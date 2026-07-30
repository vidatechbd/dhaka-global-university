<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index(): View
    {
        $events = Event::with('user')->latest()->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create(): View
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
        ]);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:events,slug'],
            'content' => ['required', 'string'],
            'status' => ['required', 'string', 'in:published,draft'],
            'event_date' => ['nullable', 'date'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = uniqid().'_'.time().'.webp';
            $targetDir = public_path('uploads/events');

            if (! File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $targetPath = $targetDir.'/'.$filename;

            $resized = $this->resizeImage($file->getRealPath(), $targetPath, 600, 400);
            if (! $resized) {
                $file->move($targetDir, $filename);
            }

            $validated['thumbnail'] = 'uploads/events/'.$filename;
        }

        $request->user()->events()->create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event): View
    {
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event): RedirectResponse
    {
        $request->merge([
            'slug' => $request->slug ? Str::slug($request->slug) : Str::slug($request->title),
        ]);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:events,slug,'.$event->id],
            'content' => ['required', 'string'],
            'status' => ['required', 'string', 'in:published,draft'],
            'event_date' => ['nullable', 'date'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($event->thumbnail && File::exists(public_path($event->thumbnail))) {
                File::delete(public_path($event->thumbnail));
            }

            $file = $request->file('thumbnail');
            $filename = uniqid().'_'.time().'.webp';
            $targetDir = public_path('uploads/events');

            if (! File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $targetPath = $targetDir.'/'.$filename;

            $resized = $this->resizeImage($file->getRealPath(), $targetPath, 600, 400);
            if (! $resized) {
                $file->move($targetDir, $filename);
            }

            $validated['thumbnail'] = 'uploads/events/'.$filename;
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event): RedirectResponse
    {
        if ($event->thumbnail && File::exists(public_path($event->thumbnail))) {
            File::delete(public_path($event->thumbnail));
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Resize and compress image using Intervention Image manager
     */
    private function resizeImage(string $filePath, string $targetPath, int $width = 600, int $height = 400): bool
    {
        try {
            $manager = new ImageManager(new Driver);
            $image = $manager->read($filePath);
            $image->cover($width, $height);
            $image->toWebp(80)->save($targetPath);

            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}
