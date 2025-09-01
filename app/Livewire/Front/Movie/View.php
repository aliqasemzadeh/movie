<?php

namespace App\Livewire\Front\Movie;

use App\Models\VideoSystem\Movie;
use Livewire\Component;

class View extends Component
{
    public $movie;
    public $slug;
    public function mount($movieId, $slug = "")
    {
        $this->movie = Movie::find($movieId);
    }
    public function render()
    {
        return view('livewire.front.movie.view');
    }
}
