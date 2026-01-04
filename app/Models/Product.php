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

    protected $casts = [
        'price' => 'decimal:2',
        'weight' => 'integer',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function promos()
    {
        return $this->belongsToMany(Promo::class, 'product_promo');
    }

    public function activePromosQuery()
    {
        return $this->promos()
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now());
    }

    public function activePromos()
    {
        return $this->activePromosQuery()->get();
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
            return (float) $this->price;
        }

        $discountAmount = $this->price * ($totalDiscount / 100);

        return (float) max(0, $this->price - $discountAmount);
    }

    public function hasActivePromo()
    {
        return $this->activePromosQuery()->exists();
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
