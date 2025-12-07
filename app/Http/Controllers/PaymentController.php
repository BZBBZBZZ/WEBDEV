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

    // Halaman payment
    public function show(Transaction $transaction)
    {
        try {
            // ✅ VALIDASI: Cek apakah transaction punya detail
            if ($transaction->details->isEmpty()) {
                return redirect()->route('cart.index')
                    ->with('error', 'Transaction has no items!');
            }

            // ✅ Generate snap token jika belum ada
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

    // Webhook dari Midtrans
    public function callback(Request $request)
    {
        try {
            Log::info('=== MIDTRANS CALLBACK RECEIVED ===', $request->all());

            $notification = $this->midtransService->handleNotification();
            
            Log::info('=== MIDTRANS NOTIFICATION DATA ===', $notification);

            $transaction = Transaction::where('transaction_code', $notification['order_id'])->first();

            if (!$transaction) {
                Log::error('Transaction not found', ['order_id' => $notification['order_id']]);
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Update payment info
            $transaction->update([
                'payment_type' => $notification['payment_type'],
            ]);

            // Handle different transaction statuses
            if ($notification['transaction_status'] == 'capture') {
                if ($notification['fraud_status'] == 'accept') {
                    $transaction->update([
                        'payment_status' => 'paid',
                        'paid_at' => now(),
                        'status' => 'processing',
                    ]);
                }
            } elseif ($notification['transaction_status'] == 'settlement') {
                $transaction->update([
                    'payment_status' => 'paid',
                    'paid_at' => now(),
                    'status' => 'processing',
                ]);
            } elseif (in_array($notification['transaction_status'], ['cancel', 'deny', 'expire'])) {
                $transaction->update([
                    'payment_status' => 'failed',
                ]);
            } elseif ($notification['transaction_status'] == 'pending') {
                $transaction->update([
                    'payment_status' => 'pending',
                ]);
            }

            Log::info('=== TRANSACTION UPDATED ===', [
                'transaction_code' => $transaction->transaction_code,
                'payment_status' => $transaction->payment_status,
                'status' => $transaction->status,
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

    // Finish page after payment (redirect from Midtrans)
    public function finish(Request $request)
    {
        try {
            Log::info('=== PAYMENT FINISH ===', $request->all());

            // Get order_id dari query string
            $orderId = $request->query('order_id');
            
            if (!$orderId) {
                return redirect()->route('transactions.index')
                    ->with('error', 'Invalid payment response!');
            }

            // Find transaction
            $transaction = Transaction::where('transaction_code', $orderId)->first();

            if (!$transaction) {
                return redirect()->route('transactions.index')
                    ->with('error', 'Transaction not found!');
            }

            // ✅ Check payment status dari Midtrans
            try {
                $status = $this->midtransService->getTransactionStatus($orderId);
                
                Log::info('=== MIDTRANS STATUS CHECK ===', [
                    'order_id' => $orderId,
                    'transaction_status' => $status->transaction_status,
                    'payment_type' => $status->payment_type ?? null,
                ]);

                // Update transaction based on status
                if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                    $transaction->update([
                        'payment_status' => 'paid',
                        'paid_at' => now(),
                        'status' => 'processing',
                        'payment_type' => $status->payment_type ?? $transaction->payment_type,
                    ]);
                    
                    $message = 'Payment successful! Your order is being processed.';
                    $type = 'success';
                } elseif (in_array($status->transaction_status, ['pending'])) {
                    $transaction->update([
                        'payment_status' => 'pending',
                        'payment_type' => $status->payment_type ?? $transaction->payment_type,
                    ]);
                    
                    $message = 'Payment is pending. Please complete your payment.';
                    $type = 'warning';
                } else {
                    $message = 'Payment status: ' . $status->transaction_status;
                    $type = 'info';
                }
            } catch (\Exception $e) {
                Log::error('Failed to check Midtrans status: ' . $e->getMessage());
                $message = 'Payment processed! Please check your order status.';
                $type = 'info';
            }

            // ✅ REDIRECT KE TRANSACTIONS INDEX
            return redirect()->route('transactions.index')
                ->with($type, $message);

        } catch (\Exception $e) {
            Log::error('=== PAYMENT FINISH ERROR ===', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('transactions.index')
                ->with('error', 'Payment processing error!');
        }
    }

    // Status check untuk polling dari frontend
    public function checkStatus(Transaction $transaction)
    {
        try {
            $status = $this->midtransService->getTransactionStatus($transaction->transaction_code);
            
            return response()->json([
                'status' => $status->transaction_status,
                'payment_type' => $status->payment_type ?? null,
            ]);
        } catch (\Exception $e) {
            Log::error('Check status error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to check status'], 500);
        }
    }
}