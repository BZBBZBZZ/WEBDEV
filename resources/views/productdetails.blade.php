@extends('layout.mainlayout')

@section('title', $product->name)

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="position-relative">
                    @if($product->hasActivePromo())
                        <div class="position-absolute top-0 end-0 m-3 z-1">
                            <span class="badge bg-danger fs-4 shadow-lg">
                                <i class="fas fa-fire me-1"></i>{{ $product->getTotalDiscount() }}% OFF
                            </span>
                        </div>
                    @endif
                    <img src="{{ $product->image }}" class="img-fluid rounded shadow-lg" alt="{{ $product->name }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="ps-md-4">
                    <span class="badge bg-primary mb-3 fs-6">{{ $product->category->name }}</span>
                    
                    <h1 class="display-6 fw-bold mb-3">{{ $product->name }}</h1>
                    
                    @if($product->hasActivePromo())
                        <div class="alert alert-danger border-0 shadow-sm mb-4">
                            <h6 class="mb-2">
                                <i class="fas fa-tags me-2"></i>Active Promotions:
                            </h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($product->activePromos() as $promo)
                                    <div class="badge bg-white text-danger border border-danger fs-6">
                                        <i class="fas fa-tag me-1"></i>{{ $promo->name }} - {{ $promo->discount_percentage }}% OFF
                                    </div>
                                @endforeach
                            </div>
                            @if($product->activePromos()->count() > 1)
                                <small class="d-block mt-2 text-danger">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Multiple promos stacked! Total discount: <strong>{{ $product->getTotalDiscount() }}%</strong>
                                </small>
                            @endif
                        </div>
                        
                        <div class="mb-4">
                            <div class="mb-2">
                                <span class="text-muted text-decoration-line-through h5">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                <h2 class="text-success mb-0">
                                    Rp {{ number_format($product->getDiscountedPrice(), 0, ',', '.') }}
                                </h2>
                                <span class="badge bg-success fs-6">
                                    <i class="fas fa-piggy-bank me-1"></i>
                                    Save Rp {{ number_format($product->price - $product->getDiscountedPrice(), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    @else
                        <h2 class="text-success mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
                    @endif

                    @if($product->weight)
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">
                                <i class="fas fa-weight me-2"></i>Product Weight
                            </h6>
                            <span class="fs-5">{{ $product->weight }}g</span>
                        </div>
                    @endif

                    <div class="mb-4">
                        <h5 class="mb-3">
                            <i class="fas fa-align-left me-2"></i>Description
                        </h5>
                        <p class="text-muted">{{ $product->short_description }}</p>
                    </div>

                    <div class="mb-4">
                        <h5 class="mb-3">
                            <i class="fas fa-info-circle me-2"></i>Details
                        </h5>
                        <p class="text-muted">{{ $product->long_description }}</p>
                    </div>

                    <div class="border-top pt-4 mt-4">
                        <a href="/products" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Back to Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection