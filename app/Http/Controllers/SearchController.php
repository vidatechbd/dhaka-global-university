<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\News;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Search news articles and campus events.
     */
    public function search(Request $request)
    {
        $q = $request->input('q', '');

        if (empty(trim($q))) {
            return view('search-results', [
                'news' => collect(),
                'events' => collect(),
                'q' => $q,
            ]);
        }

        $news = News::where('status', 'published')
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%");
            })
            ->latest()
            ->get();

        $events = Event::where('status', 'published')
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%");
            })
            ->latest()
            ->get();

        $totalMatches = $news->count() + $events->count();

        // Direct redirection if there is exactly 1 match
        if ($totalMatches === 1) {
            if ($news->count() === 1) {
                return redirect()->route('news.show', $news->first());
            }
            if ($events->count() === 1) {
                return redirect()->route('events.show', $events->first());
            }
        }

        return view('search-results', compact('news', 'events', 'q'));
    }
}
