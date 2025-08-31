<?php

namespace App\Livewire\Administrator\VideoManagement\Genre;

use App\Models\ViedoSystem\Genre;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Edit extends Component
{
    public int $genreId;


    #[Validate('required|string|min:2')]
    public string $name = '';

    #[Validate('required|string|alpha_dash')]
    public string $slug = '';

    #[Validate('nullable|string')]
    public ?string $description = null;

    public function mount(int $genreId): void
    {
        $this->genreId = $genreId;
        $genre = Genre::findOrFail($genreId);
        $this->name = $genre->name;
        $this->slug = $genre->slug;
        $this->description = $genre->description;
    }

    public function update(): void
    {
        $this->validate([
            'name' => 'required|string|min:2|unique:genres,name,' . $this->genreId,
            'slug' => 'required|string|alpha_dash|unique:genres,slug,' . $this->genreId,
            'description' => 'nullable|string',
        ]);

        $genre = Genre::findOrFail($this->genreId);
        $genre->name = $this->name;
        $genre->slug = $this->slug;
        $genre->description = $this->description;
        $genre->save();

        Toaster::success(__('quickpanel.genre_edited'));

        $this->dispatch('pg:eventRefresh-administrator.video-management.genre.table');
        $this->dispatch('modal-close');
    }

    public function render()
    {
        return view('livewire.administrator.video-management.genre.edit');
    }
}
