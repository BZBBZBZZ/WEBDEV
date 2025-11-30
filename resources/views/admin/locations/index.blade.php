@extends('layout.mainlayout')

@section('title', 'Manage Locations')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="fas fa-map-marker-alt me-2 text-primary"></i>Manage Locations</h2>
                <p class="text-muted">Total Locations: {{ $locations->total() }}</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Location
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse($locations as $location)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $location->image }}" class="card-img-top" alt="{{ $location->name }}"
                            style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">
                                <i class="fas fa-map-marker-alt me-2 text-primary"></i>{{ $location->name }}
                            </h5>
                            <p class="card-text text-muted">{{ Str::limit($location->description, 100) }}</p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.locations.show', $location) }}" class="btn btn-info btn-sm flex-fill">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                                <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-warning btn-sm flex-fill">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <form action="{{ route('admin.locations.destroy', $location) }}" method="POST"
                                    class="flex-fill" onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-100">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-map-marker-alt fa-3x mb-3 d-block"></i>
                        <p>No locations found.</p>
                        <a href="{{ route('admin.locations.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add First Location
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $locations->links() }}
        </div>
    </div>
@endsection
