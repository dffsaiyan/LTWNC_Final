<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'brand_id', 'name', 'slug', 'brand', 'layout', 'connection', 'weight', 
        'resolution', 'panel', 'cpu', 'gpu', 'ram', 'ssd', 'size', 'surface', 
        'material', 'profile', 'frame', 'description', 'price', 'sale_price', 
        'stock', 'image', 'is_active', 'is_flash_sale', 'flash_sale_end', 
        'specifications', 'faqs'
    ];

    protected $casts = [
        'specifications' => 'array',
        'faqs' => 'array',
        'is_flash_sale' => 'boolean',
        'flash_sale_end' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class)->latest();
    }
}
