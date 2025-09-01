<?php

namespace App\Livewire\Administrator\VideoManagement\Movie\File;

use App\Models\VideoSystem\Movie;
use App\Models\VideoSystem\MovieFile;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Masmerise\Toaster\Toaster;

class Edit extends Component
{
    use WithFileUploads;
    public $movie;
    public $file;

    public $name;
    public $path;
    public $image;
    public $quality;
    public $custom_quality;
    public $movie_season_id;

    public function mount($movieId, $fileId)
    {
        $this->movie = Movie::findOrFail($movieId);
        $this->file = MovieFile::where('movie_id', $this->movie->id)->findOrFail($fileId);

        $this->name = $this->file->name;
        $this->path = $this->file->path;
        // Do not prefill with string because this field is now a file upload. Keep existing path in $this->file->image
        $this->image = null;
        $this->quality = $this->file->quality;
        $this->movie_season_id = $this->file->movie_season_id;
        $this->custom_quality = null;
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

    public function update()
    {
        $validated = $this->validate();

        // Determine final quality value
        $finalQuality = $this->quality === 'other' && $this->custom_quality ? $this->custom_quality : $this->quality;

        $newImagePath = $this->file->image; // default keep old
        if ($this->image) {
            // upload new and delete old
            $filename = 'movie_files/images/' . uniqid('file_') . '.jpg';
            Storage::disk('public')->putFileAs('movie_files/images', $this->image, basename($filename));
            if ($this->file->image && Storage::disk('public')->exists($this->file->image)) {
                Storage::disk('public')->delete($this->file->image);
            }
            $newImagePath = $filename;
        }

        $this->file->update([
            'movie_season_id' => $this->movie_season_id,
            'name' => $this->name,
            'path' => $this->path,
            'image' => $newImagePath,
            'quality' => $finalQuality,
        ]);

        // clear uploaded image after modify per requirement
        $this->image = null;

        // Regenerate code M{MovieID}S{SeasonID}F{FileID}-Quality
        $seasonId = $this->movie_season_id ?? 0;
        $code = 'M'.$this->movie->id.'S'.$seasonId.'F'.$this->file->id.'-'.$finalQuality;
        $this->file->update(['code' => $code]);

        Toaster::success(__('quickpanel.file_edited'));
        $this->dispatch('modal-close');
        $this->dispatch('file-updated');
    }

    public function render()
    {
        $seasons = $this->movie->seasons()->orderBy('sort_order')->orderBy('number')->get();
        $qualities = ['480','720','1024','1080','4K'];
        return view('livewire.administrator.video-management.movie.file.edit', compact('seasons','qualities'));
    }
}
