@extends('layout.mainlayout')

@section('title', 'Shopping Cart')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4">
            <i class="fas fa-shopping-cart me-2"></i>Your Shopping Cart
        </h2>

        @if ($cartItems->count() > 0)
            @foreach ($cartItems as $item)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}"
                                    class="img-fluid rounded" style="width: 100%; max-height: 120px; object-fit: cover;">
                            </div>

                            <div class="col-md-4">
                                <h5 class="mb-1">{{ $item->product->name }}</h5>
                                <p class="text-muted mb-0">{{ $item->product->category->name }}</p>
                                @if ($item->product->weight)
                                    <small class="text-muted">Weight: {{ $item->product->weight }}g</small>
                                @endif
                            </div>

                            <div class="col-md-2">
                                <p class="mb-0 fw-bold text-success">
                                    Rp {{ number_format($item->product->getDiscountedPrice(), 0, ',', '.') }}
                                </p>
                                @if ($item->product->hasActivePromo())
                                    <small class="text-muted text-decoration-line-through">
                                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                    </small>
                                @endif
                            </div>

                            
                            <div class="col-md-2">
                                <p class="mb-0">Qty: <strong>{{ $item->quantity }}</strong></p>
                            </div>

                            <div class="col-md-1">
                                <p class="mb-0 fw-bold text-success">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="col-md-1 text-end">
                                <form action="{{ route('cart.destroy', $item) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Remove this item?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <form action="{{ route('cart.clear') }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger"
                                    onclick="return confirm('Clear all items?')">
                                    <i class="fas fa-trash-alt me-2"></i>Clear Cart
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4 text-end">
                            <h4 class="mb-3">
                                Total: <span class="text-success">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </h4>
                            <a href="{{ route('checkout.index') }}" class="btn btn-success btn-lg w-100">
                                <i class="fas fa-shopping-bag me-2"></i>Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-5x text-muted mb-4"></i>
                <h4 class="mb-3">Your cart is empty</h4>
                <p class="text-muted mb-4">Start adding products to your cart!</p>
                <a href="/products" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag me-2"></i>Browse Products
                </a>
            </div>
        @endif
    </div>
@endsection
