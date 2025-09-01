<?php

namespace App\Models\VideoSystem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'slug', 'description', 'image', 'cover', 'IMDB', 'IMDB_link', 'trailer', 'rank', 'year', 'duration', 'director_artist_id', 'country_id'
    ];

    public function director(): belongsTo
    {
        return $this->belongsTo(Artist::class, 'director_artist_id');
    }

    public function country():belongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function artists(): belongsToMany
    {
        return $this->belongsToMany(Artist::class, 'movie_artists');
    }

    public function genres(): belongsToMany
    {
        return $this->belongsToMany(Genre::class, 'movie_genres');
    }

    public function seasons(): HasMany
    {
        return $this->hasMany(MovieSeason::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(MovieFile::class);
    }
}
