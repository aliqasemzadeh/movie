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

    #[Layout('layouts.front')]
    public function render()
    {
        return view('livewire.front.movie.view');
    }
}
