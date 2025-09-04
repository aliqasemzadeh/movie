<?php

namespace App\Livewire\Front\Movie;

use App\Models\VideoSystem\Movie;
use Livewire\Attributes\Layout;
use Livewire\Component;

class View extends Component
{
    public $movie;
    public $slug;

    public function mount($movieId, $slug = "")
    {
        $this->movie = Movie::with([
            'director', 'country', 'artists', 'genres',
            'seasons',
            'files.season',
        ])->find($movieId);
    }

    public function getSeasonedFilesProperty()
    {
        if (!$this->movie) {
            return collect();
        }
        // Group files by season (null season grouped under 'no-season') and sort by season title
        return $this->movie->files->groupBy(function ($file) {
            return optional($file->season)->title ?? __('quickpanel.no_season');
        })->sortKeys();
    }

    /**
     * Get SEO meta tags
     */
    public function getMetaTagsProperty(): array
    {
        if (!$this->movie) {
            return [];
        }

        return [
            'title' => $this->movie->title,
            'description' => $this->movie->meta_description,
            'keywords' => $this->movie->meta_keywords,
            'canonical' => $this->movie->canonical_url,
            'open_graph' => $this->movie->open_graph_data,
            'structured_data' => $this->movie->structured_data,
        ];
    }

    /**
     * Get breadcrumb data
     */
    public function getBreadcrumbsProperty(): array
    {
        if (!$this->movie) {
            return [];
        }

        $breadcrumbs = [
            ['title' => __('Home'), 'url' => route('home')],
            ['title' => __('Movies'), 'url' => route('front.movie.index')],
        ];

        if ($this->movie->genres && $this->movie->genres->count()) {
            $firstGenre = $this->movie->genres->first();
            $breadcrumbs[] = [
                'title' => $firstGenre->title,
                'url' => route('front.movie.genre', ['slug' => $firstGenre->slug ?? $firstGenre->id])
            ];
        }

        $breadcrumbs[] = [
            'title' => $this->movie->title,
            'url' => $this->movie->canonical_url,
            'current' => true
        ];

        return $breadcrumbs;
    }

    #[Layout('layouts.front')]
    public function render()
    {
        return view('livewire.front.movie.view');
    }
}
