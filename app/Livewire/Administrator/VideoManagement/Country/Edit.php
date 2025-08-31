<?php

namespace App\Livewire\Administrator\VideoManagement\Country;

use App\Models\ViedoSystem\Country;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Edit extends Component
{
    public int $countryId;

    #[Validate('required|string|min:2')]
    public string $name = '';

    #[Validate('required|string|alpha_dash')]
    public string $slug = '';

    #[Validate('nullable|string')]
    public ?string $description = null;

    public function mount(int $countryId): void
    {
        $this->countryId = $countryId;
        $country = Country::findOrFail($countryId);
        $this->name = $country->name;
        $this->slug = $country->slug;
        $this->description = $country->description;
    }

    public function update(): void
    {
        // Override unique rules to ignore current record
        $this->validate([
            'name' => 'required|string|min:2|unique:countries,name,' . $this->countryId,
            'slug' => 'required|string|alpha_dash|unique:countries,slug,' . $this->countryId,
            'description' => 'nullable|string',
        ]);

        $country = Country::findOrFail($this->countryId);
        $country->name = $this->name;
        $country->slug = $this->slug;
        $country->description = $this->description;
        $country->save();

        Toaster::success(__('quickpanel.country_edited'));

        $this->dispatch('pg:eventRefresh-administrator.video-management.country.table');
        $this->dispatch('modal-close');
    }

    public function render()
    {
        return view('livewire.administrator.video-management.country.edit');
    }
}
