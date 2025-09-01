<?php

namespace App\Livewire\Administrator\VideoManagement\Movie;

use App\Models\VideoSystem\Movie;
use App\Models\VideoSystem\Artist;
use App\Models\VideoSystem\Country;
use App\Models\VideoSystem\Genre;
use Illuminate\Validation\Rule;
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

    #[Validate('required|string|min:2|unique:movies,title')]
    public string $title = '';

    #[Validate('required|string|alpha_dash|unique:movies,slug')]
    public string $slug = '';

    #[Validate('nullable|string')]
    public ?string $description = null;

    // jpg only; we'll enforce ratio and size via Intervention/Image
    #[Validate('required|mimes:jpg,jpeg|max:4096')]
    public $image;

    // jpg only; we'll enforce ratio and size via Intervention/Image
    #[Validate('required|mimes:jpg,jpeg|max:6144')]
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

    // minutes
    #[Validate('required|integer|min:0')]
    public int $duration = 0;

    #[Validate('required|exists:artists,id')]
    public $director_artist_id;

    #[Validate('required|exists:countries,id')]
    public $country_id;

    // Optional many-to-many
    #[Validate('array')]
    public array $artist_ids = [];

    #[Validate('array')]
    public array $genre_ids = [];

    public function create(): void
    {
        $this->validate($this->rules());

        $manager = new ImageManager(new Driver());

        $processedImage = $manager->read($this->image->getRealPath())
            ->cover(1200, 800) // enforce 3:2 ratio
            ->toJpg(85);
        $imageFilename = 'movies/images/' . uniqid('img_') . '.jpg';
        Storage::disk('public')->put($imageFilename, (string) $processedImage);
        $imagePath = $imageFilename;

        $processedCover = $manager->read($this->cover->getRealPath())
            ->cover(1200, 600) // enforce 2:1 ratio
            ->toJpg(85);
        $coverFilename = 'movies/covers/' . uniqid('cov_') . '.jpg';
        Storage::disk('public')->put($coverFilename, (string) $processedCover);
        $coverPath = $coverFilename;

        $movie = Movie::create([
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

        if (!empty($this->artist_ids)) {
            $validArtistIds = Artist::whereIn('id', $this->artist_ids)->pluck('id')->all();
            $movie->artists()->sync($validArtistIds);
        }
        if (!empty($this->genre_ids)) {
            $validGenreIds = Genre::whereIn('id', $this->genre_ids)->pluck('id')->all();
            $movie->genres()->sync($validGenreIds);
        }

        Toaster::success(__('quickpanel.movie_created'));
        $this->dispatch('pg:eventRefresh-administrator.video-management.movie.table');
        $this->dispatch('modal-close');

        $this->reset([
            'title','slug','description','image','cover','IMDB','IMDB_link','trailer','rank','year','duration','director_artist_id','country_id','artist_ids','genre_ids'
        ]);
    }

    protected function rules(): array
    {
        return [
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
        return view('livewire.administrator.video-management.movie.create', compact('artists','countries','genres'));
    }
}
