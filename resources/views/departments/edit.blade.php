@extends('layouts.app')

@section('title', 'Edit Department #' . $department->dept_id)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1">
                        <li class="breadcrumb-item"><a href="{{ route('departments.index') }}" class="text-decoration-none">Departments</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('departments.show', $department) }}" class="text-decoration-none">#{{ $department->dept_id }}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <h3 class="fw-bold mb-0">Edit Department: {{ $department->dept_name }}</h3>
            </div>
            <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card card-custom">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                    <i class="bi bi-pencil-square text-primary"></i> Update Department Information
                </h5>
                <span class="badge bg-light text-muted border">Dept ID #{{ $department->dept_id }}</span>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('departments.update', $department) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Department Name -->
                    <div class="mb-3">
                        <label for="dept_name" class="form-label fw-semibold">Department Name <span class="text-danger">*</span></label>
                        <input type="text" name="dept_name" id="dept_name" class="form-control @error('dept_name') is-invalid @enderror" value="{{ old('dept_name', $department->dept_name) }}" required>
                        @error('dept_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Manager ID -->
                    <div class="mb-3">
                        <label for="manager_id" class="form-label fw-semibold">Manager / Head ID</label>
                        <input type="text" name="manager_id" id="manager_id" class="form-control @error('manager_id') is-invalid @enderror" value="{{ old('manager_id', $department->manager_id) }}">
                        @error('manager_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Location ID -->
                    <div class="mb-4">
                        <label for="location_id" class="form-label fw-semibold">Location / Office / Building</label>
                        <input type="text" name="location_id" id="location_id" class="form-control @error('location_id') is-invalid @enderror" value="{{ old('location_id', $department->location_id) }}">
                        @error('location_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center border-top pt-3">
                        <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteDeptModal">
                            <i class="bi bi-trash me-1"></i> Delete Department
                        </button>

                        <div class="d-flex gap-2">
                            <a href="{{ route('departments.index') }}" class="btn btn-light border px-4">Cancel</a>
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
<div class="modal fade" id="deleteDeptModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Department Deletion</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="mb-2">Are you sure you want to permanently delete this department?</p>
                <div class="alert alert-light border fw-bold text-dark">
                    #{{ $department->dept_id }} - {{ $department->dept_name }}
                </div>
                <small class="text-danger">All enrolled students in this department will also be affected.</small>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="{{ route('departments.destroy', $department) }}" method="POST" class="d-inline m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete Department</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
