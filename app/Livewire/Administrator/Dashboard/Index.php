<?php

namespace App\Livewire\Administrator\Dashboard;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('layouts.administrator')]
    public function render()
    {
        return view('livewire.administrator.dashboard.index');
    }
}
