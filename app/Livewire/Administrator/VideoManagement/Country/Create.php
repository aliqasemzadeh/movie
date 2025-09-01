<?php

namespace App\Livewire\Administrator\VideoManagement\Country;

use App\Models\VideoSystem\Country;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Create extends Component
{
    #[Validate('required|string|min:2|unique:countries,name')]
    public string $name = '';

    #[Validate('required|string|alpha_dash|unique:countries,slug')]
    public string $slug = '';

    #[Validate('nullable|string')]
    public ?string $description = null;

    public function create(): void
    {
        $this->validate();

        Country::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
        ]);

        Toaster::success(__('quickpanel.country_created'));

        // Refresh table
        $this->dispatch('pg:eventRefresh-administrator.video-management.country.table');
        // Close modal
        $this->dispatch('modal-close');
        // Reset
        $this->reset(['name', 'slug', 'description']);
    }

    public function render()
    {
        return view('livewire.administrator.video-management.country.create');
    }
}
