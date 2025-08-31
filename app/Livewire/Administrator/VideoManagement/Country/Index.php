<?php

namespace App\Livewire\Administrator\VideoManagement\Country;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('layouts.administrator')]
    public function render()
    {
        return view('livewire.administrator.video-management.country.index');
    }
}
