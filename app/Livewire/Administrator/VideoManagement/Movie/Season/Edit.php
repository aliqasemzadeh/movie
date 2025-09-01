<?php

namespace App\Livewire\Administrator\VideoManagement\Movie\Season;

use App\Models\VideoSystem\Movie;
use App\Models\VideoSystem\MovieSeason as MovieSeasonModel;
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
    public $season;

    public function mount($movieId, $seasonId)
    {
        $this->movie = Movie::findOrFail($movieId);
        $this->season = MovieSeasonModel::where('id', $seasonId)->where('movie_id', $this->movie->id)->firstOrFail();

        $this->title = $this->season->title;
        $this->number = $this->season->number;
        $this->sort_order = $this->season->sort_order;
        $this->slug = $this->season->slug;
        $this->description = $this->season->description;
    }

    public function update()
    {
        $validated = $this->validate([
            'title' => 'required|string|min:2',
            'number' => 'required|integer',
            'sort_order' => 'required|integer',
            'slug' => 'required|string|min:2',
            'description' => 'nullable|string',
        ]);

        $this->season->update($validated);

        Toaster::success(__('quickpanel.season_edited'));
        $this->dispatch('modal-close');
        $this->dispatch('season-updated');
    }

    public function render()
    {
        return view('livewire.administrator.video-management.movie.season.edit');
    }
}
