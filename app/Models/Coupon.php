<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_order_value', 
        'max_uses', 'used_count', 'category_id', 
        'expiry_date', 'is_active'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
