<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function testimonial()
    {
        return $this->hasOne(Testimonial::class);
    }

    /**
     * Check if user has at least 1 paid transaction
     */
    public function hasPaidTransaction(): bool
    {
        return $this->transactions()
            ->where('payment_status', 'paid')
            ->exists();
    }

    /**
     * Check if user can create testimonial
     */
    public function canCreateTestimonial(): bool
    {
        return $this->hasPaidTransaction() && !$this->testimonial;
    }
}