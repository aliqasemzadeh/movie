<?php

namespace App\Models\VideoSystem;

use Illuminate\Database\Eloquent\Model;

class MovieArtist extends Model
{
    protected $fillable = [
        'movie_id', 'artist_id'
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }
}
