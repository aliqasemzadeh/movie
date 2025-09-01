<?php

namespace App\Livewire\Administrator\VideoManagement\Movie\Season;

use App\Models\VideoSystem\Movie;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Index extends Component
{
    public $movie;
    public $search = '';

    protected $listeners = [
        'season-created' => 'refreshList',
        'season-updated' => 'refreshList',
    ];

    public function mount($movieId)
    {
        $this->movie = Movie::findOrFail($movieId);
    }

    public function refreshList(): void
    {
        // No-op; Livewire will re-render automatically
    }

    public function delete($seasonId)
    {
        $this->movie->seasons()->where('id', $seasonId)->delete();
        Toaster::success(__('quickpanel.season_deleted'));
        $this->dispatch('season-deleted');
    }

    #[Layout('layouts.administrator')]
    public function render()
    {
        $seasons = $this->movie->seasons()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->orderBy('sort_order')
            ->orderBy('number')
            ->orderBy('title')
            ->get();

        return view('livewire.administrator.video-management.movie.season.index', compact('seasons'));
    }
}
