<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class NoticeController extends Controller
{
    public function index(): View
    {
        $notices = Notice::with('user')->latest()->get();

        return view('admin.notices.index', compact('notices'));
    }

    public function create(): View
    {
        return view('admin.notices.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,png,jpeg,webp', 'max:5120'], // 5MB
            'status' => ['required', 'in:draft,published'],
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();
            $targetDir = public_path('uploads/notices');

            if (! File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $file->move($targetDir, $filename);
            $filePath = 'uploads/notices/'.$filename;
        }

        Notice::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'file_path' => $filePath,
            'status' => $validated['status'],
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice created successfully.');
    }

    public function edit(Notice $notice): View
    {
        return view('admin.notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,png,jpeg,webp', 'max:5120'], // 5MB
            'status' => ['required', 'in:draft,published'],
        ]);

        $filePath = $notice->file_path;
        if ($request->hasFile('file')) {
            // Delete old file
            if ($filePath && File::exists(public_path($filePath))) {
                File::delete(public_path($filePath));
            }

            $file = $request->file('file');
            $filename = uniqid().'_'.time().'.'.$file->getClientOriginalExtension();
            $targetDir = public_path('uploads/notices');

            if (! File::exists($targetDir)) {
                File::makeDirectory($targetDir, 0755, true);
            }

            $file->move($targetDir, $filename);
            $filePath = 'uploads/notices/'.$filename;
        }

        $notice->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'file_path' => $filePath,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice updated successfully.');
    }

    public function destroy(Notice $notice): RedirectResponse
    {
        if ($notice->file_path && File::exists(public_path($notice->file_path))) {
            File::delete(public_path($notice->file_path));
        }

        $notice->delete();

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice deleted successfully.');
    }
}
