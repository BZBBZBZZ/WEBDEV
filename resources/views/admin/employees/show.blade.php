@extends('layout.mainlayout')

@section('title', 'Employee Details')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0"><i class="fas fa-user me-2"></i>Employee Details</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <img src="{{ $employee->image }}" alt="{{ $employee->name }}"
                                class="img-fluid rounded-circle shadow"
                                style="width: 200px; height: 200px; object-fit: cover;">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">ID:</div>
                            <div class="col-md-8">{{ $employee->id }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Name:</div>
                            <div class="col-md-8">{{ $employee->name }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Position:</div>
                            <div class="col-md-8">
                                <span class="badge bg-primary">{{ $employee->position }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Joined:</div>
                            <div class="col-md-8">{{ $employee->created_at->format('d M Y H:i') }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Last Updated:</div>
                            <div class="col-md-8">{{ $employee->updated_at->format('d M Y H:i') }}</div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.employees.edit', $employee) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit Employee
                            </a>
                            <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to List
                            </a>
                            <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this employee?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Delete Employee
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
