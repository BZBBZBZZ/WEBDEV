@extends('layout.mainlayout')

@section('title', 'Location Details')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Location Details</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <img src="{{ $location->image }}" alt="{{ $location->name }}" 
                                class="img-fluid rounded" style="max-height: 400px;">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 fw-semibold">ID:</div>
                            <div class="col-md-9">{{ $location->id }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 fw-semibold">Name:</div>
                            <div class="col-md-9">{{ $location->name }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 fw-semibold">Description:</div>
                            <div class="col-md-9">{{ $location->description }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 fw-semibold">Created:</div>
                            <div class="col-md-9">{{ $location->created_at->format('d M Y H:i') }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-3 fw-semibold">Updated:</div>
                            <div class="col-md-9">{{ $location->updated_at->format('d M Y H:i') }}</div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.locations.edit', $location) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit Location
                            </a>
                            <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to List
                            </a>
                            <form action="{{ route('admin.locations.destroy', $location) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Delete Location
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
