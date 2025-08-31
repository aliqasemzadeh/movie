<?php

namespace App\Livewire\Administrator\UserManagement\Role;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Role;

class Create extends Component
{
    public string $name = '';
    public string $guard_name = 'web';

    public function create(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'guard_name' => ['required', 'string', 'max:255', 'in:web'],
        ]);

        Role::create($validated);

        Toaster::success(__('quickpanel.role_created'));

        $this->dispatch('pg:eventRefresh-administrator.user-management.role.index');
        $this->dispatch('modal-close');

        $this->reset(['name', 'guard_name']);
    }

    public function render()
    {
        $this->authorize('administrator_user_role_create');
        return view('livewire.administrator.user-management.role.create');
    }
}
