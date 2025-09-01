<?php

namespace App\Livewire\Administrator\VideoManagement\Movie\Season;

use App\Models\VideoSystem\Movie;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Create extends Component
{
    public $title;
    public $number;
    public $sort_order;
    public $slug;
    public $description;
    public $movie;

    public function mount($movieId)
    {
        $this->movie = Movie::findOrFail($movieId);
    }

    public function create()
    {
        $validated = $this->validate([
            'title' => 'required|string|min:2',
            'number' => 'required|integer',
            'sort_order' => 'required|integer',
            'slug' => 'required|string|min:2',
            'description' => 'nullable|string',
        ]);

        $this->movie->seasons()->create($validated);

        Toaster::success(__('quickpanel.season_created'));
        $this->dispatch('modal-close');
        $this->dispatch('season-created');

        // reset fields for next potential create
        $this->reset(['title','number','sort_order','slug','description']);
    }

    public function render()
    {
        return view('livewire.administrator.video-management.movie.season.create');
    }
}
