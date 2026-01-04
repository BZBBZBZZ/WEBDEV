<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected $serverKey;
    protected $clientKey;
    protected $isProduction;

    public function __construct()
    {
        $this->serverKey = config('services.midtrans.server_key');
        $this->clientKey = config('services.midtrans.client_key');
        $this->isProduction = config('services.midtrans.is_production');

        \Midtrans\Config::$serverKey = $this->serverKey;
        \Midtrans\Config::$clientKey = $this->clientKey;
        \Midtrans\Config::$isProduction = $this->isProduction;
        \Midtrans\Config::$isSanitized = config('services.midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function createTransaction($transaction)
    {
        $itemDetails = [];

        foreach ($transaction->details as $detail) {
            $itemDetails[] = [
                'id' => $detail->product_id,
                'price' => (int) round($detail->price),
                'quantity' => $detail->quantity,
                'name' => $detail->product_name,
            ];
        }

        $itemDetails[] = [
            'id' => 'SHIPPING',
            'price' => (int) round($transaction->shipping_cost),
            'quantity' => 1,
            'name' => 'Shipping Cost (' . strtoupper($transaction->courier_code) . ' - ' . $transaction->courier_service . ')',
        ];

        $customerDetails = [
            'first_name' => $transaction->customer_name,
            'phone' => $transaction->customer_phone,
            'shipping_address' => [
                'address' => $transaction->customer_address,
                'postal_code' => $transaction->postal_code ?? '00000',
            ],
        ];

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->transaction_code,
                'gross_amount' => (int) round($transaction->total_amount),
            ],
            'customer_details' => $customerDetails,
            'item_details' => $itemDetails,
            'callbacks' => [
                'finish' => route('payment.finish', ['order_id' => $transaction->transaction_code])
            ]
        ];

        $params['expiry'] = [
            'start_time' => date('Y-m-d H:i:s O'),
            'unit' => 'day',
            'duration' => 1
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            Log::info('=== MIDTRANS SNAP TOKEN CREATED ===', [
                'transaction_code' => $transaction->transaction_code,
                'snap_token' => $snapToken,
                'transaction_id' => $transaction->id,
                'finish_url' => route('payment.finish', ['order_id' => $transaction->transaction_code])
            ]);

            return $snapToken;
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getTransactionStatus($orderId)
    {
        try {
            $status = \Midtrans\Transaction::status($orderId);
            return $status;
        } catch (\Exception $e) {
            Log::error('Midtrans Status Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function handleNotification()
    {
        try {
            $notification = new \Midtrans\Notification();

            return [
                'order_id' => $notification->order_id,
                'transaction_status' => $notification->transaction_status,
                'payment_type' => $notification->payment_type,
                'transaction_time' => $notification->transaction_time,
                'fraud_status' => $notification->fraud_status ?? null,
            ];
        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function getClientKey()
    {
        return $this->clientKey;
    }
}
