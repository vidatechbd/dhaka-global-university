<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Gallery;
use App\Models\HomepageSetting;
use App\Models\News;
use App\Models\Notice;
use App\Models\Page;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Show the application landing page.
     */
    public function index(): View
    {
        $setting = HomepageSetting::firstOrCreate([]);
        $news = News::where('status', 'published')->latest()->take(6)->get();
        $notices = Notice::where('status', 'published')->latest()->take(6)->get();
        $gallery = Gallery::where('status', 'published')->latest()->take(8)->get();
        $upcomingEvents = Event::where('status', 'published')
            ->where(function ($q) {
                $q->where('event_date', '>=', now()->startOfDay())
                    ->orWhereNull('event_date');
            })
            ->latest()
            ->take(4)
            ->get();

        return view('home', compact('setting', 'news', 'notices', 'gallery', 'upcomingEvents'));
    }

    /**
     * Show a dynamic portal page.
     */
    public function showPage(string $slug): View
    {
        $page = Page::where('slug', $slug)->firstOrFail();

        return view('page', compact('page'));
    }
}
