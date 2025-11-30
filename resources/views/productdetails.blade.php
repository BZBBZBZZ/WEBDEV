@extends('layout.mainlayout')

@section('title', $product->name)

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <div class="position-relative">
                    <img src="{{ $product->image }}" class="img-fluid rounded shadow" alt="{{ $product->name }}">
                    @if($product->activePromo())
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-danger fs-5">
                                <i class="fas fa-tag me-1"></i>{{ $product->activePromo()->discount_percentage }}% OFF
                            </span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="ps-md-4">
                    <span class="badge bg-primary mb-2">{{ $product->category->name }}</span>
                    @if($product->activePromo())
                        <span class="badge bg-success mb-2 ms-2">
                            <i class="fas fa-tags me-1"></i>{{ $product->activePromo()->name }}
                        </span>
                    @endif
                    <h1 class="display-6 fw-bold mt-2">{{ $product->name }}</h1>
                    
                    @if($product->activePromo())
                        <div class="mb-4">
                            <span class="text-decoration-line-through text-muted h5">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </span>
                            <h3 class="text-success mt-2">Rp {{ number_format($product->getDiscountedPrice(), 0, ',', '.') }}</h3>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                Promo valid until {{ $product->activePromo()->end_date->format('d M Y') }}
                            </small>
                        </div>
                    @else
                        <h3 class="text-success mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
                    @endif

                    @if($product->weight)
                        <div class="mb-3">
                            <strong><i class="fas fa-weight me-2"></i>Weight:</strong> 
                            <span class="text-muted">{{ number_format($product->weight, 0) }} grams</span>
                        </div>
                    @endif

                    <h5>Description:</h5>
                    <p class="text-muted mb-4">{{ $product->short_description }}</p>

                    <h5>Details:</h5>
                    <p class="mb-4">{{ $product->long_description }}</p>

                    <div class="mt-4">
                        <a href="/products" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
