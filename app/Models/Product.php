<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'short_description',
        'long_description',
        'price',
        'weight',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function promos()
    {
        return $this->belongsToMany(Promo::class, 'product_promo');
    }

    public function activePromos()
    {
        return $this->promos()
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->get();
    }

    public function getTotalDiscount()
    {
        $activePromos = $this->activePromos();
        
        if ($activePromos->isEmpty()) {
            return 0;
        }

        $totalDiscount = $activePromos->sum('discount_percentage');
        
        return min($totalDiscount, 100);
    }

    public function getDiscountedPrice()
    {
        $totalDiscount = $this->getTotalDiscount();
        
        if ($totalDiscount == 0) {
            return $this->price;
        }
        
        $discountAmount = $this->price * ($totalDiscount / 100);
        
        return max(0, $this->price - $discountAmount);
    }

    public function hasActivePromo()
    {
        return $this->activePromos()->isNotEmpty();
    }

    public function getFormattedPrice()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedDiscountedPrice()
    {
        return 'Rp ' . number_format($this->getDiscountedPrice(), 0, ',', '.');
    }
}