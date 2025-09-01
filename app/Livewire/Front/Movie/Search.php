<?php

namespace App\Livewire\Front\Movie;

use App\Models\VideoSystem\Movie;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Search extends Component
{
    public string $q = '';

    public function getResultsProperty()
    {
        $q = trim($this->q);
        if ($q === '') {
            return collect();
        }
        return Movie::query()
            ->select(['id','title','slug','year','image','cover'])
            ->where('title', 'like', "%{$q}%")
            ->orderByDesc('year')
            ->limit(20)
            ->get();
    }

    #[Layout('layouts.front')]
    public function render()
    {
        return view('livewire.front.movie.search');
    }
}
