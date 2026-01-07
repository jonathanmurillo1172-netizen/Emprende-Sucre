<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Entrepreneur;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property-read \App\Models\Entrepreneur|null $entrepreneur
 * @property-read \App\Models\Admin|null $admin
 */
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //metodos para los roles
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEntrepreneur()
    {
        return $this->role === 'entrepreneur';
    }

    //relacion con emprendedor y perfil
    public function entrepreneur()
    {
        return $this->hasOne(Entrepreneur::class);
    }

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }
}
