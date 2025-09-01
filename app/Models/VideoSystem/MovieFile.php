<?php

namespace App\Models\VideoSystem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'movie_id', 'movie_season_id', 'name', 'path', 'image', 'code', 'quality'
    ];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(MovieSeason::class, 'movie_season_id');
    }
}
