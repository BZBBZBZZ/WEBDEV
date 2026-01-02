@extends('layout.mainlayout')

@section('title', 'Home')

@section('content')
    <div class="container py-5">
        <div class="row mb-5">
            <div class="col-12 text-center">
                <h1 class="display-4 fw-bold text-primary">
                    <i class="fas fa-birthday-cake me-3"></i>Welcome to Fiori Bakery & Patisery
                </h1>
                <p class="lead text-muted">Fresh baked goods made daily with love and the finest ingredients</p>
            </div>
        </div>

        <div class="mb-4 text-center">
            <h2 class="h3 fw-bold">Our Top Products</h2>
        </div>

        <div class="row g-4">
            @foreach ($featuredProducts as $product)
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
                                        <small class="badge bg-danger me-1 mb-1">{{ $promo->name }}</small>
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
                                        <span class="h5 mb-0 text-success fw-bold">
                                            Rp {{ number_format($product->getDiscountedPrice(), 0, ',', '.') }}
                                        </span>
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
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="/products" class="btn btn-primary btn-lg">
                <i class="fas fa-shopping-bag me-2"></i>View All Products
            </a>
        </div>
    </div>
@endsection