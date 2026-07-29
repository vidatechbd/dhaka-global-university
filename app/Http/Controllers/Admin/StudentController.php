<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class StudentController extends Controller
{
    public function index()
    {
        $activeStudents = User::role('Student')->where('status', 'active')->get();
        $pendingStudents = User::role('Student')->where('status', 'pending')->get();
        return view('admin.students.index', compact('activeStudents', 'pendingStudents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
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

    public function approve(User $student)
    {
        if (! $student->hasRole('Student')) {
            abort(403);
        }

        $student->update(['status' => 'active']);

        return redirect()->back()->with('success', 'Student account approved successfully.');
    }

    public function destroy(User $student)
    {
        if (! $student->hasRole('Student')) {
            abort(403);
        }

        $student->delete();

        return redirect()->back()->with('success', 'Student account deleted successfully.');
    }
}
