<?php

namespace App\Livewire\Front\Movie;

use App\Models\VideoSystem\Movie;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    #[Layout('layouts.front')]
    public function render()
    {
        $movies = Movie::paginate(40);
        return view('livewire.front.movie.index', compact('movies'));
    }
}
