<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\UniversitySetting;
use App\Models\User;
use Illuminate\Http\Request;

class CertificateController extends Controller
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
            $certificates = $user->certificates;
        } else {
            $certificates = Certificate::with(['student', 'creator'])->latest()->get();
        }

        return view('certificates.index', compact('certificates', 'setting'));
    }

    public function create()
    {
        if (! auth()->user()->can('create certificate')) {
            abort(403, 'Unauthorized action.');
        }

        $setting = UniversitySetting::first() ?? new UniversitySetting([
            'name' => 'Dhaka Global University',
            'address' => 'Purbachal Model Town, Uttara, Dhaka, Bangladesh',
            'contacts' => [['type' => 'Email', 'value' => 'contact@dhakaglobal.university']],
        ]);

        $students = User::role('Student')->where('status', 'active')->get();

        return view('certificates.create', compact('students', 'setting'));
    }

    public function store(Request $request)
    {
        if (! auth()->user()->can('create certificate')) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'student_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'roll' => 'required|string|max:255',
            'reg_no' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'cgpa' => 'required|string|max:255',
            'out_of' => 'required|string|max:255',
        ]);

        $validated['created_by'] = auth()->id();

        Certificate::create($validated);

        return redirect()->route('certificates.index')->with('success', 'Certificate created successfully.');
    }

    public function show(Certificate $certificate)
    {
        $user = auth()->user();
        $setting = UniversitySetting::first() ?? new UniversitySetting([
            'name' => 'Dhaka Global University',
            'address' => 'Purbachal Model Town, Uttara, Dhaka, Bangladesh',
            'contacts' => [['type' => 'Email', 'value' => 'contact@dhakaglobal.university']],
        ]);

        if ($user->hasRole('Student') && $certificate->student_id !== $user->id) {
            abort(403, 'Unauthorized access to certificate.');
        }

        return view('certificates.show', compact('certificate', 'setting'));
    }

    public function verify(Request $request, Certificate $certificate)
    {
        $setting = UniversitySetting::first() ?? new UniversitySetting([
            'name' => 'Dhaka Global University',
            'address' => 'Purbachal Model Town, Uttara, Dhaka, Bangladesh',
            'contacts' => [['type' => 'Email', 'value' => 'contact@dhakaglobal.university']],
        ]);

        $sessionKey = 'verified_certificate_'.$certificate->id;

        if ($request->isMethod('post')) {
            $request->validate([
                'roll' => 'required|string',
                'reg_no' => 'required|string',
            ]);

            if ($request->roll === $certificate->roll && $request->reg_no === $certificate->reg_no) {
                session([$sessionKey => true]);

                return redirect()->refresh();
            }

            return back()->withErrors([
                'verification' => 'The provided Exam Roll or Registration number is incorrect.',
            ])->withInput();
        }

        if (session($sessionKey) === true) {
            return view('certificates.show', compact('certificate', 'setting'));
        }

        return view('certificates.verify_gate', compact('certificate', 'setting'));
    }

    public function showVerificationForm()
    {
        $setting = UniversitySetting::first() ?? new UniversitySetting([
            'name' => 'Dhaka Global University',
            'address' => 'Purbachal Model Town, Uttara, Dhaka, Bangladesh',
            'contacts' => [['type' => 'Email', 'value' => 'contact@dhakaglobal.university']],
        ]);

        return view('certificates.verification_search', compact('setting'));
    }

    public function searchVerification(Request $request)
    {
        $request->validate([
            'roll' => 'required|string',
            'reg_no' => 'required|string',
        ]);

        $certificate = Certificate::where('roll', $request->roll)
            ->where('reg_no', $request->reg_no)
            ->first();

        if ($certificate) {
            $sessionKey = 'verified_certificate_'.$certificate->id;
            session([$sessionKey => true]);

            return redirect()->route('certificates.verify', $certificate);
        }

        return back()->withErrors([
            'search' => 'No certificate found matching the provided Exam Roll and Registration Number.',
        ])->withInput();
    }

    public function destroy(Certificate $certificate)
    {
        if (! auth()->user()->hasAnyRole(['Principal', 'Teacher'])) {
            abort(403, 'Unauthorized action.');
        }

        $certificate->delete();

        return redirect()->route('certificates.index')->with('success', 'Certificate deleted successfully.');
    }
}
