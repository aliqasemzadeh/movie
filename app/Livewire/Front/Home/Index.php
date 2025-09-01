<?php

namespace App\Livewire\Front\Home;

use App\Models\VideoSystem\Movie;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public string $q = '';
    public $results = [];
    public bool $hasSearched = false;

    public function search(): void
    {
        $this->hasSearched = true;
        $q = trim($this->q);
        if ($q === '') {
            $this->results = [];
            return;
        }

        $this->results = Movie::query()
            ->select(['id','title','slug','year','image','cover'])
            ->where('title', 'like', "%{$q}%")
            ->orderByDesc('year')
            ->limit(20)
            ->get();
    }

    #[Layout('layouts.front')]
    public function render()
    {
        return view('livewire.front.home.index');
    }
}
