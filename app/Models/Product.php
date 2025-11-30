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

    public function activePromo()
    {
        return $this->promos()
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->first();
    }

    public function getDiscountedPrice()
    {
        $promo = $this->activePromo();
        if ($promo) {
            return $this->price - ($this->price * $promo->discount_percentage / 100);
        }
        return $this->price;
    }
}
