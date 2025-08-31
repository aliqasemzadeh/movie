<?php

namespace App\Livewire\User\Setting\Password;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Index extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected function rules(): array
    {
        return [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function update(): void
    {
        $validated = $this->validate();

        $user = Auth::user();
        if (! $user) {
            // If no authenticated user, redirect to login
            Toaster::error(__('quickpanel.invalid_current_password'));
            redirect()->route('login')->send();
            return;
        }

        if (! Hash::check($validated['current_password'], $user->password)) {
            Toaster::error(__('quickpanel.invalid_current_password'));
            return;
        }

        // Prevent re-using the same password
        if (Hash::check($validated['password'], $user->password)) {
            Toaster::error(__('quickpanel.password_same_as_old'));
            return;
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        // Reset fields after success
        $this->reset(['current_password', 'password', 'password_confirmation']);

        Toaster::success(__('quickpanel.password_changed_successfully'));
    }

    #[Layout('layouts.user')]
    public function render()
    {
        return view('livewire.user.setting.password.index');
    }
}
