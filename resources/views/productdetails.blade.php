@extends('layout.mainlayout')

@section('title', $product->name)

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-6">
                <img src="{{ $product->image }}" class="img-fluid rounded shadow" alt="{{ $product->name }}">
            </div>

            <div class="col-md-6">
                <div class="ps-md-4">
                    <span class="badge bg-primary mb-3">{{ $product->category->name }}</span>
                    <h1 class="display-6 fw-bold">{{ $product->name }}</h1>
                    <h3 class="text-success mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>

                    <h5>Description:</h5>
                    <p class="text-muted mb-4">{{ $product->short_description }}</p>

                    <h5>Details:</h5>
                    <p class="mb-4">{{ $product->long_description }}</p>

                    <div class="mt-3">
                        <a href="/products" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Products
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
