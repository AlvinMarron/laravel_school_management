<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $totalStudents = Student::count();
        $totalDepartments = Department::count();
        $activeStudents = Student::where('enrollment', 'Active')->count();
        $graduatedStudents = Student::where('enrollment', 'Graduated')->count();
        $maleStudents = Student::where('gender', 'Male')->count();
        $femaleStudents = Student::where('gender', 'Female')->count();

        $recentStudents = Student::with('department')
            ->latest('created_at')
            ->take(6)
            ->get();

        $departments = Department::withCount('students')
            ->orderBy('students_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalStudents',
            'totalDepartments',
            'activeStudents',
            'graduatedStudents',
            'maleStudents',
            'femaleStudents',
            'recentStudents',
            'departments'
        ));
    }
}
