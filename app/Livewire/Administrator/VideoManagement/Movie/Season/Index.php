<?php

namespace App\Livewire\Administrator\VideoManagement\Movie\Season;

use App\Models\VideoSystem\Movie;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Index extends Component
{
    public $movie;

    public function mount($movieId)
    {
        $this->movie = Movie::findOrFail($movieId);
    }

    public function delete($movieId)
    {
        $this->movie->seasons()->where('id', $movieId)->delete();
        Toaster::success(__('quickpanel.season_deleted'));
    }

    #[Layout('layouts.administrator')]
    public function render()
    {
        return view('livewire.administrator.video-management.movie.season.index');
    }
}
