<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Display a listing of public events.
     */
    public function index(Request $request): View
    {
        $query = Event::where('status', 'published')->latest();

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $events = $query->paginate(6);

        return view('events.index', compact('events'));
    }

    /**
     * Display the specified public event.
     */
    public function show(Event $event): View
    {
        if ($event->status !== 'published') {
            abort(404);
        }

        $recentEvents = Event::where('status', 'published')
            ->where('id', '!=', $event->id)
            ->latest()
            ->take(5)
            ->get();

        return view('events.show', compact('event', 'recentEvents'));
    }
}
