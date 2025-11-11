@extends('layout.mainlayout')

@section('title', 'Manage Employees')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="fas fa-users me-2 text-primary"></i>Manage Employees</h2>
                <p class="text-muted">Total Employees: {{ $employees->total() }}</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.employees.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Employee
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Joined</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($employees as $employee)
                                <tr>
                                    <td>{{ $employee->id }}</td>
                                    <td>
                                        <img src="{{ $employee->image }}" alt="{{ $employee->name }}" class="rounded-circle"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <strong>{{ $employee->name }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary">{{ $employee->position }}</span>
                                    </td>
                                    <td>{{ $employee->created_at->format('d M Y') }}</td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.employees.show', $employee) }}" class="btn btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this employee?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-users fa-3x mb-3 d-block"></i>
                                        No employees found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $employees->links() }}
        </div>
    </div>
@endsection