@extends('librarian.layouts.app')

@section('title', 'Manage Students')

@section('content')
<div class="container-fluid px-0">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1"><i class="fa-solid fa-user-graduate text-primary me-2"></i>Manage Students</h4>
            <p class="text-muted small mb-0">View student profiles, search records, and register new student accounts.</p>
        </div>
        <button type="button" class="btn btn-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#addStudentModal">
            <i class="fa-solid fa-user-plus me-2"></i>Add New Student
        </button>
    </div>

    <!-- Filter & Search Section -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body">
            <form action="{{ route('librarian.students.index') }}" method="GET" class="row g-3">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Search by name, email, or phone..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark w-100 fw-semibold">Search</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Students List Table -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
            <h6 class="fw-bold mb-0 text-dark"><i class="fa-solid fa-users me-2 text-primary"></i>Registered Students</h6>
            <span class="badge bg-primary rounded-pill px-3 py-2">{{ $students->total() }} Total</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="ps-4">Student Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Registered Date</th>
                            <th scope="col" class="pe-4 text-end">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-semibold text-dark">{{ $student->name }}</div>
                                </td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->phone ?? 'N/A' }}</td>
                                <td>{{ $student->created_at ? $student->created_at->format('M d, Y') : 'N/A' }}</td>
                                <td class="pe-4 text-end">
                                    @if(($student->status ?? 'active') === 'active')
                                        <span class="badge bg-success px-2 py-1">Active</span>
                                    @else
                                        <span class="badge bg-secondary px-2 py-1">{{ ucfirst($student->status ?? 'Inactive') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="fa-solid fa-user-slash fa-2x mb-2 d-block text-secondary"></i>
                                    No student records found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($students->hasPages())
            <div class="card-footer bg-white py-3 border-top-0">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Add New Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw-bold" id="addStudentModalLabel"><i class="fa-solid fa-user-plus text-primary me-2"></i>Add New Student</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('librarian.students.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold small">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required placeholder="John Doe">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold small">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" required placeholder="student@example.com">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label fw-semibold small">Phone Number</label>
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="+92 300 1234567">
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light fw-semibold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary fw-semibold"><i class="fa-solid fa-save me-1"></i>Save Student</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection