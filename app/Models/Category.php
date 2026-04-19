<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'image', 'icon', 'filters', 'show_on_sidebar', 'order_index'];

    protected $casts = [
        'filters' => 'array',
        'show_on_sidebar' => 'boolean',
        'order_index' => 'integer'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
