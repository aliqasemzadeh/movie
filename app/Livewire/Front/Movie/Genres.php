<?php

namespace App\Livewire\Front\Movie;

use App\Models\VideoSystem\Genre as GenreModel;
use Livewire\Component;

class Genres extends Component
{
    public string $search = '';

    public function getItemsProperty()
    {
        return GenreModel::query()
            ->when($this->search !== '', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderBy('name')
            ->limit(100)
            ->get(['name','slug']);
    }

    public function render()
    {
        return view('livewire.front.movie.genres', [
            'items' => $this->items,
        ]);
    }
}
