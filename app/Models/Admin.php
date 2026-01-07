<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $phone
 * @property string $description
 * @property string $status
 * @property-read \App\Models\User $user
 */
class Admin extends Model
{
    protected $fillable = [
        'user_id',
        'phone',
        'description',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
