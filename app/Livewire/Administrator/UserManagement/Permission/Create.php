<?php

namespace App\Livewire\Administrator\UserManagement\Permission;

use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Permission;

class Create extends Component
{
    public string $name = '';
    public string $guard_name = 'web';

    public function create(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions,name'],
            'guard_name' => ['required', 'string', 'max:255', 'in:web'],
        ]);

        Permission::create($validated);

        Toaster::success(__('quickpanel.permission_created'));

        // Refresh the permission table
        $this->dispatch('pg:eventRefresh-administrator.user-management.permission.index');

        // Close modal using livewire-modal event system
        $this->dispatch('modal-close');

        // Reset form
        $this->reset(['name', 'guard_name']);
    }

    public function render()
    {
        $this->authorize('administrator_user_permission_create');
        return view('livewire.administrator.user-management.permission.create');
    }
}
