<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'category', 'original_price', 'aksespro_price', 
        'duration_days', 'stock', 'max_stock', 'is_active', 'description'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }
}
