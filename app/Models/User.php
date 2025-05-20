<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
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
