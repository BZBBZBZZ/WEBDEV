@extends('layout.mainlayout')

@section('title', 'Promo Details')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0"><i class="fas fa-tag me-2"></i>Promo Details</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">ID:</div>
                            <div class="col-md-8">{{ $promo->id }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Name:</div>
                            <div class="col-md-8">{{ $promo->name }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Discount:</div>
                            <div class="col-md-8">
                                <span class="badge bg-danger fs-6">{{ $promo->discount_percentage }}% OFF</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Start Date:</div>
                            <div class="col-md-8">{{ $promo->start_date->format('d M Y') }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">End Date:</div>
                            <div class="col-md-8">{{ $promo->end_date->format('d M Y') }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Status:</div>
                            <div class="col-md-8">
                                @if($promo->isActive())
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Products:</div>
                            <div class="col-md-8">
                                <span class="badge bg-info">{{ $promo->products->count() }} products</span>
                            </div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">
                            <i class="fas fa-box me-2"></i>Products with this promo:
                        </h5>

                        @if ($promo->products->count() > 0)
                            <div class="row g-3">
                                @foreach ($promo->products as $product)
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ $product->name }}</h6>
                                                <p class="card-text small text-muted mb-2">{{ $product->category->name }}</p>
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="text-decoration-line-through text-muted">
                                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                                    </span>
                                                    <span class="text-success fw-bold">
                                                        Rp {{ number_format($product->getDiscountedPrice(), 0, ',', '.') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                No products assigned to this promo yet.
                            </div>
                        @endif

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.promos.edit', $promo) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit Promo
                            </a>
                            <a href="{{ route('admin.promos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to List
                            </a>
                            <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Delete Promo
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
