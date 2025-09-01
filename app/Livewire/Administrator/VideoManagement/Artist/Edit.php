<?php

namespace App\Livewire\Administrator\VideoManagement\Artist;

use App\Models\VideoSystem\Artist;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

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

    #[Validate('nullable|mimes:jpg,jpeg|max:2048')]
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
            'image' => 'nullable|mimes:jpg,jpeg|max:2048',
        ]);

        $artist = Artist::findOrFail($this->artistId);
        $artist->name = $this->name;
        $artist->slug = $this->slug;
        $artist->description = $this->description;

        $oldPath = $artist->image;
        if ($this->image) {
            $manager = new ImageManager(new Driver());
            $encoded = $manager->read($this->image->getRealPath())
                ->scaleDown(1024, 1024)
                ->toJpg(85);
            $newPath = 'artists/' . uniqid('artist_') . '.jpg';
            Storage::disk('public')->put($newPath, (string) $encoded);
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
