<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    // Define the attributes that can be mass-assigned
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Define hidden attributes when converting the model to an array or JSON
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Specify how the 'email_verified_at' attribute should be cast
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // JWT implementation: Get the identifier that will be stored in the token
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // JWT implementation: Add custom claims to the JWT
    public function getJWTCustomClaims()
    {
        return [];
    }
}
