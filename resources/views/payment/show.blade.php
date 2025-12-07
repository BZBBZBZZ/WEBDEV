@extends('layout.mainlayout')

@section('title', 'Payment')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow">
                    <div class="card-header bg-success text-white text-center">
                        <h4 class="mb-0"><i class="fas fa-credit-card me-2"></i>Complete Your Payment</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h5>Transaction Code: <strong>{{ $transaction->transaction_code }}</strong></h5>
                            <p class="text-muted mb-0">Total Amount</p>
                            <h2 class="text-success fw-bold">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</h2>
                        </div>

                        <hr>

                        {{-- Order Details --}}
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3"><i class="fas fa-box me-2"></i>Order Details</h6>
                            @foreach($transaction->details as $detail)
                                <div class="d-flex justify-content-between mb-2">
                                    <span>{{ $detail->product_name }} x{{ $detail->quantity }}</span>
                                    <span>Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                            <div class="d-flex justify-content-between mb-2">
                                <span>Shipping ({{ strtoupper($transaction->courier_code) }} - {{ $transaction->courier_service }})</span>
                                <span>Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <hr>

                        {{-- Shipping Address --}}
                        <div class="mb-4">
                            <h6 class="fw-bold mb-2"><i class="fas fa-map-marker-alt me-2"></i>Shipping Address</h6>
                            <p class="mb-1">{{ $transaction->customer_address }}</p>
                            <p class="mb-0 text-muted">Phone: {{ $transaction->customer_phone }}</p>
                        </div>

                        <hr>

                        {{-- Payment Button --}}
                        <div class="text-center">
                            @if(isset($midtransError))
                                <div class="alert alert-danger mb-3">
                                    <i class="fas fa-exclamation-triangle me-2"></i>{{ $midtransError }}
                                </div>
                                <p class="text-muted">Please contact our customer service for manual payment:</p>
                                <p class="fw-bold">WhatsApp: 0813-2689-9898</p>
                                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                                    View My Orders
                                </a>
                            @elseif($transaction->payment_status === 'pending')
                                <button type="button" class="btn btn-success btn-lg px-5" id="payButton">
                                    <i class="fas fa-lock me-2"></i>Pay Now
                                </button>
                                <p class="text-muted mt-3 mb-0">
                                    <small><i class="fas fa-shield-alt me-1"></i>Secured by Midtrans</small>
                                </p>
                            @elseif($transaction->payment_status === 'paid')
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle me-2"></i>Payment Successful!
                                </div>
                                <a href="{{ route('transactions.index') }}" class="btn btn-primary">
                                    View My Orders
                                </a>
                            @else
                                <div class="alert alert-danger">
                                    <i class="fas fa-times-circle me-2"></i>Payment {{ ucfirst($transaction->payment_status) }}
                                </div>
                                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                                    Back to Transactions
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($transaction->payment_status === 'pending' && !isset($midtransError))
    @push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        document.getElementById('payButton').addEventListener('click', function() {
            @if($transaction->snap_token)
            snap.pay('{{ $transaction->snap_token }}', {
                onSuccess: function(result) {
                    console.log('Payment success:', result);
                    window.location.reload();
                },
                onPending: function(result) {
                    alert('Waiting for your payment!');
                },
                onError: function(result) {
                    alert('Payment failed! Please try again.');
                },
                onClose: function() {
                    console.log('Payment popup closed');
                }
            });
            @else
            alert('Payment token not available. Please refresh the page or contact support.');
            @endif
        });

        // Auto check payment status every 5 seconds
        setInterval(function() {
            fetch('{{ route("payment.check-status", $transaction) }}')
                .then(response => response.json())
                .then(data => {
                    if (data.payment_status === 'paid') {
                        window.location.reload();
                    }
                })
                .catch(error => console.error('Error checking status:', error));
        }, 5000);
    </script>
    @endpush
    @endif
@endsection
