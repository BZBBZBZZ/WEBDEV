@extends('layout.mainlayout')

@section('title', 'Edit Product')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning">
                        <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Product: {{ $product->name }}</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.products.update', $product) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-tag me-2"></i>Product Name
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $product->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label fw-semibold">
                                    <i class="fas fa-list me-2"></i>Category
                                </label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                                    name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="image" class="form-label fw-semibold">
                                    <i class="fas fa-image me-2"></i>Product Image
                                </label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Leave empty to keep current image</small>

                                <div class="mt-2">
                                    <label class="form-label">Current Image:</label>
                                    <div>
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                            class="img-thumbnail" style="max-width: 200px;">
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="short_description" class="form-label fw-semibold">
                                    <i class="fas fa-align-left me-2"></i>Short Description
                                </label>
                                <textarea class="form-control @error('short_description') is-invalid @enderror"
                                    id="short_description" name="short_description" rows="2" required>{{ old('short_description', $product->short_description) }}</textarea>
                                @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="long_description" class="form-label fw-semibold">
                                    <i class="fas fa-align-justify me-2"></i>Long Description
                                </label>
                                <textarea class="form-control @error('long_description') is-invalid @enderror"
                                    id="long_description" name="long_description" rows="4" required>{{ old('long_description', $product->long_description) }}</textarea>
                                @error('long_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="price" class="form-label fw-semibold">
                                    <i class="fas fa-dollar-sign me-2"></i>Price (Rp)
                                </label>
                                <input type="number" class="form-control @error('price') is-invalid @enderror"
                                    id="price" name="price" value="{{ old('price', $product->price) }}" required
                                    min="0" step="0.01">
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-2"></i>Update Product
                                </button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection