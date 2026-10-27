@extends('layouts.app')

@section('title', 'Departments Directory')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold mb-1 text-dark">Departments Directory</h2>
        <p class="text-muted mb-0">Primary academic faculties and administrative divisions.</p>
    </div>
    <div>
        <a href="{{ route('departments.create') }}" class="btn btn-primary-custom d-inline-flex align-items-center gap-2">
            <i class="bi bi-building-add"></i> Add New Department
        </a>
    </div>
</div>

<!-- Search Form -->
<div class="card card-custom mb-4">
    <div class="card-body p-3 p-md-4">
        <form action="{{ route('departments.index') }}" method="GET" class="row g-3 align-items-end">
            <div class="col-md-9">
                <label for="search" class="form-label small fw-bold text-secondary">SEARCH DEPARTMENT / MANAGER / LOCATION</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" id="search" class="form-control" placeholder="Search by name, manager ID, or location..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary-custom flex-grow-1">
                    <i class="bi bi-funnel-fill me-1"></i> Search
                </button>
                @if(request('search'))
                <a href="{{ route('departments.index') }}" class="btn btn-outline-secondary" title="Reset Search">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
                @endif
            </div>
        </form>
    </div>
</div>

<!-- Departments HTML Table -->
<div class="card card-custom overflow-hidden">
    <div class="table-responsive">
        <table class="table table-custom align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 80px;">Dept ID</th>
                    <th>Department Name</th>
                    <th>Manager ID</th>
                    <th>Location ID / Room</th>
                    <th>Students Enrolled</th>
                    <th>Created At</th>
                    <th class="text-end" style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $dept)
                <tr>
                    <td class="fw-bold text-muted">#{{ $dept->dept_id }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-3 bg-indigo-subtle text-indigo p-2 d-inline-flex align-items-center justify-content-center" style="width: 36px; height: 36px; background-color: #e0e7ff; color: #4338ca;">
                                <i class="bi bi-building"></i>
                            </div>
                            <div>
                                <a href="{{ route('departments.show', $dept) }}" class="fw-bold text-dark text-decoration-none">
                                    {{ $dept->dept_name }}
                                </a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <code>{{ $dept->manager_id ?? 'N/A' }}</code>
                    </td>
                    <td>
                        <span class="text-secondary small">
                            <i class="bi bi-geo-alt text-muted me-1"></i>{{ $dept->location_id ?? 'Main Campus' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('students.index', ['dept_id' => $dept->dept_id]) }}" class="text-decoration-none">
                            <span class="badge bg-primary-subtle text-primary fw-semibold px-2 py-1">
                                <i class="bi bi-people-fill me-1"></i>{{ $dept->students_count }} students
                            </span>
                        </a>
                    </td>
                    <td>
                        <span class="text-nowrap small text-muted">{{ $dept->created_at ? $dept->created_at->format('M d, Y') : '-' }}</span>
                    </td>
                    <td class="text-end">
                        <div class="btn-group btn-group-sm" role="group">
                            <a href="{{ route('departments.show', $dept) }}" class="btn btn-outline-primary" title="View Department & Students">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('departments.edit', $dept) }}" class="btn btn-outline-secondary" title="Edit Department">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-outline-danger" title="Delete Department" data-bs-toggle="modal" data-bs-target="#deleteDeptModal{{ $dept->dept_id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>

                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteDeptModal{{ $dept->dept_id }}" tabindex="-1" aria-hidden="true" style="text-align: left;">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Department Deletion</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body p-4">
                                        <p class="mb-2">Are you sure you want to delete this department?</p>
                                        <div class="alert alert-light border fw-bold text-dark">
                                            #{{ $dept->dept_id }} - {{ $dept->dept_name }}
                                        </div>
                                        @if($dept->students_count > 0)
                                        <div class="alert alert-warning py-2 small d-flex align-items-center gap-2">
                                            <i class="bi bi-exclamation-circle-fill"></i>
                                            <div><strong>Warning:</strong> This department has <strong>{{ $dept->students_count }}</strong> associated student record(s) which will also be deleted due to cascade constraints.</div>
                                        </div>
                                        @endif
                                        <small class="text-danger">This action cannot be undone.</small>
                                    </div>
                                    <div class="modal-footer bg-light">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="{{ route('departments.destroy', $dept) }}" method="POST" class="d-inline m-0">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Yes, Delete Department</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5">
                        <div class="text-muted">
                            <i class="bi bi-building-slash fs-1 d-block mb-2"></i>
                            <h5>No departments found</h5>
                            <p class="small mb-3">Add a new academic department to get started.</p>
                            <a href="{{ route('departments.create') }}" class="btn btn-sm btn-primary-custom">
                                <i class="bi bi-building-add me-1"></i> Add Department
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($departments->hasPages())
    <div class="card-footer bg-white border-top py-3">
        <div class="d-flex justify-content-between align-items-center">
            <div class="small text-muted">
                Showing {{ $departments->firstItem() ?? 0 }} to {{ $departments->lastItem() ?? 0 }} of {{ $departments->total() }} departments
            </div>
            <div>
                {{ $departments->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
