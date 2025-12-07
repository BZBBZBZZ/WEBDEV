@extends('layout.mainlayout')

@section('title', 'Transaction Detail')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-file-invoice me-2"></i>Transaction #{{ $transaction->id }}</h2>
            <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                {{-- Transaction Info --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Transaction Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Order ID</small>
                                <p class="mb-0 fw-bold">{{ $transaction->transaction_code }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Customer</small>
                                <p class="mb-0">{{ $transaction->customer_name }}</p>
                                <small class="text-muted">{{ $transaction->customer_phone }}</small>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Order Date</small>
                                <p class="mb-0">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Status</small>
                                <p class="mb-0">
                                    @if($transaction->status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif($transaction->status === 'processing')
                                        <span class="badge bg-info text-dark">Processing</span>
                                    @elseif($transaction->status === 'shipped')
                                        <span class="badge bg-primary">Shipped</span>
                                    @elseif($transaction->status === 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <span class="badge bg-danger">{{ ucfirst($transaction->status) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Products --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-box me-2"></i>Products</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaction->details as $detail)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $detail->product->image }}" alt="{{ $detail->product->name }}" 
                                                         class="rounded me-2" style="width: 50px; height: 50px; object-fit: cover;">
                                                    <div>
                                                        <p class="mb-0 fw-bold">{{ $detail->product->name }}</p>
                                                        <small class="text-muted">{{ $detail->product->category->name }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                            <td>{{ $detail->quantity }}</td>
                                            <td class="fw-bold">Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Shipping Info --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-shipping-fast me-2"></i>Shipping Information</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>Address:</strong> {{ $transaction->customer_address }}</p>
                        <p class="mb-2"><strong>Phone:</strong> {{ $transaction->customer_phone }}</p>
                        <p class="mb-0"><strong>Courier:</strong> {{ strtoupper($transaction->courier_code) }} - {{ $transaction->courier_service }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                {{-- Update Status --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Update Status</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.transactions.update-status', $transaction) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Transaction Status</label>
                                <select name="status" class="form-select" required>
                                    <option value="pending" {{ $transaction->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $transaction->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $transaction->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="completed" {{ $transaction->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $transaction->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-save me-2"></i>Update Status
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Order Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <strong>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <strong>Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong class="text-success">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong>
                        </div>

                        <div class="border-top pt-3">
                            <p class="mb-2">
                                <strong>Payment Status:</strong>
                                <span class="badge bg-{{ $transaction->payment_status === 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($transaction->payment_status) }}
                                </span>
                            </p>
                            @if($transaction->payment_type)
                                <p class="mb-2"><strong>Method:</strong> {{ ucfirst(str_replace('_', ' ', $transaction->payment_type)) }}</p>
                            @endif
                            @if($transaction->paid_at)
                                <p class="mb-0"><strong>Paid at:</strong> {{ $transaction->paid_at->format('d M Y, H:i') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
