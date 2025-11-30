@extends('layout.mainlayout')

@section('title', 'Edit Custom Order')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning">
                        <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Custom Order: {{ $customOrder->order_name }}</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.custom-orders.update', $customOrder) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="customer_name" class="form-label fw-semibold">
                                    <i class="fas fa-user me-2"></i>Customer Name
                                </label>
                                <input type="text" class="form-control @error('customer_name') is-invalid @enderror"
                                    id="customer_name" name="customer_name" 
                                    value="{{ old('customer_name', $customOrder->customer_name) }}" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="order_name" class="form-label fw-semibold">
                                    <i class="fas fa-clipboard-list me-2"></i>Order Name
                                </label>
                                <input type="text" class="form-control @error('order_name') is-invalid @enderror"
                                    id="order_name" name="order_name" 
                                    value="{{ old('order_name', $customOrder->order_name) }}" required>
                                @error('order_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label fw-semibold">
                                    <i class="fas fa-align-left me-2"></i>Description
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    id="description" name="description" rows="5" required>{{ old('description', $customOrder->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="status" class="form-label fw-semibold">
                                    <i class="fas fa-tasks me-2"></i>Status
                                </label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                    <option value="not_made" {{ old('status', $customOrder->status) == 'not_made' ? 'selected' : '' }}>Not Made</option>
                                    <option value="in_progress" {{ old('status', $customOrder->status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="finished" {{ old('status', $customOrder->status) == 'finished' ? 'selected' : '' }}>Finished</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-2"></i>Update Order
                                </button>
                                <a href="{{ route('admin.custom-orders.index') }}" class="btn btn-secondary">
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
