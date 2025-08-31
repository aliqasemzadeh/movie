<?php

namespace App\Livewire\Administrator\UserManagement\Permission;

use Illuminate\Validation\Rule;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Edit extends Component
{
    public int $permissionId;
    public string $name = '';
    public string $guard_name = 'web';

    public function mount(int $permissionId): void
    {
        $this->permissionId = $permissionId;
        $permission = SpatiePermission::findById($permissionId);
        $this->name = $permission->name;
        $this->guard_name = $permission->guard_name;
    }

    public function update(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->ignore($this->permissionId)],
            'guard_name' => ['required', 'string', 'max:255', 'in:web'],
        ]);

        $permission = SpatiePermission::findById($this->permissionId);
        $permission->update([
            'name' => $this->name,
            'guard_name' => $this->guard_name,
        ]);

        Toaster::success(__('quickpanel.permission_edited'));

        $this->dispatch('pg:eventRefresh-administrator.user-management.permission.index');
        $this->dispatch('modal-close');
    }

    public function render()
    {
        $this->authorize('administrator_user_permission_edit');
        return view('livewire.administrator.user-management.permission.edit');
    }
}
