<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
        'title',
        'synopsis',
        'release_year',
        'duration',
        'poster_url',
        'director',
        'rating_avg',
        'total_reviews',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'film_genre');
    }

    public function characters()
    {
        return $this->belongsToMany(Cast::class, 'film_cast');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
