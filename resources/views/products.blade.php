@extends('layout.mainlayout')

@section('title', 'Products')

@section('content')
    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="display-5 fw-bold">This is Our Products</h1>
                <p class="text-muted">Freshly baked with love every day</p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-8 mx-auto">
                <form action="/products" method="GET">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control" name="search" placeholder="Search products, categories..."
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if(request('search'))
            <div class="row mb-3">
                <div class="col-12">
                    <p class="text-muted">
                        Search results for: <strong>"{{ request('search') }}"</strong>
                        ({{ $products->total() }} {{ Str::plural('product', $products->total()) }} found)
                    </p>
                </div>
            </div>
        @endif

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm position-relative">
                        @if($product->hasActivePromo())
                            <div class="position-absolute top-0 end-0 m-2 z-1">
                                <span class="badge bg-danger fs-6 shadow">
                                    <i class="fas fa-fire me-1"></i>{{ $product->getTotalDiscount() }}% OFF
                                </span>
                            </div>
                        @endif
                        
                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}"
                            style="height: 250px; object-fit: cover;">
                        
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-primary mb-2 align-self-start">{{ $product->category->name }}</span>
                            
                            @if($product->hasActivePromo())
                                <div class="mb-2">
                                    @foreach($product->activePromos() as $promo)
                                        <span class="badge bg-danger me-1 mb-1">
                                            <i class="fas fa-tag me-1"></i>{{ $promo->name }} ({{ $promo->discount_percentage }}%)
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                            
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted flex-grow-1">{{ $product->short_description }}</p>
                            
                            <div class="mt-auto">
                                @if($product->hasActivePromo())
                                    <div class="mb-2">
                                        <small class="text-muted text-decoration-line-through">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </small>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="h5 mb-0 text-success fw-bold">
                                                Rp {{ number_format($product->getDiscountedPrice(), 0, ',', '.') }}
                                            </span>
                                            <br>
                                            <small class="text-success">
                                                <i class="fas fa-piggy-bank me-1"></i>Save Rp {{ number_format($product->price - $product->getDiscountedPrice(), 0, ',', '.') }}
                                            </small>
                                        </div>
                                        <a href="/products/{{ $product->id }}" class="btn btn-primary">
                                            <i class="fas fa-eye me-1"></i>Details
                                        </a>
                                    </div>
                                @else
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 mb-0 text-success">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                        <a href="/products/{{ $product->id }}" class="btn btn-primary">
                                            <i class="fas fa-eye me-1"></i>Details
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No products found</h4>
                        @if(request('search'))
                            <p class="text-muted">Try searching with different keywords</p>
                            <a href="/products" class="btn btn-primary">
                                <i class="fas fa-redo me-2"></i>Show All Products
                            </a>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-5">
            {{ $products->links() }}
        </div>
    </div>
@endsection