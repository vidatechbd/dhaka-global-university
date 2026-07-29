<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::role('Teacher')->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', Rules\Password::defaults()],
        ]);

        $teacher = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'active',
        ]);

        $teacher->assignRole('Teacher');

        return redirect()->back()->with('success', 'Teacher account created successfully.');
    }

    public function destroy(User $teacher)
    {
        if (! $teacher->hasRole('Teacher')) {
            abort(403);
        }

        $teacher->delete();

        return redirect()->back()->with('success', 'Teacher account deleted successfully.');
    }
}
