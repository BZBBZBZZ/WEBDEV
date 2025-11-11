@extends('layout.mainlayout')

@section('title', 'Edit Employee')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning">
                        <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Edit Employee: {{ $employee->name }}</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.employees.update', $employee) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-user me-2"></i>Employee Name
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $employee->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="position" class="form-label fw-semibold">
                                    <i class="fas fa-briefcase me-2"></i>Position
                                </label>
                                <input type="text" class="form-control @error('position') is-invalid @enderror"
                                    id="position" name="position" value="{{ old('position', $employee->position) }}" required>
                                @error('position')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label fw-semibold">
                                    <i class="fas fa-image me-2"></i>Employee Photo
                                </label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave empty to keep current photo</small>

                                <div class="mt-2">
                                    <label class="form-label">Current Photo:</label>
                                    <div>
                                        <img src="{{ $employee->image }}" alt="{{ $employee->name }}"
                                            class="img-thumbnail rounded-circle" style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-2"></i>Update Employee
                                </button>
                                <a href="{{ route('admin.employees.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection