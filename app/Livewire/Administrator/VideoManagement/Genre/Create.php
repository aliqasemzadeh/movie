<?php

namespace App\Livewire\Administrator\VideoManagement\Genre;

use App\Models\VideoSystem\Genre;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Create extends Component
{
    public ?int $countryId = null;

    #[Validate('required|string|min:2|unique:genres,name')]
    public string $name = '';

    #[Validate('required|string|alpha_dash|unique:genres,slug')]
    public string $slug = '';

    #[Validate('nullable|string')]
    public ?string $description = null;

    public function mount(?int $countryId = null): void
    {
        $this->countryId = $countryId;
    }

    public function create(): void
    {
        $this->validate();

        Genre::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
        ]);

        Toaster::success(__('quickpanel.genre_created'));

        $this->dispatch('pg:eventRefresh-administrator.video-management.genre.table');
        $this->dispatch('modal-close');
        $this->reset(['name', 'slug', 'description']);
    }

    public function render()
    {
        return view('livewire.administrator.video-management.genre.create');
    }
}
