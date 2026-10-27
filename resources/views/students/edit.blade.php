@extends('layouts.app')

@section('title', 'Edit Student #' . $student->student_id)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('students.index') }}" class="text-decoration-none">Students</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('students.show', $student) }}" class="text-decoration-none">#{{ $student->student_id }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0">Edit Student Record: {{ $student->student_name }}</h3>
            </div>
            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card card-custom">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-pencil-square text-primary"></i> Update Student Information
                </h5>
                <span class="badge bg-light text-muted border">Student ID #{{ $student->student_id }}</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('students.update', $student) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 mb-3">
                        <!-- Student Name -->
                        <div class="col-md-8">
                            <label for="student_name" class="form-label fw-semibold">Student Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="student_name" id="student_name" class="form-control @error('student_name') is-invalid @enderror" value="{{ old('student_name', $student->student_name) }}" required>
                            @error('student_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="col-md-4">
                            <label for="gender" class="form-label fw-semibold">Gender <span class="text-danger">*</span></label>
                            <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                <option value="Male" {{ old('gender', $student->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender', $student->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender', $student->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Date of Birth -->
                        <div class="col-md-6">
                            <label for="dob" class="form-label fw-semibold">Date of Birth (DOB) <span class="text-danger">*</span></label>
                            <input type="date" name="dob" id="dob" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob', $student->dob ? $student->dob->format('Y-m-d') : '') }}" max="{{ date('Y-m-d') }}" required>
                            @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Department (FK) -->
                        <div class="col-md-6">
                            <label for="dept_id" class="form-label fw-semibold">Assigned Department <span class="text-danger">*</span></label>
                            <select name="dept_id" id="dept_id" class="form-select @error('dept_id') is-invalid @enderror" required>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->dept_id }}" {{ old('dept_id', $student->dept_id) == $dept->dept_id ? 'selected' : '' }}>
                                        {{ $dept->dept_name }} ({{ $dept->location_id ?? 'Campus' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('dept_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Enrollment Status -->
                        <div class="col-md-6">
                            <label for="enrollment" class="form-label fw-semibold">Enrollment Status <span class="text-danger">*</span></label>
                            <select name="enrollment" id="enrollment" class="form-select @error('enrollment') is-invalid @enderror" required>
                                <option value="Active" {{ old('enrollment', $student->enrollment) == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Graduated" {{ old('enrollment', $student->enrollment) == 'Graduated' ? 'selected' : '' }}>Graduated</option>
                                <option value="Suspended" {{ old('enrollment', $student->enrollment) == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                                <option value="Pending" {{ old('enrollment', $student->enrollment) == 'Pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                            @error('enrollment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Enrollment Date -->
                        <div class="col-md-6">
                            <label for="enrollment_date" class="form-label fw-semibold">Enrollment Date <span class="text-danger">*</span></label>
                            <input type="date" name="enrollment_date" id="enrollment_date" class="form-control @error('enrollment_date') is-invalid @enderror" value="{{ old('enrollment_date', $student->enrollment_date ? $student->enrollment_date->format('Y-m-d') : '') }}" required>
                            @error('enrollment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Description / Notes -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Student Notes / Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $student->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteStudentModal">
                            <i class="bi bi-trash me-1"></i> Delete Student
                        </button>

                        <div class="d-flex gap-2">
                            <a href="{{ route('students.index') }}" class="btn btn-light border px-4">Cancel</a>
                            <button type="submit" class="btn btn-primary-custom px-4">
                                <i class="bi bi-check-lg me-1"></i> Update Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Student Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-2">Are you sure you want to permanently delete this student?</p>
                <div class="alert alert-light border fw-bold text-dark">
                    #{{ $student->student_id }} - {{ $student->student_name }}
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
@endsection
