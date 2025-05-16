<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
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
