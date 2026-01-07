<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property string $email
 * @property int $rating
 * @property string $review
 * @property string $status
 * @property-read \App\Models\Product $product
 */
class Review extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'name', 'email', 'rating', 'review', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
