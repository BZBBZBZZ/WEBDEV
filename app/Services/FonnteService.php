<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FonnteService
{
    protected $token;
    protected $adminPhone;

    public function __construct()
    {
        $this->token = config('services.fonnte.token');
        $this->adminPhone = config('services.fonnte.admin_phone');
    }

    /**
     * Send WhatsApp message via Fonnte
     */
    public function sendMessage($target, $message)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => $this->token
            ])->post('https://api.fonnte.com/send', [
                'target' => $target,
                'message' => $message,
                'countryCode' => '62'
            ]);

            Log::info('Fonnte WhatsApp Sent', [
                'target' => $target,
                'response' => $response->json()
            ]);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('Fonnte Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send new order notification to admin
     */
    public function notifyNewOrder($transaction)
    {
        $message = "*🎉 NEW ORDER RECEIVED*\n\n";
        $message .= "Order ID: *{$transaction->transaction_code}*\n";
        $message .= "Customer: {$transaction->customer_name}\n";
        $message .= "Phone: {$transaction->customer_phone}\n\n";
        
        $message .= "*📦 Order Details:*\n";
        foreach ($transaction->details as $index => $detail) {
            $message .= ($index + 1) . ". {$detail->product_name}\n";
            $message .= "   Qty: {$detail->quantity} x Rp " . number_format($detail->price, 0, ',', '.') . "\n";
        }
        
        $message .= "\n*💰 Payment Summary:*\n";
        $message .= "Subtotal: Rp " . number_format($transaction->subtotal, 0, ',', '.') . "\n";
        $message .= "Shipping: Rp " . number_format($transaction->shipping_cost, 0, ',', '.') . "\n";
        $message .= "Total: *Rp " . number_format($transaction->total_amount, 0, ',', '.') . "*\n\n";
        
        $message .= "*📍 Shipping Address:*\n";
        $message .= "{$transaction->customer_address}\n\n";
        
        $message .= "Payment Status: ✅ *PAID*\n";
        $message .= "Order Date: " . $transaction->created_at->format('d M Y, H:i') . "\n";

        return $this->sendMessage($this->adminPhone, $message);
    }
}
