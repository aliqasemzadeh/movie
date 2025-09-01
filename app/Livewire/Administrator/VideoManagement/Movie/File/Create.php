<?php

namespace App\Livewire\Administrator\VideoManagement\Movie\File;

use App\Models\VideoSystem\Movie;
use App\Models\VideoSystem\MovieFile;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class Create extends Component
{
    use WithFileUploads;
    public $movie;

    public $name;
    public $path;
    public $image;
    public $quality;
    public $custom_quality;
    public $movie_season_id;

    public function mount($movieId)
    {
        $this->movie = Movie::findOrFail($movieId);
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|min:2',
            'path' => 'required|string|min:2',
            'image' => ['nullable','mimes:jpg,jpeg','max:4096'],
            'quality' => 'required|string',
            'custom_quality' => 'nullable|string',
            'movie_season_id' => 'nullable|exists:movie_seasons,id',
        ];
    }

    public function create()
    {
        $validated = $this->validate();

        // Resolve final quality
        $finalQuality = $this->quality === 'other' && $this->custom_quality ? $this->custom_quality : $this->quality;

        $imagePath = null;
        if ($this->image) {
            $filename = 'movie_files/images/' . uniqid('file_') . '.jpg';
            \Illuminate\Support\Facades\Storage::disk('public')->putFileAs('movie_files/images', $this->image, basename($filename));
            $imagePath = $filename;
        }

        $file = $this->movie->files()->create([
            'movie_season_id' => $this->movie_season_id,
            'name' => $this->name,
            'path' => $this->path,
            'image' => $imagePath,
            'quality' => $finalQuality,
        ]);

        // Generate code M{MovieID}S{SeasonID}F{FileID}-Quality
        $seasonId = $this->movie_season_id ?? 0;
        $code = 'M'.$this->movie->id.'S'.$seasonId.'F'.$file->id.'-'.$finalQuality;
        $file->update(['code' => $code]);

        Toaster::success(__('quickpanel.file_created'));
        $this->dispatch('modal-close');
        $this->dispatch('file-created');

        $this->reset(['name','path','image','quality','custom_quality','movie_season_id']);
    }

    public function render()
    {
        $seasons = $this->movie->seasons()->orderBy('sort_order')->orderBy('number')->get();
        $qualities = ['480','720','1024','1080','4K'];
        return view('livewire.administrator.video-management.movie.file.create', compact('seasons','qualities'));
    }
}
