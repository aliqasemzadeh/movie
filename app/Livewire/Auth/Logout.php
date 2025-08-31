<?php

namespace App\Livewire\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Logout extends Component
{
    /**
     * If the user is not authenticated, send them to the login page immediately.
     */
    public function mount()
    {
        if (! Auth::check()) {
            // If already logged out, just go to login page
            return redirect()->to(route('login'));
        }
    }

    /**
     * Confirm the logout action and terminate the authenticated session.
     */
    public function confirmLogout()
    {
        Auth::logout();

        // Invalidate and regenerate session for security
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Optional: flash a message to show after redirect
        session()->flash('success', __('quickpanel.logged_out'));

        // Redirect to login or home page
        return redirect()->to(route('login'));
    }

    #[Layout('layouts.auth')]
    public function render()
    {
        return view('livewire.auth.logout');
    }
}
