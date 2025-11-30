<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'order_name',
        'description',
        'status'
    ];

    public function getStatusBadgeClass()
    {
        return match($this->status) {
            'not_made' => 'bg-secondary',
            'in_progress' => 'bg-warning',
            'finished' => 'bg-success',
            default => 'bg-secondary'
        };
    }

    public function getStatusLabel()
    {
        return match($this->status) {
            'not_made' => 'Not Made',
            'in_progress' => 'In Progress',
            'finished' => 'Finished',
            default => 'Unknown'
        };
    }
}
