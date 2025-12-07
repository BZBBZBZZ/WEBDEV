@extends('layout.mainlayout')

@section('title', 'My Transactions')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4"><i class="fas fa-receipt me-2"></i>My Transactions</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($transactions->count() > 0)
            <div class="row">
                @foreach($transactions as $transaction)
                    <div class="col-12 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <small class="text-muted">Order ID</small>
                                        <p class="mb-1 fw-bold">{{ $transaction->transaction_code }}</p>
                                        <small class="text-muted">{{ $transaction->created_at->format('d M Y, H:i') }}</small>
                                    </div>
                                    <div class="col-md-3">
                                        <small class="text-muted">Items</small>
                                        <p class="mb-0">{{ $transaction->details->count() }} product(s)</p>
                                    </div>
                                    <div class="col-md-2">
                                        <small class="text-muted">Total</small>
                                        <p class="mb-0 fw-bold text-success">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="col-md-2">
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

                                        <br>
                                        <small class="badge {{ $transaction->payment_status === 'paid' ? 'bg-success' : 'bg-secondary' }} mt-1">
                                            {{ ucfirst($transaction->payment_status) }}
                                        </small>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye me-1"></i>Details
                                        </a>
                                        @if($transaction->payment_status === 'pending')
                                            <a href="{{ route('payment.show', $transaction) }}" class="btn btn-sm btn-success mt-1">
                                                <i class="fas fa-credit-card me-1"></i>Pay
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $transactions->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-receipt fa-5x text-muted mb-4"></i>
                <h4 class="mb-3">No transactions yet</h4>
                <p class="text-muted mb-4">Start shopping and your orders will appear here!</p>
                <a href="/products" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag me-2"></i>Browse Products
                </a>
            </div>
        @endif
    </div>
@endsection
