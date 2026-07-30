<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdmissionController extends Controller
{
    /**
     * Show the admission application form.
     */
    public function apply(): View
    {
        return view('apply');
    }

    /**
     * Store the admission application in the database.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'size:11', 'regex:/^[0-9]+$/'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'program_type' => ['required', 'string'],
            'admission_type' => ['required', 'string'],
            'ssc_or_equivalent' => ['required', 'string', 'max:255'],
            'ssc_division_or_gpa' => ['required', 'string', 'max:255'],
            'hsc_or_equivalent' => ['required', 'string', 'max:255'],
            'hsc_division_or_gpa' => ['required', 'string', 'max:255'],
            'bachelor_or_degree_hons' => ['nullable', 'string', 'max:255'],
            'bachelor_division_or_gpa' => ['nullable', 'string', 'max:255'],
        ]);

        Student::create($validated);

        return redirect()->route('home')
            ->with('success', 'Your online admission application has been submitted successfully.');
    }
}
