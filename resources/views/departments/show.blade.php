@extends('layouts.app')

@section('title', $department->dept_name . ' - Details')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-1">
                <li class="breadcrumb-item"><a href="{{ route('departments.index') }}" class="text-decoration-none">Departments</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dept #{{ $department->dept_id }}</li>
            </ol>
        </nav>
        <h2 class="fw-bold mb-0 text-dark">{{ $department->dept_name }}</h2>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back
        </a>
        <a href="{{ route('departments.edit', $department) }}" class="btn btn-outline-dark">
            <i class="bi bi-pencil me-1"></i> Edit Dept
        </a>
        <a href="{{ route('students.create') }}?dept_id={{ $department->dept_id }}" class="btn btn-primary-custom">
            <i class="bi bi-person-plus-fill me-1"></i> Add Student Here
        </a>
    </div>
</div>

<!-- Department Overview Cards -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card">
            <span class="text-secondary fw-semibold small text-uppercase">Department PK</span>
            <h4 class="fw-bold text-dark mt-1 mb-0">#{{ $department->dept_id }}</h4>
            <div class="text-muted small">Primary Key (PK)</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <span class="text-secondary fw-semibold small text-uppercase">Manager ID</span>
            <h5 class="fw-bold text-dark mt-1 mb-0">{{ $department->manager_id ?? 'Not Assigned' }}</h5>
            <div class="text-muted small">Department Head</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <span class="text-secondary fw-semibold small text-uppercase">Location / Facility</span>
            <h6 class="fw-bold text-dark mt-1 mb-0 text-truncate">{{ $department->location_id ?? 'Main Campus' }}</h6>
            <div class="text-muted small">Building & Room</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card">
            <span class="text-secondary fw-semibold small text-uppercase">Enrolled Students</span>
            <h4 class="fw-bold text-primary mt-1 mb-0">{{ $department->students->count() }}</h4>
            <div class="text-muted small">Linked by dept_id (FK)</div>
        </div>
    </div>
</div>

<!-- Enrolled Students in this Department (HTML Table) -->
<div class="card card-custom">
    <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
        <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
            <i class="bi bi-people text-primary"></i> Students Enrolled in {{ $department->dept_name }}
        </h5>
        <span class="badge bg-primary-subtle text-primary px-3 py-2">
            {{ $department->students->count() }} Student Record(s)
        </span>
    </div>
    <div class="table-responsive">
        <table class="table table-custom align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 70px;">ID</th>
                    <th>Student Name</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Enrollment Status</th>
                    <th>Enrollment Date</th>
                    <th>Description</th>
                    <th class="text-end" style="width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($department->students as $student)
                <tr>
                    <td class="fw-bold text-muted">#{{ $student->student_id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle bg-primary-subtle text-primary fw-bold d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                {{ strtoupper(substr($student->student_name, 0, 1)) }}
                            </span>
                            <a href="{{ route('students.show', $student) }}" class="fw-bold text-dark text-decoration-none">
                                {{ $student->student_name }}
                            </a>
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ $student->gender == 'Female' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' }}">
                            {{ $student->gender }}
                        </span>
                    </td>
                    <td>{{ $student->dob ? $student->dob->format('M d, Y') : '-' }}</td>
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
                    <td>{{ $student->enrollment_date ? $student->enrollment_date->format('M d, Y') : '-' }}</td>
                    <td>
                        <span class="text-muted small">
                            {{ Str::limit($student->description ?? 'No description', 25) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('students.show', $student) }}" class="btn btn-outline-primary" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('students.edit', $student) }}" class="btn btn-outline-secondary" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-mortarboard fs-1 d-block mb-2"></i>
                            <h6>No students currently enrolled in this department.</h6>
                            <a href="{{ route('students.create') }}?dept_id={{ $department->dept_id }}" class="btn btn-sm btn-primary-custom mt-2">
                                <i class="bi bi-person-plus-fill me-1"></i> Enroll First Student
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
