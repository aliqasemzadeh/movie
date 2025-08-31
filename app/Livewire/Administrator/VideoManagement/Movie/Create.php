<?php

namespace App\Livewire\Administrator\VideoManagement\Movie;

use App\Models\ViedoSystem\Movie;
use App\Models\ViedoSystem\Artist;
use App\Models\ViedoSystem\Country;
use App\Models\ViedoSystem\Genre;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class Create extends Component
{
    use WithFileUploads;

    #[Validate('required|string|min:2|unique:movies,title')]
    public string $title = '';

    #[Validate('required|string|alpha_dash|unique:movies,slug')]
    public string $slug = '';

    #[Validate('nullable|string')]
    public ?string $description = null;

    // jpg with 3:2 ratio
    #[Validate('required|image|mimes:jpg,jpeg|dimensions:ratio=3/2|max:4096')]
    public $image;

    // jpg with 2:1 ratio
    #[Validate('required|image|mimes:jpg,jpeg|dimensions:ratio=2/1|max:6144')]
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
        $this->validate();

        $imagePath = $this->image->store('movies/images', 'public');
        $coverPath = $this->cover->store('movies/covers', 'public');

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
            $movie->artists()->sync($this->artist_ids);
        }
        if (!empty($this->genre_ids)) {
            $movie->genres()->sync($this->genre_ids);
        }

        Toaster::success(__('quickpanel.movie_created'));
        $this->dispatch('pg:eventRefresh-administrator.video-management.movie.table');
        $this->dispatch('modal-close');

        $this->reset([
            'title','slug','description','image','cover','IMDB','IMDB_link','trailer','rank','year','duration','director_artist_id','country_id','artist_ids','genre_ids'
        ]);
    }

    public function render()
    {
        $artists = Artist::orderBy('name')->get(['id','name']);
        $countries = Country::orderBy('name')->get(['id','name']);
        $genres = Genre::orderBy('name')->get(['id','name']);
        return view('livewire.administrator.video-management.movie.create', compact('artists','countries','genres'));
    }
}
