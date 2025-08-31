<?php

namespace App\Livewire\Administrator\UserManagement\Role;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('layouts.administrator')]
    public function render()
    {
        $this->authorize('administrator_user_role_index');
        return view('livewire.administrator.user-management.role.index');
    }
}
