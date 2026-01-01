<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = ['venture_id', 'ip_address'];

    public function venture()
    {
        return $this->belongsTo(Venture::class);
    }
}
