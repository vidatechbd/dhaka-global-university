<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Event;
use App\Models\Marksheet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the university dashboard.
     */
    public function index(Request $request): View
    {
        $totalStudents = User::role('Student')->count();
        $pendingStudents = User::role('Student')->where('status', 'pending')->count();
        $totalMarksheets = Marksheet::count();
        $totalCertificates = Certificate::count();

        // Passing rate: percentage of marksheets with CGPA >= 2.00 (of 4.00)
        $passingCount = Marksheet::whereNotNull('result')->where('result', '<>', '')->get()
            ->filter(fn ($m) => (float) $m->result >= 2.00)
            ->count();
        $gradedCount = Marksheet::whereNotNull('result')->where('result', '<>', '')->count();
        $passingRate = $gradedCount > 0 ? round(($passingCount / $gradedCount) * 100, 1) : 0;

        // Upcoming events
        $upcomingEvents = Event::where('status', 'published')
            ->where('event_date', '>=', now()->startOfDay())
            ->count();

        // 1. Enrollment trend (last 6 months registrations) - for admission bar chart
        $registrationTrend = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthName = $date->format('M');
            $count = User::role('Student')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->count();
            $registrationTrend[] = [
                'month' => $monthName,
                'count' => $count,
            ];
        }

        return view('dashboard', compact(
            'totalStudents',
            'pendingStudents',
            'totalMarksheets',
            'totalCertificates',
            'passingRate',
            'upcomingEvents',
            'registrationTrend'
        ));
    }
}
