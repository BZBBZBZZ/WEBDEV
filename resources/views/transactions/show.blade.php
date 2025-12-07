@extends('layout.mainlayout')

@section('title', 'Transaction Detail')

@section('content')
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-file-invoice me-2"></i>Transaction Detail</h2>
            <a href="{{ route('transactions.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Back
            </a>
        </div>

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
                            <div class="col-md-6 mb-3">
                                <small class="text-muted">Payment Status</small>
                                <p class="mb-0">
                                    @if($transaction->payment_status === 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif($transaction->payment_status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-danger">{{ ucfirst($transaction->payment_status) }}</span>
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
                        @foreach($transaction->details as $detail)
                            <div class="row align-items-center mb-3 pb-3 border-bottom">
                                <div class="col-md-2">
                                    <img src="{{ $detail->product->image }}" class="img-fluid rounded" alt="{{ $detail->product->name }}">
                                </div>
                                <div class="col-md-6">
                                    <h6 class="mb-1">{{ $detail->product->name }}</h6>
                                    <p class="text-muted mb-0 small">{{ $detail->product->category->name }}</p>
                                </div>
                                <div class="col-md-2 text-center">
                                    <p class="mb-0">Qty: <strong>{{ $detail->quantity }}</strong></p>
                                </div>
                                <div class="col-md-2 text-end">
                                    <p class="mb-0 fw-bold text-success">
                                        Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}
                                    </p>
                                    <small class="text-muted">@ Rp {{ number_format($detail->price, 0, ',', '.') }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Shipping Address --}}
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Shipping Address</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2">{{ $transaction->customer_address }}</p>
                        <p class="mb-2"><strong>Phone:</strong> {{ $transaction->customer_phone }}</p>
                        <p class="mb-0"><strong>Courier:</strong> {{ strtoupper($transaction->courier_code) }} - {{ $transaction->courier_service }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                {{-- Payment Summary --}}
                <div class="card shadow-sm sticky-top" style="top: 20px;">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Payment Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping:</span>
                            <span>Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total:</strong>
                            <strong class="text-success">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong>
                        </div>

                        @if($transaction->payment_status === 'pending')
                            <a href="{{ route('payment.show', $transaction) }}" class="btn btn-success w-100">
                                <i class="fas fa-credit-card me-2"></i>Complete Payment
                            </a>
                        @endif

                        @if($transaction->paid_at)
                            <div class="mt-3 pt-3 border-top">
                                <small class="text-muted">Payment Time</small>
                                <p class="mb-0">{{ $transaction->paid_at->format('d M Y, H:i') }}</p>
                            </div>
                        @endif

                        @if($transaction->payment_type)
                            <div class="mt-2">
                                <small class="text-muted">Payment Method</small>
                                <p class="mb-0 text-capitalize">{{ str_replace('_', ' ', $transaction->payment_type) }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
