<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilmCast extends Model
{
    protected $table = 'film_cast';

    protected $fillable = [
        'film_id',
        'cast_id',
    ];
}
