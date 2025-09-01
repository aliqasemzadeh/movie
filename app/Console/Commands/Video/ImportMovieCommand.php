<?php

namespace App\Console\Commands\Video;

use App\Models\VideoSystem\Movie;
use App\Models\VideoSystem\Artist;
use App\Models\VideoSystem\Country;
use Illuminate\Console\Attributes\AsCommand;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[AsCommand(name: 'movie:import', description: 'Import movies and their images from imdbapi.dev (up to a given limit).')]
class ImportMovieCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'movie:import {--limit=100}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import movies and their images from imdbapi.dev (up to a given limit).';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $limit = (int) $this->option('limit');
        if ($limit < 1) {
            $this->error('Limit must be at least 1');
            return self::FAILURE;
        }

        $this->info("Fetching titles from imdbapi.dev (limit: {$limit})...");

        try {
            $response = Http::acceptJson()
                ->timeout(30)
                ->get('https://api.imdbapi.dev/titles', [
                    'page' => 1,
                    'limit' => max($limit, 50),
                ]);
        } catch (\Throwable $e) {
            $this->error('HTTP request failed: ' . $e->getMessage());
            return self::FAILURE;
        }

        if (!$response->successful()) {
            $this->error('Failed to fetch data: HTTP ' . $response->status());
            return self::FAILURE;
        }

        $json = $response->json();
        $items = $json['titles'] ?? [];
        if (!is_array($items)) {
            $this->error('Unexpected API response structure.');
            return self::FAILURE;
        }

        // Ensure we have a default director and country to satisfy NOT NULL constraints
        $defaultDirector = Artist::firstOrCreate(
            ['slug' => 'unknown-director'],
            [
                'name' => 'Unknown Director',
                'image' => 'https://via.placeholder.com/300x400.png?text=Director',
                'description' => null,
            ]
        );
        $defaultCountry = Country::firstOrCreate(
            ['slug' => 'united-states'],
            [
                'name' => 'United States',
                'image' => null,
                'description' => null,
            ]
        );

        $count = 0;
        foreach ($items as $item) {
            if ($count >= $limit) break;

            $title = $item['primaryTitle'] ?? $item['originalTitle'] ?? null;
            if (!$title) {
                continue; // skip if no title
            }

            $imageUrl = $item['primaryImage']['url'] ?? null;

            $slug = Str::slug($title);

            // Avoid duplicates by slug
            $movie = Movie::firstOrNew(['slug' => $slug]);
            $movie->title = $title;

            // Normalize numeric fields
            $year = $item['startYear'] ?? null;
            $year = is_numeric($year) ? (int) $year : 0;
            $durationMin = isset($item['runtimeSeconds']) && is_numeric($item['runtimeSeconds'])
                ? (int) round(((int) $item['runtimeSeconds']) / 60)
                : 0;
            $rank = $item['rating']['aggregateRating'] ?? null;
            $rank = is_numeric($rank) ? (float) $rank : 0;

            // Download image to local storage if available
            // Save relative paths on the public disk to mirror Create.php behavior
            $relativeImagePath = null;
            $relativeCoverPath = null;
            if ($imageUrl) {
                try {
                    $imgResponse = Http::timeout(30)->get($imageUrl);
                    if ($imgResponse->successful()) {
                        $bytes = $imgResponse->body();
                        $hash = substr(sha1($bytes), 0, 12);
                        $ext = 'jpg';
                        // Follow Create.php folder structure
                        $imagePath = "movies/images/{$slug}-{$hash}.{$ext}";
                        $coverPath = "movies/covers/{$slug}-{$hash}.{$ext}";
                        if (!Storage::disk('public')->exists($imagePath)) {
                            Storage::disk('public')->put($imagePath, $bytes);
                        }
                        if (!Storage::disk('public')->exists($coverPath)) {
                            Storage::disk('public')->put($coverPath, $bytes);
                        }
                        $relativeImagePath = $imagePath;
                        $relativeCoverPath = $coverPath;
                    }
                } catch (\Throwable $e) {
                    // silently ignore, fallback below
                }
            }
            if (!$relativeImagePath ?? false) {
                // fallback to a relative placeholder under public/storage if you have it, else leave null
                // Prefer using the same pattern as manual create: store relative disk path, and views call Storage::url()
                $relativeImagePath = 'images/placeholder.jpg'; // expects public storage symlink or copy
                $relativeCoverPath = 'images/placeholder.jpg';
            }
            $movie->image = $relativeImagePath;
            $movie->cover = $relativeCoverPath;

            $movie->description = $item['plot'] ?? ($movie->description ?? '');
            $movie->IMDB_link = isset($item['id']) ? ('https://www.imdb.com/title/' . (string)$item['id']) : ($movie->IMDB_link ?? null);
            $movie->year = $year;
            $movie->duration = $durationMin;
            $movie->rank = $rank;
            $movie->director_artist_id = $movie->director_artist_id ?? $defaultDirector->id;
            $movie->country_id = $movie->country_id ?? $defaultCountry->id;

            $movie->save();

            $count++;
            $this->line("Imported: {$movie->title}");
        }

        $this->info("Imported {$count} movies.");
        return self::SUCCESS;
    }
}
