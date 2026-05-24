<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'invoice_id', 'user_id', 'product_id', 'total_amount', 
        'payment_method', 'status', 'paid_at', 'snap_token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }
}
