<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    protected $fillable = [
        'name',
        'email',
        'password',
        'photo_url',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
