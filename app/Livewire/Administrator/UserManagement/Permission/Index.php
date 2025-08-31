<?php

namespace App\Livewire\Administrator\UserManagement\Permission;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('layouts.administrator')]
    public function render()
    {
        return view('livewire.administrator.user-management.permission.index');
    }
}
