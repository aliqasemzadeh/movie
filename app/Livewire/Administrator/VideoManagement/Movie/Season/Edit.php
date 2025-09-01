<?php

namespace App\Livewire\Administrator\VideoManagement\Movie\Season;

use App\Models\VideoSystem\Movie;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Edit extends Component
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

    public function update()
    {
        $this->validate([
            'title' => 'required|string|min:2',
            'number' => 'required|integer',
            'sort_order' => 'required|integer',
            'slug' => 'required|string|min:2',
            'description' => 'nullable|string',
        ]);
        $this->movie->seasons()->create([
            'title' => $this->title,
            'number' => $this->number,
            'sort_order' => $this->sort_order,
            'slug' => $this->slug,
            'description' => $this->description,
        ]);
        Toaster::success(__('quickpanel.season_created'));
    }

    public function render()
    {
        return view('livewire.administrator.video-management.movie.season.edit');
    }
}
