<?php

namespace App\Livewire\Front\Movie;

use App\Models\VideoSystem\Genre as GenreModel;
use App\Models\VideoSystem\Movie;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Genre extends Component
{
    use WithPagination;

    #[Layout('layouts.front')]
    public string $slug;
    public ?GenreModel $genre = null;

    public function mount(string $slug)
    {
        $this->slug = $slug;
        $this->genre = GenreModel::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        $movies = Movie::whereHas('genres', fn($q) => $q->where('slug', $this->slug))
            ->paginate(40);

        return view('livewire.front.movie.genre', compact('movies'))
            ->with('title', $this->genre?->name);
    }
}
