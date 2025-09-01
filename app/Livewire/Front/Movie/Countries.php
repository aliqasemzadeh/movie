<?php

namespace App\Livewire\Front\Movie;

use App\Models\VideoSystem\Country as CountryModel;
use Livewire\Component;

class Countries extends Component
{
    public string $search = '';

    public function getItemsProperty()
    {
        return CountryModel::query()
            ->when($this->search !== '', fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderBy('name')
            ->limit(100)
            ->get(['name','slug']);
    }

    public function render()
    {
        return view('livewire.front.movie.countries', [
            'items' => $this->items,
        ]);
    }
}
