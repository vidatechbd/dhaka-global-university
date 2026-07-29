<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\User;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Student')) {
            $certificates = $user->certificates;
            $students = collect();
        } else {
            $certificates = Certificate::with(['student', 'creator'])->latest()->get();
            $students = User::role('Student')->where('status', 'active')->get();
        }

        return view('certificates.index', compact('certificates', 'students'));
    }

    public function store(Request $request)
    {
        if (! auth()->user()->can('create certificate')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'department' => 'nullable|string|max:255',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'course_name' => 'nullable|string|max:255',
            'exam_roll' => 'nullable|string|max:255',
            'reg_no' => 'nullable|string|max:255',
            'session' => 'nullable|string|max:255',
            'credit_completed' => 'nullable|string|max:255',
            'credit_total' => 'nullable|string|max:255',
            'result' => 'nullable|string|max:255',
            'semesters' => 'nullable',
        ]);

        $student = User::findOrFail($request->student_id);
        if (! $student->hasRole('Student') || $student->status !== 'active') {
            return redirect()->back()->with('error', 'Invalid student selected.');
        }

        if (is_string($request->semesters)) {
            $validated['semesters'] = json_decode($request->semesters, true);
        }

        $validated['created_by'] = auth()->id();

        Certificate::create($validated);

        return redirect()->route('certificates.index')->with('success', 'Academic transcript/certificate created successfully.');
    }

    public function show(Certificate $certificate)
    {
        $user = auth()->user();

        if ($user->hasRole('Student') && $certificate->student_id !== $user->id) {
            abort(403, 'Unauthorized access to certificate.');
        }

        return view('certificates.show', compact('certificate'));
    }
}
