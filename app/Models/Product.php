<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
