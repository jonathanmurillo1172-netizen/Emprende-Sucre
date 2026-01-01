<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'venture_id',
        'name',
        'email',
        'message',
        'attended',
    ];

    public function venture()
    {
        return $this->belongsTo(Venture::class);
    }
}
