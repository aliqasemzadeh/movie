<?php

namespace App\Models\VideoSystem;

use Illuminate\Database\Eloquent\Model;

class MovieFile extends Model
{


    public function movie(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function season(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(MovieSeason::class);
    }
}
