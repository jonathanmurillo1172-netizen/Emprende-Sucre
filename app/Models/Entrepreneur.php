<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entrepreneur extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'gender',
        'description',
        'status',
        'activation_requested_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ventures()
    {
        return $this->hasMany(Venture::class);
    }
}
