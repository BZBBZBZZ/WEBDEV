@extends('layout.mainlayout')

@section('title', 'Category Details')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0"><i class="fas fa-list me-2"></i>Category Details</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">ID:</div>
                            <div class="col-md-8">{{ $category->id }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Name:</div>
                            <div class="col-md-8">
                                <span class="badge bg-success fs-6">{{ $category->name }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Products Count:</div>
                            <div class="col-md-8">
                                <span class="badge bg-info">{{ $category->products_count }} products</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Created:</div>
                            <div class="col-md-8">{{ $category->created_at->format('d M Y H:i') }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Last Updated:</div>
                            <div class="col-md-8">{{ $category->updated_at->format('d M Y H:i') }}</div>
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">
                            <i class="fas fa-box me-2"></i>Products in this category:
                        </h5>

                        @if ($category->products->count() > 0)
                            <div class="row g-3">
                                @foreach ($category->products as $product)
                                    <div class="col-md-4">
                                        <div class="card">
                                            <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}"
                                                style="height: 150px; object-fit: cover;">
                                            <div class="card-body">
                                                <h6 class="card-title">{{ Str::limit($product->name, 20) }}</h6>
                                                <p class="card-text text-success fw-bold">
                                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                No products in this category yet.
                            </div>
                        @endif

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning">
                                    <i class="fas fa-edit me-2"></i>Edit Category
                                </a>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to List
                                </a>
                                @if ($category->products_count == 0)
                                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-2"></i>Delete Category
                                        </button>
                                    </form>
                                @endif
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
