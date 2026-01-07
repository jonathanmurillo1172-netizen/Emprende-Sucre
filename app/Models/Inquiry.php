<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $venture_id
 * @property string $name
 * @property string $email
 * @property string $message
 * @property bool $attended
 * @property-read \App\Models\Venture $venture
 */
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
