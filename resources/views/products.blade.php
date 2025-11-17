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
            <div class="row mb-4">
                <div class="col-12">
                    <p class="text-muted">
                        Showing results for "<strong>{{ request('search') }}</strong>"
                        ({{ $products->total() }} {{ $products->total() == 1 ? 'product' : 'products' }} found)
                    </p>
                </div>
            </div>
        @endif

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}"
                            style="height: 250px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <span class="badge bg-primary mb-2 align-self-start">{{ $product->category->name }}</span>
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text flex-grow-1">{{ $product->short_description }}</p>
                            <div class="d-flex justify-content-between align-items-center mt-auto">
                                <span class="h5 mb-0 text-success">Rp
                                    {{ number_format($product->price, 0, ',', '.') }}</span>
                                <a href="/products/{{ $product->id }}" class="btn btn-primary">
                                    <i class="fas fa-eye me-1"></i>Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                        <h3>No products found</h3>
                        @if(request('search'))
                            <p class="text-muted">Try searching with different keywords.</p>
                        @else
                            <p class="text-muted">Please check back later.</p>
                        @endif
                    </div>
                </div>
            @endforelse
        </div>

        @if($products->hasPages())
            <div class="row mt-5">
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
