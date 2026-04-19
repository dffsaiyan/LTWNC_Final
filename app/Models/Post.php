<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'user_id', 'title', 'slug', 'thumbnail', 'summary', 'content', 'is_published'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($post) {
            $post->slug = Str::slug($post->title) . '-' . uniqid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
