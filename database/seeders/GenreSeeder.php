<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\ViedoSystem\Genre;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = [
            'Action',
            'Action & Adventure',
            'Adventure',
            'Animation',
            'Biography',
            'Comedy',
            'Costume',
            'Crime',
            'Documentary',
            'Drama',
            'Family',
            'Fantasy',
            'Film-Noir',
            'Game-Show',
            'History',
            'Horror',
            'Jen Statsky',
            'Kungfu',
            'Music',
            'Musical',
            'Mystery',
            'Mythological',
            'News',
            'Psychological',
            'Reality',
            'Reality-TV',
            'Romance',
            'Sci-Fi',
            'Sci-Fi & Fantasy',
            'Science Fiction',
            'Short',
            'Sitcom',
            'Sport',
            'Talk-Show',
            'Thriller',
            'TV Movie',
            'TV Show',
            'Vito Glazers',
            'War',
            'Western',
        ];

        // Ensure unique by slug to avoid duplicate insert attempts
        $seenSlugs = [];
        foreach ($genres as $name) {
            $slug = Str::slug($name);
            if (isset($seenSlugs[$slug])) {
                continue;
            }
            $seenSlugs[$slug] = true;

            Genre::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name]
            );
        }
    }
}
