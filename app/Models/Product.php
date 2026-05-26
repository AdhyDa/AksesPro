<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    /**
     * Get the product savings percentage.
     */
    protected function savingsPercentage(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->original_price > 0
                ? (int) round((($this->original_price - $this->aksespro_price) / $this->original_price) * 100)
                : 0,
        );
    }

    /**
     * Get the logo image path for the product.
     */
    protected function logoPath(): Attribute
    {
        return Attribute::make(
            get: function () {
                $name = strtolower($this->name);
                if (str_contains($name, 'apple')) {
                    return 'image/apple.jpg';
                }
                if (str_contains($name, 'bstation')) {
                    return 'image/bstation.jpg';
                }
                if (str_contains($name, 'canva')) {
                    return 'image/canva.jpg';
                }
                if (str_contains($name, 'capcut')) {
                    return 'image/capcut.webp';
                }
                if (str_contains($name, 'chatgpt')) {
                    return 'image/chatgpt.jpg';
                }
                if (str_contains($name, 'iqiyi')) {
                    return 'image/iqiyi.jpg';
                }
                if (str_contains($name, 'netflix')) {
                    return 'image/netflix.jpg';
                }
                if (str_contains($name, 'remini')) {
                    return 'image/remini.jpg';
                }
                if (str_contains($name, 'spotify')) {
                    return 'image/spotify.jpg';
                }
                if (str_contains($name, 'viu')) {
                    return 'image/viu.jpg';
                }
                if (str_contains($name, 'wetv')) {
                    return 'image/wetv.jpg';
                }
                if (str_contains($name, 'youtube')) {
                    return 'image/youtube.webp';
                }
                if (str_contains($name, 'zoom')) {
                    return 'image/zoom.jpg';
                }
                return 'image/zoom.jpg'; // default fallback
            }
        );
    }
    protected $fillable = [
        'name', 'slug', 'category', 'original_price', 'aksespro_price', 
        'duration_days', 'stock', 'max_stock', 'is_active', 'description'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = \Illuminate\Support\Str::slug($product->name);
            }
        });
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }
}
