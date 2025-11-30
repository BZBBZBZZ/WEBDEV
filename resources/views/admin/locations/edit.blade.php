@extends('layout.mainlayout')

@section('title', 'Edit Location')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning">
                        <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Location: {{ $location->name }}</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.locations.update', $location) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-map-marker-alt me-2"></i>Location Name
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $location->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">
                                    <i class="fas fa-align-left me-2"></i>Description
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    id="description" name="description" rows="5" required>{{ old('description', $location->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-image me-2"></i>Current Image
                                </label>
                                <div class="mb-2">
                                    <img src="{{ $location->image }}" alt="{{ $location->name }}" 
                                        class="img-thumbnail" style="max-width: 300px;">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="image" class="form-label fw-semibold">
                                    <i class="fas fa-image me-2"></i>New Image (optional)
                                </label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave empty to keep current image. Max size: 2MB</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-2"></i>Update Location
                                </button>
                                <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary">
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
