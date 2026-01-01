<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venture extends Model
{
    protected $fillable = [
        'entrepreneur_id',
        'category_id',
        'title',
        'image',
        'description',
        'location',
        'status'
    ];

    public function entrepreneur()
    {
        return $this->belongsTo(Entrepreneur::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }
}
