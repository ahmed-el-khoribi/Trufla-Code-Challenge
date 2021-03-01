<?php

namespace Reda\MoviesSeeder\Models;

use Illuminate\Database\Eloquent\Model;


class Genre extends Model
{
    protected $table    =   'genres';

    protected $fillable =   [
        'name'
    ];

    /**
     * The movies that belong to the collection.
     */
    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_genres', 'genre_id', 'movie_id');
    }
}
