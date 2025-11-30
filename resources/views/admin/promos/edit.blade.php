@extends('layout.mainlayout')

@section('title', 'Edit Promo')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning">
                        <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Promo: {{ $promo->name }}</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.promos.update', $promo) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-tag me-2"></i>Promo Name
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $promo->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="discount_percentage" class="form-label fw-semibold">
                                    <i class="fas fa-percent me-2"></i>Discount Percentage (1-100%)
                                </label>
                                <input type="number" class="form-control @error('discount_percentage') is-invalid @enderror"
                                    id="discount_percentage" name="discount_percentage" 
                                    value="{{ old('discount_percentage', $promo->discount_percentage) }}" min="1" max="100" required>
                                @error('discount_percentage')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="start_date" class="form-label fw-semibold">
                                        <i class="fas fa-calendar-alt me-2"></i>Start Date
                                    </label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                        id="start_date" name="start_date" 
                                        value="{{ old('start_date', $promo->start_date->format('Y-m-d')) }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="end_date" class="form-label fw-semibold">
                                        <i class="fas fa-calendar-check me-2"></i>End Date
                                    </label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                        id="end_date" name="end_date" 
                                        value="{{ old('end_date', $promo->end_date->format('Y-m-d')) }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="fas fa-box me-2"></i>Select Products
                                </label>
                                <div class="border rounded p-3" style="max-height: 300px; overflow-y: auto;">
                                    @foreach($products as $product)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="products[]" 
                                                value="{{ $product->id }}" id="product{{ $product->id }}"
                                                {{ $promo->products->contains($product->id) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="product{{ $product->id }}">
                                                {{ $product->name }} 
                                                <small class="text-muted">({{ $product->category->name }})</small>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-2"></i>Update Promo
                                </button>
                                <a href="{{ route('admin.promos.index') }}" class="btn btn-secondary">
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
