<?php

namespace App\Livewire\Administrator\VideoManagement\Movie;

use App\Models\VideoSystem\Artist;
use App\Models\VideoSystem\Country;
use App\Models\VideoSystem\Genre;
use App\Models\VideoSystem\Movie;
use Illuminate\Validation\Rule;
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

    public int $movieId;

    #[Validate('required|string|min:2')]
    public string $title = '';

    #[Validate('required|string|alpha_dash')]
    public string $slug = '';

    #[Validate('nullable|string')]
    public ?string $description = null;

    // Optional new uploads
    #[Validate('nullable|mimes:jpg,jpeg|max:4096')]
    public $image;

    #[Validate('nullable|mimes:jpg,jpeg|max:6144')]
    public $cover;

    #[Validate('nullable|string')]
    public ?string $IMDB = null;

    #[Validate('nullable|url')]
    public ?string $IMDB_link = null;

    #[Validate('nullable|url')]
    public ?string $trailer = null;

    #[Validate('nullable|numeric|min:0')]
    public $rank = 0;

    #[Validate('nullable|numeric|min:0')]
    public $year = 0;

    #[Validate('required|integer|min:0')]
    public int $duration = 0;

    #[Validate('required|exists:artists,id')]
    public $director_artist_id;

    #[Validate('required|exists:countries,id')]
    public $country_id;

    #[Validate('array')]
    public array $artist_ids = [];

    #[Validate('array')]
    public array $genre_ids = [];

    public ?string $current_image = null;
    public ?string $current_cover = null;

    public function mount(int $movieId): void
    {
        $this->movieId = $movieId;
        $movie = Movie::with(['artists:id','genres:id'])->findOrFail($movieId);

        $this->title = $movie->title;
        $this->slug = $movie->slug;
        $this->description = $movie->description;
        $this->IMDB = $movie->IMDB;
        $this->IMDB_link = $movie->IMDB_link;
        $this->trailer = $movie->trailer;
        $this->rank = $movie->rank;
        $this->year = $movie->year;
        $this->duration = (int) $movie->duration;
        $this->director_artist_id = $movie->director_artist_id;
        $this->country_id = $movie->country_id;
        $this->current_image = $movie->image;
        $this->current_cover = $movie->cover;
        $this->artist_ids = $movie->artists->pluck('id')->toArray();
        $this->genre_ids = $movie->genres->pluck('id')->toArray();
    }

    public function update(): void
    {
        $this->validate($this->rules());

        $movie = Movie::findOrFail($this->movieId);

        $imagePath = $movie->image;
        $coverPath = $movie->cover;
        if ($this->image) {
            $manager = new ImageManager(new Driver());
            $processedImage = $manager->read($this->image->getRealPath())
                ->cover(1200, 800)
                ->toJpg(85);
            $imagePath = 'movies/images/' . uniqid('img_') . '.jpg';
            Storage::disk('public')->put($imagePath, (string) $processedImage);
            if ($movie->image && Storage::disk('public')->exists($movie->image)) {
                Storage::disk('public')->delete($movie->image);
            }
        }
        if ($this->cover) {
            $processedCover = $manager->read($this->cover->getRealPath())
                ->cover(1200, 600)
                ->toJpg(85);
            $coverPath = 'movies/covers/' . uniqid('cov_') . '.jpg';
            Storage::disk('public')->put($coverPath, (string) $processedCover);
            if ($movie->cover && Storage::disk('public')->exists($movie->cover)) {
                Storage::disk('public')->delete($movie->cover);
            }
        }

        $movie->update([
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image' => $imagePath,
            'cover' => $coverPath,
            'IMDB' => $this->IMDB,
            'IMDB_link' => $this->IMDB_link,
            'trailer' => $this->trailer,
            'rank' => (string) $this->rank,
            'year' => (string) $this->year,
            'duration' => $this->duration,
            'director_artist_id' => $this->director_artist_id,
            'country_id' => $this->country_id,
        ]);

        $validArtistIds = Artist::whereIn('id', $this->artist_ids)->pluck('id')->all();
        $movie->artists()->sync($validArtistIds);
        $validGenreIds = Genre::whereIn('id', $this->genre_ids)->pluck('id')->all();
        $movie->genres()->sync($validGenreIds);

        Toaster::success(__('quickpanel.movie_edited'));
        $this->dispatch('pg:eventRefresh-administrator.video-management.movie.table');
        $this->dispatch('modal-close');
    }

    protected function rules(): array
    {
        return [
            'title' => ['required','string','min:2', Rule::unique('movies','title')->ignore($this->movieId)],
            'slug' => ['required','string','alpha_dash', Rule::unique('movies','slug')->ignore($this->movieId)],
            'description' => ['nullable','string'],
            'image' => ['nullable','mimes:jpg,jpeg','max:4096'],
            'cover' => ['nullable','mimes:jpg,jpeg','max:6144'],
            'IMDB' => ['nullable','string'],
            'IMDB_link' => ['nullable','url'],
            'trailer' => ['nullable','url'],
            'rank' => ['nullable','numeric','min:0'],
            'year' => ['nullable','numeric','min:0'],
            'duration' => ['required','integer','min:0'],
            'director_artist_id' => ['required','exists:artists,id'],
            'country_id' => ['required','exists:countries,id'],
            'artist_ids' => ['array'],
            'artist_ids.*' => ['integer','exists:artists,id'],
            'genre_ids' => ['array'],
            'genre_ids.*' => ['integer','exists:genres,id'],
        ];
    }

    public function render()
    {
        $artists = Artist::orderBy('name')->get(['id','name']);
        $countries = Country::orderBy('name')->get(['id','name']);
        $genres = Genre::orderBy('name')->get(['id','name']);
        return view('livewire.administrator.video-management.movie.edit', compact('artists','countries','genres'));
    }
}
