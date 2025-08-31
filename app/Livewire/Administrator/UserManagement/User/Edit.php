<?php

namespace App\Livewire\Administrator\UserManagement\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Edit extends Component
{
    public int $userId;

    #[Validate('required|string|min:3')]
    public string $name = '';

    #[Validate('required|email|unique:users,email,{{userId}}')]
    public string $email = '';

    // Optional password change
    #[Validate('nullable|string|min:6|confirmed')]
    public ?string $password = null;

    public ?string $password_confirmation = null;

    public function mount(int $userId): void
    {
        $this->userId = $userId;
        $user = User::findOrFail($userId);
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function update(): void
    {
        // Handle unique email for this user
        $this->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user = User::findOrFail($this->userId);
        $user->name = $this->name;
        $user->email = $this->email;
        if (!empty($this->password)) {
            $user->password = Hash::make($this->password);
        }
        $user->save();

        // Required by issue: use this exact message key
        Toaster::success( __('quickpanel.user_edited'));
        // Refresh the users table
        $this->dispatch('pg:eventRefresh-administrator.user-management.user.table');

        $this->dispatch('modal-close');
    }

    public function render()
    {
        return view('livewire.administrator.user-management.user.edit');
    }
}
