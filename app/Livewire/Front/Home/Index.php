<?php

namespace App\Livewire\Front\Home;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('layouts.front')]
    public function render()
    {
        return view('livewire.front.home.index');
    }
}
