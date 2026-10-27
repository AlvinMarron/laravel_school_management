<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of students with search and filters.
     */
    public function index(Request $request)
    {
        $query = Student::with('department');

        // Search by student name
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by Department
        if ($request->filled('dept_id')) {
            $query->where('dept_id', $request->input('dept_id'));
        }

        // Filter by Gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->input('gender'));
        }

        // Filter by Enrollment Status
        if ($request->filled('enrollment')) {
            $query->where('enrollment', $request->input('enrollment'));
        }

        // Sort by ID descending (newest first)
        $students = $query->orderBy('student_id', 'desc')->paginate(10)->withQueryString();

        // Get all departments for dropdown filter
        $departments = Department::orderBy('dept_name', 'asc')->get();

        // Pass filter counts for stats badges
        $totalFound = $students->total();

        return view('students.index', compact('students', 'departments', 'totalFound'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $departments = Department::orderBy('dept_name', 'asc')->get();

        return view('students.create', compact('departments'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'dob' => ['required', 'date', 'before:today'],
            'enrollment' => ['required', 'string', 'in:Active,Graduated,Suspended,Pending'],
            'enrollment_date' => ['required', 'date'],
            'dept_id' => ['required', 'exists:departments,dept_id'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $student = Student::create($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student "' . $student->student_name . '" (ID: #' . $student->student_id . ') registered successfully!');
    }

    /**
     * Display the specified student profile.
     */
    public function show(Student $student)
    {
        $student->load('department');

        return view('students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(Student $student)
    {
        $departments = Department::orderBy('dept_name', 'asc')->get();

        return view('students.edit', compact('student', 'departments'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'student_name' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'in:Male,Female,Other'],
            'dob' => ['required', 'date', 'before:today'],
            'enrollment' => ['required', 'string', 'in:Active,Graduated,Suspended,Pending'],
            'enrollment_date' => ['required', 'date'],
            'dept_id' => ['required', 'exists:departments,dept_id'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $student->update($validated);

        return redirect()->route('students.index')
            ->with('success', 'Student record for "' . $student->student_name . '" (ID: #' . $student->student_id . ') updated successfully!');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(Student $student)
    {
        $name = $student->student_name;
        $id = $student->student_id;

        $student->delete();

        return redirect()->route('students.index')
            ->with('success', "Student '{$name}' (ID: #{$id}) deleted successfully.");
    }
}
