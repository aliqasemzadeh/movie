<?php

namespace App\Livewire\Administrator\VideoManagement\Artist;

use App\Models\ViedoSystem\Artist;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class Edit extends Component
{
    use WithFileUploads;

    public int $artistId;

    #[Validate('required|string|min:2')]
    public string $name = '';

    #[Validate('required|string|alpha_dash')]
    public string $slug = '';

    #[Validate('nullable|string')]
    public ?string $description = null;

    #[Validate('nullable|image|mimes:jpg,jpeg|dimensions:width=1024,height=1024|max:2048')]
    public $image;

    public string $currentImage = '';

    public function mount(int $artistId): void
    {
        $this->artistId = $artistId;
        $artist = Artist::findOrFail($artistId);
        $this->name = $artist->name;
        $this->slug = $artist->slug;
        $this->description = $artist->description;
        $this->currentImage = $artist->image ?? '';
    }

    public function update(): void
    {
        $this->validate([
            'name' => 'required|string|min:2|unique:artists,name,' . $this->artistId,
            'slug' => 'required|string|alpha_dash|unique:artists,slug,' . $this->artistId,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg|dimensions:width=1024,height=1024|max:2048',
        ]);

        $artist = Artist::findOrFail($this->artistId);
        $artist->name = $this->name;
        $artist->slug = $this->slug;
        $artist->description = $this->description;

        $oldPath = $artist->image;
        if ($this->image) {
            $newPath = $this->image->store('artists', 'public');
            $artist->image = $newPath;
        }

        $artist->save();

        if (isset($newPath) && $oldPath && $oldPath !== $newPath) {
            Storage::disk('public')->delete($oldPath);
        }

        Toaster::success(__('quickpanel.artist_edited'));

        $this->dispatch('pg:eventRefresh-administrator.video-management.artist.table');
        $this->dispatch('modal-close');
    }

    public function render()
    {
        return view('livewire.administrator.video-management.artist.edit');
    }
}
