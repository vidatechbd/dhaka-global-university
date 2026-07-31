<?php

namespace App\Http\Controllers;

use App\Models\Marksheet;
use App\Models\UniversitySetting;
use App\Models\User;
use Illuminate\Http\Request;

class MarksheetController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $setting = UniversitySetting::first() ?? new UniversitySetting([
            'name' => 'Dhaka Global University',
            'address' => 'Purbachal Model Town, Uttara, Dhaka, Bangladesh',
            'contacts' => [['type' => 'Email', 'value' => 'contact@dhakaglobal.university']],
        ]);

        if ($user->hasRole('Student')) {
            $marksheets = $user->marksheets;
        } else {
            $marksheets = Marksheet::with(['student', 'creator'])->latest()->get();
        }

        return view('marksheets.index', compact('marksheets', 'setting'));
    }

    public function create()
    {
        if (! auth()->user()->can('create marksheet')) {
            abort(403, 'Unauthorized action.');
        }

        $setting = UniversitySetting::first() ?? new UniversitySetting([
            'name' => 'Dhaka Global University',
            'address' => 'Purbachal Model Town, Uttara, Dhaka, Bangladesh',
            'contacts' => [['type' => 'Email', 'value' => 'contact@dhakaglobal.university']],
        ]);

        $students = User::role('Student')->where('status', 'active')->get();

        return view('marksheets.create', compact('students', 'setting'));
    }

    public function store(Request $request)
    {
        if (! auth()->user()->can('create marksheet')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'student_id' => 'nullable|exists:users,id',
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

        if ($request->student_id) {
            $student = User::findOrFail($request->student_id);
            if (! $student->hasRole('Student') || $student->status !== 'active') {
                return redirect()->back()->with('error', 'Invalid student selected.');
            }
        }

        if (is_string($request->semesters)) {
            $validated['semesters'] = json_decode($request->semesters, true);
        }

        $validated['created_by'] = auth()->id();

        Marksheet::create($validated);

        return redirect()->route('marksheets.index')->with('success', 'Academic transcript/marksheet created successfully.');
    }

    public function show(Marksheet $marksheet)
    {
        $user = auth()->user();
        $setting = UniversitySetting::first() ?? new UniversitySetting([
            'name' => 'Dhaka Global University',
            'address' => 'Purbachal Model Town, Uttara, Dhaka, Bangladesh',
            'contacts' => [['type' => 'Email', 'value' => 'contact@dhakaglobal.university']],
        ]);

        if ($user->hasRole('Student') && $marksheet->student_id !== $user->id) {
            abort(403, 'Unauthorized access to marksheet.');
        }

        return view('marksheets.show', compact('marksheet', 'setting'));
    }

    public function verify(Request $request, Marksheet $marksheet)
    {
        $setting = UniversitySetting::first() ?? new UniversitySetting([
            'name' => 'Dhaka Global University',
            'address' => 'Purbachal Model Town, Uttara, Dhaka, Bangladesh',
            'contacts' => [['type' => 'Email', 'value' => 'contact@dhakaglobal.university']],
        ]);

        $sessionKey = 'verified_marksheet_'.$marksheet->id;

        if ($request->isMethod('post')) {
            $request->validate([
                'exam_roll' => 'required|string',
                'reg_no' => 'required|string',
            ]);

            if ($request->exam_roll === $marksheet->exam_roll && $request->reg_no === $marksheet->reg_no) {
                session([$sessionKey => true]);

                return redirect()->refresh();
            }

            return back()->withErrors([
                'verification' => 'The provided Exam Roll or Registration number is incorrect.',
            ])->withInput();
        }

        if (session($sessionKey) === true) {
            return view('marksheets.show', compact('marksheet', 'setting'));
        }

        return view('marksheets.verify_gate', compact('marksheet', 'setting'));
    }

    public function destroy(Marksheet $marksheet)
    {
        if (! auth()->user()->hasAnyRole(['Principal', 'Teacher'])) {
            abort(403, 'Unauthorized action.');
        }

        $marksheet->delete();

        return redirect()->route('marksheets.index')->with('success', 'Marksheet/Transcript deleted successfully.');
    }
}
