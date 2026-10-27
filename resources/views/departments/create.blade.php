@extends('layouts.app')

@section('title', 'Add Department')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('departments.index') }}" class="text-decoration-none">Departments</a></li>
                        <li class="breadcrumb-item active" aria-current="page">New Department</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0">Create Academic Department</h3>
            </div>
            <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card card-custom">
            <div class="card-header bg-white py-3 border-bottom">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-building-add text-primary"></i> Department Details (Primary Table)
                </h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('departments.store') }}" method="POST">
                    @csrf

                    <!-- Department Name -->
                    <div class="mb-3">
                        <label for="dept_name" class="form-label fw-semibold">Department Name <span class="text-danger">*</span></label>
                        <input type="text" name="dept_name" id="dept_name" class="form-control @error('dept_name') is-invalid @enderror" value="{{ old('dept_name') }}" placeholder="e.g. Faculty of Computer Science & Cybersecurity" required autofocus>
                        @error('dept_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Manager ID -->
                    <div class="mb-3">
                        <label for="manager_id" class="form-label fw-semibold">Manager / Head ID</label>
                        <input type="text" name="manager_id" id="manager_id" class="form-control @error('manager_id') is-invalid @enderror" value="{{ old('manager_id') }}" placeholder="e.g. MGR-CS-101 or Dr. Alan Turing">
                        @error('manager_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text small">Identifier or code for the department director/manager.</div>
                    </div>

                    <!-- Location ID -->
                    <div class="mb-4">
                        <label for="location_id" class="form-label fw-semibold">Location / Office / Building</label>
                        <input type="text" name="location_id" id="location_id" class="form-control @error('location_id') is-invalid @enderror" value="{{ old('location_id') }}" placeholder="e.g. Building A, Floor 3 (Room 302)">
                        @error('location_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text small">Physical location or facility code on campus.</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('departments.index') }}" class="btn btn-light border px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary-custom px-4">
                            <i class="bi bi-save me-1"></i> Save Department
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
