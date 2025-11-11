@extends('layout.mainlayout')

@section('title', 'Product Details')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0"><i class="fas fa-box me-2"></i>Product Details</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="img-fluid rounded"
                                style="max-height: 300px;">
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">ID:</div>
                            <div class="col-md-8">{{ $product->id }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Name:</div>
                            <div class="col-md-8">{{ $product->name }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Category:</div>
                            <div class="col-md-8">
                                <span class="badge bg-primary">{{ $product->category->name }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Short Description:</div>
                            <div class="col-md-8">{{ $product->short_description }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Long Description:</div>
                            <div class="col-md-8">{{ $product->long_description }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Price:</div>
                            <div class="col-md-8">
                                <span class="h5 text-success">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Created:</div>
                            <div class="col-md-8">{{ $product->created_at->format('d M Y H:i') }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Last Updated:</div>
                            <div class="col-md-8">{{ $product->updated_at->format('d M Y H:i') }}</div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit Product
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to List
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Delete Product
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
