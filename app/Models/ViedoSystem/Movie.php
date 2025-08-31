<?php

namespace App\Models\ViedoSystem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'description', 'image', 'cover', 'IMDB', 'IMDB_link', 'trailer', 'rank', 'year', 'duration', 'director_artist_id', 'country_id'
    ];

    public function director()
    {
        return $this->belongsTo(Artist::class, 'director_artist_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'movie_artists');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'movie_genres');
    }
}
