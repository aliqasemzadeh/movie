<?php

namespace App\Livewire\Administrator\VideoManagement\Artist;

use App\Models\ViedoSystem\Artist;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Create extends Component
{
    use WithFileUploads;

    public ?int $artistId = null;

    #[Validate('required|string|min:2|unique:artists,name')]
    public string $name = '';

    #[Validate('required|string|alpha_dash|unique:artists,slug')]
    public string $slug = '';

    #[Validate('nullable|string')]
    public ?string $description = null;

    #[Validate('required|mimes:jpg,jpeg|max:2048')]
    public $image;

    public function mount(?int $artistId = null): void
    {
        $this->artistId = $artistId;
    }

    public function create(): void
    {
        $this->validate();

        $manager = new ImageManager(new Driver());
        $image = $manager->read($this->image->getRealPath())
            ->scaleDown(1024, 1024)
            ->toJpg(85);
        $filename = 'artists/' . uniqid('artist_') . '.jpg';
        Storage::disk('public')->put($filename, (string) $image);
        $path = $filename;

        Artist::create([
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $path,
        ]);

        Toaster::success(__('quickpanel.artist_created'));

        $this->dispatch('pg:eventRefresh-administrator.video-management.artist.table');
        $this->dispatch('modal-close');
        $this->reset(['name', 'slug', 'description', 'image']);
    }

    public function render()
    {
        return view('livewire.administrator.video-management.artist.create');
    }
}
