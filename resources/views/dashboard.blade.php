@extends('layouts.app')

@section('title', 'Administrative Dashboard')

@section('content')
<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <h2 class="fw-bold mb-1 text-dark">Dashboard Overview</h2>
        <p class="text-muted mb-0">Welcome to your Student Management System on Laravel 13.</p>
    </div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0 d-flex gap-2 justify-content-md-end">
        <a href="{{ route('students.create') }}" class="btn btn-primary-custom d-flex align-items-center gap-2">
            <i class="bi bi-person-plus-fill"></i> Add Student
        </a>
        <a href="{{ route('departments.create') }}" class="btn btn-outline-dark d-flex align-items-center gap-2">
            <i class="bi bi-building-add"></i> Add Dept
        </a>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary fw-semibold small text-uppercase">Total Students</span>
                <div class="stat-icon bg-primary-subtle text-primary">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <h3 class="fw-bold mb-1">{{ $totalStudents }}</h3>
            <div class="text-muted small">
                <span class="text-success fw-bold"><i class="bi bi-check-circle"></i> {{ $activeStudents }}</span> Active enrolled
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary fw-semibold small text-uppercase">Departments</span>
                <div class="stat-icon bg-info-subtle text-info">
                    <i class="bi bi-building"></i>
                </div>
            </div>
            <h3 class="fw-bold mb-1">{{ $totalDepartments }}</h3>
            <div class="text-muted small">
                <span class="text-info fw-bold"><i class="bi bi-diagram-3"></i> Academic</span> Faculties
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary fw-semibold small text-uppercase">Graduated</span>
                <div class="stat-icon bg-success-subtle text-success">
                    <i class="bi bi-mortarboard"></i>
                </div>
            </div>
            <h3 class="fw-bold mb-1">{{ $graduatedStudents }}</h3>
            <div class="text-muted small">
                <span class="text-primary fw-bold">Alumni</span> Records archived
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="stat-card">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="text-secondary fw-semibold small text-uppercase">Gender Ratio</span>
                <div class="stat-icon bg-warning-subtle text-warning">
                    <i class="bi bi-gender-ambiguous"></i>
                </div>
            </div>
            <h3 class="fw-bold mb-1">{{ $maleStudents }}M / {{ $femaleStudents }}F</h3>
            <div class="text-muted small">
                Male & Female distribution
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Recent Students Table -->
    <div class="col-lg-8">
        <div class="card card-custom h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history text-primary"></i> Recently Enrolled Students
                </h5>
                <a href="{{ route('students.index') }}" class="btn btn-sm btn-link text-decoration-none fw-semibold">
                    View All Students <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-custom align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Gender</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentStudents as $student)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-light text-primary fw-bold d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        {{ strtoupper(substr($student->student_name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('students.show', $student) }}" class="fw-semibold text-decoration-none text-dark">
                                            {{ $student->student_name }}
                                        </a>
                                        <div class="text-muted small">ID: #{{ $student->student_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $student->gender == 'Female' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' }}">
                                    {{ $student->gender }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-dept">
                                    <i class="bi bi-building me-1"></i>{{ $student->department->dept_name ?? 'N/A' }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $badgeClass = match($student->enrollment) {
                                        'Active' => 'badge-active',
                                        'Graduated' => 'badge-graduated',
                                        'Suspended' => 'badge-suspended',
                                        default => 'badge-pending'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }} px-2 py-1">
                                    {{ $student->enrollment }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('students.show', $student) }}" class="btn btn-sm btn-outline-primary" title="View details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No students recorded yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Departments Overview -->
    <div class="col-lg-4">
        <div class="card card-custom h-100">
            <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-pie-chart text-info"></i> Top Departments
                </h5>
                <a href="{{ route('departments.index') }}" class="btn btn-sm btn-link text-decoration-none fw-semibold">
                    All <i class="bi bi-arrow-right"></i>
                </a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($departments as $dept)
                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                        <div>
                            <a href="{{ route('departments.show', $dept) }}" class="fw-semibold text-decoration-none text-dark">
                                {{ $dept->dept_name }}
                            </a>
                            <div class="text-muted small">
                                <i class="bi bi-geo-alt"></i> {{ $dept->location_id ?? 'Campus' }}
                            </div>
                        </div>
                        <span class="badge bg-primary rounded-pill px-3 py-2">
                            {{ $dept->students_count }} students
                        </span>
                    </li>
                    @empty
                    <li class="list-group-item text-center py-4 text-muted">No departments created yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
