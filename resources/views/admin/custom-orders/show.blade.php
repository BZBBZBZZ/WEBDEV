@extends('layout.mainlayout')

@section('title', 'Custom Order Details')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0"><i class="fas fa-clipboard-list me-2"></i>Custom Order Details</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Order ID:</div>
                            <div class="col-md-8">{{ $customOrder->id }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Customer Name:</div>
                            <div class="col-md-8">{{ $customOrder->customer_name }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Order Name:</div>
                            <div class="col-md-8">{{ $customOrder->order_name }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Description:</div>
                            <div class="col-md-8">{{ $customOrder->description }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Status:</div>
                            <div class="col-md-8">
                                <span class="badge {{ $customOrder->getStatusBadgeClass() }} fs-6">
                                    {{ $customOrder->getStatusLabel() }}
                                </span>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Created:</div>
                            <div class="col-md-8">{{ $customOrder->created_at->format('d M Y H:i') }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Last Updated:</div>
                            <div class="col-md-8">{{ $customOrder->updated_at->format('d M Y H:i') }}</div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.custom-orders.edit', $customOrder) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit Order
                            </a>
                            <a href="{{ route('admin.custom-orders.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to List
                            </a>
                            <form action="{{ route('admin.custom-orders.destroy', $customOrder) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-2"></i>Delete Order
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
