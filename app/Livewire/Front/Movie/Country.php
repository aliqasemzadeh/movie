<?php

namespace App\Livewire\Front\Movie;

use App\Models\VideoSystem\Country as CountryModel;
use App\Models\VideoSystem\Movie;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Country extends Component
{
    use WithPagination;

    #[Layout('layouts.front')]
    public string $slug;
    public ?CountryModel $country = null;

    public function mount(string $slug)
    {
        $this->slug = $slug;
        $this->country = CountryModel::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        $movies = Movie::whereHas('country', fn($q) => $q->where('slug', $this->slug))
            ->paginate(40);

        return view('livewire.front.movie.country', compact('movies'))
            ->with('title', $this->country?->name);
    }
}
