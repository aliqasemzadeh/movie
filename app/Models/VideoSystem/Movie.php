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

    protected $casts = [
        'year' => 'integer',
        'duration' => 'integer',
        'IMDB' => 'decimal:1',
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

    /**
     * Get SEO-friendly meta description
     */
    public function getMetaDescriptionAttribute(): string
    {
        $description = $this->description;
        
        if ($this->year) {
            $description .= " ({$this->year})";
        }
        
        if ($this->director) {
            $description .= " Directed by {$this->director->name}";
        }
        
        if ($this->country) {
            $description .= " from {$this->country->name}";
        }
        
        if ($this->genres && $this->genres->count()) {
            $genreNames = $this->genres->pluck('title')->implode(', ');
            $description .= ". Genres: {$genreNames}";
        }
        
        return substr($description, 0, 160);
    }

    /**
     * Get SEO-friendly meta keywords
     */
    public function getMetaKeywordsAttribute(): string
    {
        $keywords = [$this->title];
        
        if ($this->year) {
            $keywords[] = $this->year;
        }
        
        if ($this->director) {
            $keywords[] = $this->director->name;
        }
        
        if ($this->country) {
            $keywords[] = $this->country->name;
        }
        
        if ($this->genres) {
            $keywords = array_merge($keywords, $this->genres->pluck('title')->toArray());
        }
        
        if ($this->artists) {
            $keywords = array_merge($keywords, $this->artists->pluck('name')->toArray());
        }
        
        return implode(', ', array_unique($keywords));
    }

    /**
     * Get canonical URL
     */
    public function getCanonicalUrlAttribute(): string
    {
        return route('front.movie.view', ['movieId' => $this->id, 'slug' => $this->slug]);
    }

    /**
     * Get structured data for JSON-LD
     */
    public function getStructuredDataAttribute(): array
    {
        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'Movie',
            'name' => $this->title,
            'description' => $this->description,
            'url' => $this->canonical_url,
        ];

        if ($this->year) {
            $data['dateCreated'] = $this->year;
        }

        if ($this->duration) {
            $data['duration'] = 'PT' . $this->duration . 'M';
        }

        if ($this->director) {
            $data['director'] = [
                '@type' => 'Person',
                'name' => $this->director->name
            ];
        }

        if ($this->country) {
            $data['countryOfOrigin'] = [
                '@type' => 'Country',
                'name' => $this->country->name
            ];
        }

        if ($this->genres && $this->genres->count()) {
            $data['genre'] = $this->genres->pluck('title')->toArray();
        }

        if ($this->artists && $this->artists->count()) {
            $data['actor'] = $this->artists->map(function ($artist) {
                return [
                    '@type' => 'Person',
                    'name' => $artist->name
                ];
            })->toArray();
        }

        if ($this->cover) {
            $data['image'] = $this->cover;
        }

        if ($this->IMDB) {
            $data['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => $this->IMDB,
                'bestRating' => '10',
                'ratingCount' => '1'
            ];
        }

        return $data;
    }

    /**
     * Get Open Graph data
     */
    public function getOpenGraphDataAttribute(): array
    {
        $data = [
            'og:title' => $this->title,
            'og:description' => $this->meta_description,
            'og:type' => 'video.movie',
            'og:url' => $this->canonical_url,
        ];

        if ($this->cover) {
            $data['og:image'] = $this->cover;
        }

        if ($this->year) {
            $data['og:site_name'] = config('app.name') . ' - ' . $this->year;
        }

        return $data;
    }

    /**
     * Generate clean slug for SEO
     */
    public function generateSlug(): string
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $this->title)));
        $slug = trim($slug, '-');
        
        // Add year if available for uniqueness
        if ($this->year) {
            $slug .= '-' . $this->year;
        }
        
        return $slug;
    }

    /**
     * Boot method to auto-generate slug if not provided
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($movie) {
            if (empty($movie->slug)) {
                $movie->slug = $movie->generateSlug();
            }
        });
        
        static::updating(function ($movie) {
            if ($movie->isDirty('title') && empty($movie->slug)) {
                $movie->slug = $movie->generateSlug();
            }
        });
    }
}
