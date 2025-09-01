<?php

namespace App\Livewire\Administrator\VideoManagement\Movie;

use App\Models\VideoSystem\Movie;
use Livewire\Component;

class Seasons extends Component
{
    public $movie;

    public function mount($movieId)
    {
        $this->movie = Movie::findOrFail($movieId);
    }
    public function render()
    {
        $seasons = $this->movie->seasons;
        return view('livewire.administrator.video-management.movie.seasons', compact('seasons'));
    }
}
