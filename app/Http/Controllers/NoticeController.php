<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NoticeController extends Controller
{
    /**
     * Display a listing of public notices.
     */
    public function index(Request $request): View
    {
        $query = Notice::where('status', 'published')->latest();

        if ($request->filled('q')) {
            $search = $request->input('q');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $notices = $query->paginate(10);

        return view('notices.index', compact('notices'));
    }

    /**
     * Display the specified public notice.
     */
    public function show(Notice $notice): View
    {
        if ($notice->status !== 'published') {
            abort(404);
        }

        $recentNotices = Notice::where('status', 'published')
            ->where('id', '!=', $notice->id)
            ->latest()
            ->take(5)
            ->get();

        return view('notices.show', compact('notice', 'recentNotices'));
    }
}
