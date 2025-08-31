<?php

namespace App\Livewire\Administrator\UserManagement\User;

use Livewire\Component;
use Livewire\Attributes\Layout;

class Index extends Component
{
    #[Layout('layouts.administrator')]
    public function render()
    {
        return view('livewire.administrator.user-management.user.index');
    }
}
