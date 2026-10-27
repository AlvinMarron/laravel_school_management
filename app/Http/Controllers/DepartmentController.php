<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of departments.
     */
    public function index(Request $request)
    {
        $query = Department::withCount('students');

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('dept_name', 'like', "%{$search}%")
                  ->orWhere('manager_id', 'like', "%{$search}%")
                  ->orWhere('location_id', 'like', "%{$search}%");
            });
        }

        $departments = $query->orderBy('dept_id', 'asc')->paginate(10)->withQueryString();

        return view('departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new department.
     */
    public function create()
    {
        return view('departments.create');
    }

    /**
     * Store a newly created department in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'dept_name' => ['required', 'string', 'max:255', 'unique:departments,dept_name'],
            'manager_id' => ['nullable', 'string', 'max:100'],
            'location_id' => ['nullable', 'string', 'max:150'],
        ]);

        Department::create($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department "' . $validated['dept_name'] . '" was created successfully!');
    }

    /**
     * Display the specified department.
     */
    public function show(Department $department)
    {
        $department->load(['students' => function ($q) {
            $q->orderBy('student_name', 'asc');
        }]);

        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified department.
     */
    public function edit(Department $department)
    {
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified department in storage.
     */
    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'dept_name' => ['required', 'string', 'max:255', 'unique:departments,dept_name,' . $department->dept_id . ',dept_id'],
            'manager_id' => ['nullable', 'string', 'max:100'],
            'location_id' => ['nullable', 'string', 'max:150'],
        ]);

        $department->update($validated);

        return redirect()->route('departments.index')
            ->with('success', 'Department #' . $department->dept_id . ' updated successfully!');
    }

    /**
     * Remove the specified department from storage.
     */
    public function destroy(Department $department)
    {
        $name = $department->dept_name;
        $count = $department->students()->count();

        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', "Department '{$name}' and its {$count} student record(s) deleted successfully.");
    }
}
