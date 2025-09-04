<?php

namespace App\Console\Commands;

use App\Models\VideoSystem\Movie;
use App\Models\VideoSystem\Genre;
use App\Models\VideoSystem\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate XML sitemap for SEO';

    public function handle()
    {
        $this->info('Generating sitemap...');

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;

        // Home page
        $sitemap .= $this->addUrl(route('home'), '1.0', 'daily');

        // Movies index
        $sitemap .= $this->addUrl(route('front.movie.index'), '0.8', 'daily');

        // Individual movies
        $movies = Movie::select('id', 'slug', 'updated_at')->get();
        foreach ($movies as $movie) {
            $sitemap .= $this->addUrl(
                route('front.movie.view', ['movieId' => $movie->id, 'slug' => $movie->slug]),
                '0.7',
                'weekly',
                $movie->updated_at
            );
        }

        // Genres
        $genres = Genre::select('id', 'slug', 'updated_at')->get();
        foreach ($genres as $genre) {
            $sitemap .= $this->addUrl(
                route('front.movie.genre', ['slug' => $genre->slug ?? $genre->id]),
                '0.6',
                'weekly',
                $genre->updated_at
            );
        }

        // Countries
        $countries = Country::select('id', 'slug', 'updated_at')->get();
        foreach ($countries as $country) {
            $sitemap .= $this->addUrl(
                route('front.movie.country', ['slug' => $country->slug ?? $country->id]),
                '0.6',
                'weekly',
                $country->updated_at
            );
        }

        $sitemap .= '</urlset>';

        // Save sitemap
        $path = public_path('sitemap.xml');
        File::put($path, $sitemap);

        $this->info('Sitemap generated successfully at: ' . $path);
        $this->info('Total URLs: ' . (2 + $movies->count() + $genres->count() + $countries->count()));

        return Command::SUCCESS;
    }

    private function addUrl(string $url, string $priority, string $changefreq, $lastmod = null): string
    {
        $xml = '  <url>' . PHP_EOL;
        $xml .= '    <loc>' . $url . '</loc>' . PHP_EOL;
        $xml .= '    <priority>' . $priority . '</priority>' . PHP_EOL;
        $xml .= '    <changefreq>' . $changefreq . '</changefreq>' . PHP_EOL;
        
        if ($lastmod) {
            $xml .= '    <lastmod>' . $lastmod->toISOString() . '</lastmod>' . PHP_EOL;
        }
        
        $xml .= '  </url>' . PHP_EOL;
        
        return $xml;
    }
}
