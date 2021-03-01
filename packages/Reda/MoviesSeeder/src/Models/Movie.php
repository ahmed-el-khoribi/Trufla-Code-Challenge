<?php

namespace Reda\MoviesSeeder\Models;

use Illuminate\Database\Eloquent\Model;


class Movie extends Model
{
    protected $table    =   'movies';

    protected $fillable =   [
        'tmdb_id',
        'title',
        'overview',
        'voteAverage',
        'voteCount',
        'popularity'
    ];

    /**
     * The genres that belong to the collection.
     */
    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genres', 'movie_id', 'genre_id');
    }

    /**
     * Scope a query to only include popular movies.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $order
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular($query, $order)
    {
        return $query->orderBy('popularity', $order);
    }

    /**
     * Scope a query to only include top rated movies.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $order
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRated($query, $order)
    {
        return $query->orderBy('voteAverage', $order);
    }

    /**
     * Scope a query to only include PROVIDED CATEGORY_ID.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $category_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCategoryid($query, $category_id)
    {
        return $query->whereHas('genres', function($q) use ($category_id) {
            $q->whereId( $category_id );
         });
    }
}
