<?php

namespace App\Http\Controllers;

use App\Models\HomepageSetting;
use App\Models\News;
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

        return view('home', compact('setting', 'news'));
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
