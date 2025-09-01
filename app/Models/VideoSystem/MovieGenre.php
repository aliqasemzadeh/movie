<?php

namespace App\Models\VideoSystem;

use Illuminate\Database\Eloquent\Model;

class MovieGenre extends Model
{
    protected $fillable = [
        'movie_id', 'genre_id'
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
