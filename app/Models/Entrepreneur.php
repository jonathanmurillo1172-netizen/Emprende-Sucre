<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $phone
 * @property string $gender
 * @property string $description
 * @property string $status
 * @property string|null $activation_requested_at
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Venture[] $ventures
 */
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
