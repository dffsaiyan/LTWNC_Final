<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Review extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'message',
        'is_visible',
        'parent_id'
    ];
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function replies()
    {
        return $this->hasMany(Review::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Review::class, 'parent_id');
    }
}
