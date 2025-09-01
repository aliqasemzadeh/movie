<?php

namespace App\Livewire\Administrator\VideoManagement\Movie\File;

use App\Models\VideoSystem\Movie;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Index extends Component
{
    public $movie;
    public $search = '';

    protected $listeners = [
        'file-created' => 'refreshList',
        'file-updated' => 'refreshList',
    ];

    public function mount($movieId)
    {
        $this->movie = Movie::findOrFail($movieId);
    }

    public function refreshList(): void
    {
        // Livewire will re-render automatically
    }

    public function delete($fileId)
    {
        $this->movie->files()->where('id', $fileId)->delete();
        Toaster::success(__('quickpanel.file_deleted'));
        $this->dispatch('file-deleted');
    }

    #[Layout('layouts.administrator')]
    public function render()
    {
        $files = $this->movie->files()
            ->when($this->search, function ($q) {
                $term = "%{$this->search}%";
                $q->where(function($qq) use ($term) {
                    $qq->where('name', 'like', $term)
                       ->orWhere('path', 'like', $term)
                       ->orWhere('quality', 'like', $term)
                       ->orWhere('code', 'like', $term);
                });
            })
            ->with('season')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.administrator.video-management.movie.file.index', compact('files'));
    }
}
