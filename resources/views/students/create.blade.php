@extends('layouts.app')

@section('title', 'Add New Student')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('students.index') }}" class="text-decoration-none">Students</a></li>
                        <li class="breadcrumb-item active" aria-current="page">New Student</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0">Register New Student</h3>
            </div>
            <a href="{{ route('students.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card card-custom">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-person-plus text-primary"></i> Student Information & Department Assignment
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('students.store') }}" method="POST">
                    @csrf

                    <div class="row g-3 mb-3">
                        <!-- Student Name -->
                        <div class="col-md-8">
                            <label for="student_name" class="form-label fw-semibold">Student Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="student_name" id="student_name" class="form-control @error('student_name') is-invalid @enderror" value="{{ old('student_name') }}" placeholder="e.g. Emily Watson" required>
                            @error('student_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div class="col-md-4">
                            <label for="gender" class="form-label fw-semibold">Gender <span class="text-danger">*</span></label>
                            <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                <option value="">-- Select Gender --</option>
                                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
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
                            <input type="date" name="dob" id="dob" class="form-control @error('dob') is-invalid @enderror" value="{{ old('dob', '2004-01-01') }}" max="{{ date('Y-m-d') }}" required>
                            @error('dob')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Department (FK) -->
                        <div class="col-md-6">
                            <label for="dept_id" class="form-label fw-semibold">Assigned Department <span class="text-danger">*</span></label>
                            <select name="dept_id" id="dept_id" class="form-select @error('dept_id') is-invalid @enderror" required>
                                <option value="">-- Choose Department --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->dept_id }}" {{ old('dept_id', request('dept_id')) == $dept->dept_id ? 'selected' : '' }}>
                                        {{ $dept->dept_name }} ({{ $dept->location_id ?? 'Campus' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('dept_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text small">Foreign key relationship connecting Student &rarr; Department table.</div>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <!-- Enrollment Status -->
                        <div class="col-md-6">
                            <label for="enrollment" class="form-label fw-semibold">Enrollment Status <span class="text-danger">*</span></label>
                            <select name="enrollment" id="enrollment" class="form-select @error('enrollment') is-invalid @enderror" required>
                                <option value="Active" {{ old('enrollment', 'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Graduated" {{ old('enrollment') == 'Graduated' ? 'selected' : '' }}>Graduated</option>
                                <option value="Suspended" {{ old('enrollment') == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                                <option value="Pending" {{ old('enrollment') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                            @error('enrollment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Enrollment Date -->
                        <div class="col-md-6">
                            <label for="enrollment_date" class="form-label fw-semibold">Enrollment Date <span class="text-danger">*</span></label>
                            <input type="date" name="enrollment_date" id="enrollment_date" class="form-control @error('enrollment_date') is-invalid @enderror" value="{{ old('enrollment_date', date('Y-m-d')) }}" required>
                            @error('enrollment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Description / Notes -->
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold">Student Notes / Description</label>
                        <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" placeholder="Add academic background, extracurricular interests, or special remarks...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('students.index') }}" class="btn btn-light border px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary-custom px-4">
                            <i class="bi bi-save me-1"></i> Save Student Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
