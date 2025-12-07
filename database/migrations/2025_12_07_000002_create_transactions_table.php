<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('transaction_code')->unique();
            
            // Customer Information
            $table->string('customer_name');
            $table->string('customer_phone', 20);
            $table->text('customer_address');
            
            // Location IDs (RajaOngkir)
            $table->integer('province_id');
            $table->integer('city_id');
            $table->integer('district_id');
            
            // Shipping Information
            $table->string('courier_code');
            $table->string('courier_service');
            $table->decimal('shipping_cost', 10, 2)->default(0);
            
            // Pricing
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);
            
            // Status - FIX ENUM VALUES
            $table->enum('status', ['pending', 'processing', 'shipped', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'expired'])->default('pending'); // ✅ HAPUS 'unpaid', PAKAI 'pending'
            
            // Midtrans Fields
            $table->string('snap_token')->nullable();
            $table->string('payment_type')->nullable();
            $table->timestamp('paid_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
