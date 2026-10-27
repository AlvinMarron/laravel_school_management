@extends('layouts.app')

@section('title', 'Students Directory')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1 text-dark">Students Directory</h2>
        <p class="text-muted mb-0">Manage student records with full relational department links.</p>
    </div>
    <div>
        <a href="{{ route('students.create') }}" class="btn btn-primary-custom d-inline-flex align-items-center gap-2">
            <i class="bi bi-person-plus-fill"></i> Add New Student
        </a>
    </div>
</div>

<!-- Filter and Search Box -->
<div class="card card-custom mb-4">
    <div class="card-body p-3 p-md-4">
        <form action="{{ route('students.index') }}" method="GET" class="row g-3 align-items-end">
            <!-- Search Name -->
            <div class="col-md-4">
                <label for="search" class="form-label small fw-bold text-secondary">SEARCH STUDENT NAME</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
                </div>
            </div>

            <!-- Filter Department -->
            <div class="col-md-3">
                <label for="dept_id" class="form-label small fw-bold text-secondary">FILTER BY DEPARTMENT</label>
                <select name="dept_id" id="dept_id" class="form-select">
                    <option value="">-- All Departments --</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->dept_id }}" {{ request('dept_id') == $dept->dept_id ? 'selected' : '' }}>
                            {{ $dept->dept_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Gender -->
            <div class="col-md-2">
                <label for="gender" class="form-label small fw-bold text-secondary">GENDER</label>
                <select name="gender" id="gender" class="form-select">
                    <option value="">-- All Genders --</option>
                    <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                    <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <!-- Filter Status -->
            <div class="col-md-2">
                <label for="enrollment" class="form-label small fw-bold text-secondary">STATUS</label>
                <select name="enrollment" id="enrollment" class="form-select">
                    <option value="">-- All Status --</option>
                    <option value="Active" {{ request('enrollment') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Graduated" {{ request('enrollment') == 'Graduated' ? 'selected' : '' }}>Graduated</option>
                    <option value="Suspended" {{ request('enrollment') == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                    <option value="Pending" {{ request('enrollment') == 'Pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="col-md-1 d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom w-100" title="Apply Filter">
                    <i class="bi bi-funnel-fill"></i>
                </button>
                @if(request()->anyFilled(['search', 'dept_id', 'gender', 'enrollment']))
                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary" title="Reset Filters">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Active Filter Badges -->
@if(request()->anyFilled(['search', 'dept_id', 'gender', 'enrollment']))
<div class="d-flex align-items-center gap-2 mb-3 flex-wrap">
    <span class="small text-muted fw-semibold">Active Filters ({{ $totalFound }} found):</span>
    @if(request('search'))
        <span class="badge bg-secondary-subtle text-secondary-emphasis">Name: "{{ request('search') }}"</span>
    @endif
    @if(request('dept_id'))
        @php $activeDept = $departments->firstWhere('dept_id', request('dept_id')); @endphp
        <span class="badge bg-primary-subtle text-primary">Dept: {{ $activeDept->dept_name ?? request('dept_id') }}</span>
    @endif
    @if(request('gender'))
        <span class="badge bg-info-subtle text-info">Gender: {{ request('gender') }}</span>
    @endif
    @if(request('enrollment'))
        <span class="badge bg-warning-subtle text-warning">Status: {{ request('enrollment') }}</span>
    @endif
    <a href="{{ route('students.index') }}" class="small text-danger text-decoration-none ms-1">Clear all</a>
</div>
@endif

<!-- Students HTML Table -->
<div class="card card-custom overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 70px;">ID</th>
                    <th>Student Name</th>
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>Department Name (Related)</th>
                    <th>Enrollment</th>
                    <th>Enroll Date</th>
                    <th>Description</th>
                    <th class="text-end" style="width: 130px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr>
                    <td class="fw-bold text-muted">#{{ $student->student_id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <span class="rounded-circle bg-primary-subtle text-primary fw-bold d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                {{ strtoupper(substr($student->student_name, 0, 1)) }}
                            </span>
                            <div>
                                <a href="{{ route('students.show', $student) }}" class="fw-bold text-dark text-decoration-none">
                                    {{ $student->student_name }}
                                </a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ $student->gender == 'Female' ? 'bg-danger-subtle text-danger' : ($student->gender == 'Male' ? 'bg-primary-subtle text-primary' : 'bg-secondary-subtle text-secondary') }}">
                            {{ $student->gender }}
                        </span>
                    </td>
                    <td>
                        <span class="text-nowrap">{{ $student->dob ? $student->dob->format('M d, Y') : '-' }}</span>
                    </td>
                    <td>
                        @if($student->department)
                            <a href="{{ route('departments.show', $student->department) }}" class="text-decoration-none">
                                <span class="badge-dept">
                                    <i class="bi bi-building me-1"></i>{{ $student->department->dept_name }}
                                </span>
                            </a>
                        @else
                            <span class="text-muted fst-italic">None Assigned</span>
                        @endif
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
                    <td>
                        <span class="text-nowrap">{{ $student->enrollment_date ? $student->enrollment_date->format('M d, Y') : '-' }}</span>
                    </td>
                    <td>
                        <span class="text-muted small" title="{{ $student->description }}">
                            {{ Str::limit($student->description ?? 'No notes provided.', 30) }}
                        </span>
                    </td>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('students.show', $student) }}" class="btn btn-outline-primary" title="View Student">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('students.edit', $student) }}" class="btn btn-outline-secondary" title="Edit Student">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-outline-danger" title="Delete Student" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $student->student_id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteModal{{ $student->student_id }}" tabindex="-1" aria-hidden="true" style="text-align: left;">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Student Deletion</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <p class="mb-2">Are you sure you want to delete student:</p>
                                        <div class="alert alert-light border fw-bold text-dark">
                                            #{{ $student->student_id }} - {{ $student->student_name }} ({{ $student->department->dept_name ?? 'No Dept' }})
                                        </div>
                                        <small class="text-danger">This action cannot be undone.</small>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('students.destroy', $student) }}" method="POST" class="d-inline m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Yes, Delete Student</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                            <h5>No students found</h5>
                            <p class="small mb-3">Try clearing search filters or add a new student.</p>
                            <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary-custom">
                                <i class="bi bi-person-plus-fill me-1"></i> Add Student
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($students->hasPages())
    <div class="card-footer bg-white border-top py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="small text-muted">
                Showing {{ $students->firstItem() ?? 0 }} to {{ $students->lastItem() ?? 0 }} of {{ $students->total() }} students
            </div>
            <div>
                {{ $students->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
