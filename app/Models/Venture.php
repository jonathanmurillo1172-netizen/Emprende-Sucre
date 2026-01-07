<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $entrepreneur_id
 * @property int $category_id
 * @property string $title
 * @property string $image
 * @property string $description
 * @property string $location
 * @property string $status
 * @property-read \App\Models\Entrepreneur $entrepreneur
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Inquiry[] $inquiries
 */
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
