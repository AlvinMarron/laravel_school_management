@extends('layouts.app')

@section('title', $student->student_name . ' - Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('students.index') }}" class="text-decoration-none">Students</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile #{{ $student->student_id }}</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0">Student Profile</h3>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('students.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
                <a href="{{ route('students.edit', $student) }}" class="btn btn-primary-custom">
                    <i class="bi bi-pencil-square me-1"></i> Edit Student
                </a>
            </div>
        </div>

        <div class="card card-custom overflow-hidden mb-4">
            <div class="p-4 text-white" style="background: linear-gradient(135deg, #4338ca 0%, #312e81 100%);">
                <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-white text-primary fw-bold d-flex align-items-center justify-content-center fs-3 shadow" style="width: 64px; height: 64px;">
                            {{ strtoupper(substr($student->student_name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">{{ $student->student_name }}</h4>
                            <div class="text-indigo-200 small d-flex align-items-center gap-2 flex-wrap">
                                <span><i class="bi bi-person-badge"></i> Student ID: #{{ $student->student_id }}</span>
                                <span>&bull;</span>
                                <span><i class="bi bi-gender-ambiguous"></i> {{ $student->gender }}</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        @php
                            $badgeClass = match($student->enrollment) {
                                'Active' => 'bg-success',
                                'Graduated' => 'bg-info',
                                'Suspended' => 'bg-danger',
                                default => 'bg-warning text-dark'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }} px-3 py-2 fs-6 shadow-sm">
                            <i class="bi bi-circle-fill me-1" style="font-size: 0.6rem;"></i> {{ $student->enrollment }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row g-4">
                    <!-- Academic & Relational Information -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 bg-light border h-100">
                            <h6 class="fw-bold text-dark text-uppercase small mb-3 border-bottom pb-2">
                                <i class="bi bi-building text-primary me-1"></i> Department Affiliation (Relational Table)
                            </h6>
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="text-secondary fw-semibold" style="width: 140px;">Department:</td>
                                    <td>
                                        @if($student->department)
                                            <a href="{{ route('departments.show', $student->department) }}" class="fw-bold text-decoration-none" style="color: var(--sms-primary);">
                                                {{ $student->department->dept_name }}
                                            </a>
                                        @else
                                            <span class="text-muted">No Department</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-secondary fw-semibold">Dept ID (FK):</td>
                                    <td><span class="badge bg-secondary-subtle text-secondary-emphasis">dept_id #{{ $student->dept_id }}</span></td>
                                </tr>
                                <tr>
                                    <td class="text-secondary fw-semibold">Manager ID:</td>
                                    <td>{{ $student->department->manager_id ?? 'Not specified' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary fw-semibold">Location / Lab:</td>
                                    <td>{{ $student->department->location_id ?? 'Campus Grounds' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Personal Information -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 bg-light border h-100">
                            <h6 class="fw-bold text-dark text-uppercase small mb-3 border-bottom pb-2">
                                <i class="bi bi-card-checklist text-primary me-1"></i> Enrollment & Personal Data
                            </h6>
                            <table class="table table-sm table-borderless mb-0">
                                <tr>
                                    <td class="text-secondary fw-semibold" style="width: 140px;">Date of Birth:</td>
                                    <td>{{ $student->dob ? $student->dob->format('F d, Y') : '-' }} <small class="text-muted">({{ $student->dob ? $student->dob->age . ' yrs old' : '' }})</small></td>
                                </tr>
                                <tr>
                                    <td class="text-secondary fw-semibold">Enrollment Date:</td>
                                    <td>{{ $student->enrollment_date ? $student->enrollment_date->format('F d, Y') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary fw-semibold">Record Created:</td>
                                    <td>{{ $student->created_at ? $student->created_at->format('M d, Y h:i A') : '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary fw-semibold">Last Updated:</td>
                                    <td>{{ $student->updated_at ? $student->updated_at->format('M d, Y h:i A') : '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Description / Remarks -->
                <div class="mt-4 p-3 rounded-3 bg-white border">
                    <h6 class="fw-bold text-dark text-uppercase small mb-2">
                        <i class="bi bi-chat-left-text text-primary me-1"></i> Student Description / Notes
                    </h6>
                    <p class="text-muted mb-0">
                        {{ $student->description ?: 'No additional notes provided for this student.' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
