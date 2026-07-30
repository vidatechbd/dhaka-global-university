<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student as StudentApplication;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class StudentController extends Controller
{
    /**
     * Display student index page.
     */
    public function index(): View
    {
        $activeStudents = User::role('Student')->where('status', 'active')->latest()->get();
        $pendingStudents = StudentApplication::where('status', 'pending')->latest()->get();

        return view('admin.students.index', compact('activeStudents', 'pendingStudents'));
    }

    /**
     * Store manually created student user account.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $student = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'active',
        ]);

        $student->assignRole('Student');

        return redirect()->back()->with('success', 'Student account created successfully.');
    }

    /**
     * Approve student admission application and generate active user account.
     */
    public function approveApplication(int $id): RedirectResponse
    {
        $application = StudentApplication::findOrFail($id);

        // Check if user already exists
        $existingUser = User::where('email', $application->email)->first();
        if ($existingUser) {
            return redirect()->back()->with('error', 'A user account with this email already exists.');
        }

        // Create User
        $user = User::create([
            'name' => $application->name,
            'email' => $application->email,
            'password' => Hash::make('password'), // password is 'password'
            'status' => 'active',
        ]);

        $user->assignRole('Student');

        // Update application
        $application->update([
            'status' => 'approved',
            'user_id' => $user->id,
        ]);

        return redirect()->back()->with('success', 'Student admission application approved successfully.');
    }

    /**
     * Reject/Delete student admission application.
     */
    public function rejectApplication(int $id): RedirectResponse
    {
        $application = StudentApplication::findOrFail($id);
        $application->delete();

        return redirect()->back()->with('success', 'Student admission application rejected successfully.');
    }

    /**
     * Delete active student user account.
     */
    public function destroy(User $student): RedirectResponse
    {
        if (! $student->hasRole('Student')) {
            abort(403);
        }

        $student->delete();

        return redirect()->back()->with('success', 'Student account deleted successfully.');
    }
}
