<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function show(Transaction $transaction)
    {
        try {
            if ($transaction->details->isEmpty()) {
                return redirect()->route('cart.index')
                    ->with('error', 'Transaction has no items!');
            }

            if (!$transaction->snap_token) {
                $snapToken = $this->midtransService->createTransaction($transaction);

                $transaction->update([
                    'snap_token' => $snapToken
                ]);
            }

            return view('payment.show', [
                'transaction' => $transaction,
                'clientKey' => config('services.midtrans.client_key')
            ]);
        } catch (\Exception $e) {
            Log::error('=== PAYMENT SHOW ERROR ===', [
                'transaction_id' => $transaction->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return view('payment.show', [
                'transaction' => $transaction,
                'midtransError' => 'Midtrans configuration error. Please contact administrator or try manual payment method.'
            ]);
        }
    }

    public function callback(Request $request)
    {
        try {
            Log::info('=== MIDTRANS CALLBACK RECEIVED ===', $request->all());

            $orderId = $request->input('order_id');
            $transactionStatus = $request->input('transaction_status');
            $fraudStatus = $request->input('fraud_status');
            $paymentType = $request->input('payment_type');
            $signatureKey = $request->input('signature_key');

            $serverKey = config('services.midtrans.server_key');
            $hashed = hash('sha512', $orderId . $request->input('status_code') . $request->input('gross_amount') . $serverKey);

            if ($hashed !== $signatureKey) {
                Log::error('Invalid signature key');
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $transaction = Transaction::where('transaction_code', $orderId)->first();

            if (!$transaction) {
                Log::error('Transaction not found', ['order_id' => $orderId]);
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                if ($fraudStatus == 'accept') {
                    $transaction->update([
                        'payment_status' => 'paid',
                        'paid_at' => now(),
                        'status' => 'processing',
                        'payment_type' => $paymentType,
                    ]);

                    Log::info('Payment Success', [
                        'transaction_code' => $transaction->transaction_code,
                    ]);
                }
            } elseif ($transactionStatus == 'pending') {
                $transaction->update([
                    'payment_status' => 'pending',
                    'payment_type' => $paymentType,
                ]);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $transaction->update([
                    'payment_status' => 'failed',
                    'payment_type' => $paymentType,
                ]);
            }

            Log::info('=== TRANSACTION UPDATED ===', [
                'transaction_code' => $transaction->transaction_code,
                'payment_status' => $transaction->payment_status,
            ]);

            return response()->json(['message' => 'OK']);
        } catch (\Exception $e) {
            Log::error('=== MIDTRANS CALLBACK ERROR ===', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['message' => 'Internal server error'], 500);
        }
    }

    public function finish(Request $request)
    {
        try {
            Log::info('=== PAYMENT FINISH ===', $request->all());

            $orderId = $request->input('order_id');

            if (!$orderId) {
                return redirect()->route('transactions.index')
                    ->with('error', 'Invalid payment response!');
            }

            $transaction = Transaction::where('transaction_code', $orderId)->first();

            if (!$transaction) {
                return redirect()->route('transactions.index')
                    ->with('error', 'Transaction not found!');
            }

            sleep(2);

            $transaction->refresh();

            if ($transaction->payment_status === 'paid') {
                $message = 'Payment successful! Your order is being processed.';
                $type = 'success';
            } elseif ($transaction->payment_status === 'pending') {
                $message = 'Payment is pending. Please complete your payment.';
                $type = 'warning';
            } else {
                $message = 'Payment status: ' . $transaction->payment_status;
                $type = 'info';
            }

            return redirect()->route('transactions.index')
                ->with($type, $message);
        } catch (\Exception $e) {
            Log::error('=== PAYMENT FINISH ERROR ===', [
                'message' => $e->getMessage(),
            ]);

            return redirect()->route('transactions.index')
                ->with('error', 'Payment processing error!');
        }
    }

    public function checkStatus(Transaction $transaction)
    {
        try {
            $transaction->refresh();

            return response()->json([
                'status' => $transaction->status,
                'payment_status' => $transaction->payment_status,
                'payment_type' => $transaction->payment_type ?? null,
            ]);
        } catch (\Exception $e) {
            Log::error('Check status error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to check status'], 500);
        }
    }
}
