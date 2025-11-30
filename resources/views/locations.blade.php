@extends('layout.mainlayout')

@section('title', 'Our Locations')

@section('content')
    <div class="container py-5">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold">
                <i class="fas fa-map-marker-alt me-3 text-primary"></i>Our Locations
            </h1>
            <p class="lead text-muted">Explore our beautiful store interiors</p>
        </div>

        @if ($locations->count() > 0)
            <div class="row g-4">
                @foreach ($locations as $location)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm hover-card">
                            <img src="{{ $location->image }}" class="card-img-top" alt="{{ $location->name }}"
                                style="height: 250px; object-fit: cover;">
                            <div class="card-body">
                                <h4 class="card-title mb-3">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>{{ $location->name }}
                                </h4>
                                <p class="card-text text-muted">{{ $location->description }}</p>
                            </div>
                            <div class="card-footer bg-transparent">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-2"></i>Updated {{ $location->updated_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                <p class="text-muted">No locations available at the moment.</p>
            </div>
        @endif
    </div>

    <style>
        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection
