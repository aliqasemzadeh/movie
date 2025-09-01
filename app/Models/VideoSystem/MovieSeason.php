<?php

namespace App\Models\VideoSystem;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MovieSeason extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'number', 'sort_order', 'slug', 'description', 'image', 'movie_id'
    ];

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function files(): HasMany
    {
        return $this->hasMany(MovieFile::class);
    }
}
