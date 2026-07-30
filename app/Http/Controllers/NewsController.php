<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    /**
     * Display a listing of public news articles.
     */
    public function index(Request $request): View
    {
        $query = News::where('status', 'published')->latest();

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $news = $query->paginate(6);

        return view('news.index', compact('news'));
    }

    /**
     * Display the specified public news article.
     */
    public function show(News $news): View
    {
        if ($news->status !== 'published') {
            abort(404);
        }

        $recentNews = News::where('status', 'published')
            ->where('id', '!=', $news->id)
            ->latest()
            ->take(5)
            ->get();

        return view('news.show', compact('news', 'recentNews'));
    }
}
