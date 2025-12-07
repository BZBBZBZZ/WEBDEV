<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];

    // ✅ Append accessor ke array
    protected $appends = ['subtotal'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * ✅ Get subtotal (price * quantity dengan discount)
     */
    public function getSubtotalAttribute()
    {
        if (!$this->product) {
            return 0;
        }

        // ✅ Cast ke float untuk memastikan kalkulasi benar
        $price = (float) $this->product->getDiscountedPrice();
        $quantity = (int) $this->quantity;

        return $price * $quantity;
    }

    /**
     * Get formatted subtotal
     */
    public function getFormattedSubtotalAttribute()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }
}
