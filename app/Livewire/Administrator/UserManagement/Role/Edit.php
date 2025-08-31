<?php

namespace App\Livewire\Administrator\UserManagement\Role;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Role as SpatieRole;

class Edit extends Component
{
    public int $roleId;
    public string $name = '';
    public string $guard_name = 'web';

    public function mount(int $roleId): void
    {
        $this->roleId = $roleId;
        $role = SpatieRole::findById($roleId);
        $this->name = $role->name;
        $this->guard_name = $role->guard_name;
    }

    public function update(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($this->roleId)],
            'guard_name' => ['required', 'string', 'max:255', 'in:web'],
        ]);

        $role = SpatieRole::findById($this->roleId);
        $role->update([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ]);

        Toaster::success(__('quickpanel.role_edited'));

        $this->dispatch('pg:eventRefresh-administrator.user-management.role.index');
        $this->dispatch('modal-close');
    }

    public function render()
    {
        $this->authorize('administrator_user_role_edit');
        return view('livewire.administrator.user-management.role.edit');
    }
}
