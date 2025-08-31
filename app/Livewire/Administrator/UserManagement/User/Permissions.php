<?php

namespace App\Livewire\Administrator\UserManagement\User;

use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;

class Permissions extends Component
{
    use WithPagination;
    public User $user;
    public $search;
    public bool $open = false;

    #[On('administrator.user-management.user.permissions.assign-data')]
    public function assignData($id): void
    {
        $this->user = User::findOrFail($id);
        $this->open = true;
    }

    public function close(): void
    {
        $this->open = false;
    }

    public function assign(Permission $permission)
    {
        if (!isset($this->user)) {
            return;
        }
        $this->user->givePermissionTo($permission->name);
        $this->dispatch('administrator.user-management.user.permissions');
    }

    public function delete(Permission $permission): void
    {
        if (!isset($this->user)) {
            return;
        }
        $this->user->revokePermissionTo($permission->name);
        $this->dispatch('administrator.user-management.user.permissions');
    }

    #[On('administrator.user-management.user.permissions.render')]
    public function render()
    {
        //$this->authorize('administrator_user_permissions');
        if($this->search != "") {
            $permissions = Permission::where('name', 'like', '%'.$this->search.'%')->paginate(5);
        } else {
            $permissions = Permission::paginate(5);
        }
        return view('livewire.administrator.user-management.user.permissions', compact('permissions'));
    }
}
