<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cast extends Model
{
    protected $fillable = [
        'name',
        'birth_date',
        'photo_url',
    ];

    public function films()
    {
        return $this->belongsToMany(Film::class, 'film_cast')->withPivot('character');
    }
}
