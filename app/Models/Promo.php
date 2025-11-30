<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'discount_percentage',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_promo');
    }

    public function isActive()
    {
        $today = Carbon::today();
        return $today->between($this->start_date, $this->end_date);
    }
}
