<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $venture_id
 * @property string $title
 * @property string $image
 * @property string $description
 * @property float $price
 * @property string $status
 * @property-read \App\Models\Venture $venture
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $reviews
 */
class Product extends Model
{
    protected $fillable = [
        'venture_id',
        'title',
        'image',
        'description',
        'price',
        'status'
    ];

    public function venture()
    {
        return $this->belongsTo(Venture::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
