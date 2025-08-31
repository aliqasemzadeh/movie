<?php

namespace App\Livewire\Front\Faq;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('layouts.front')]
    public function render()
    {
        return view('livewire.front.faq.index');
    }
}
