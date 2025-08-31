<?php

namespace App\Livewire\Auth;

use App\Mail\PasswordChangedAlertMail;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ChangePassword extends Component
{
    public string $email = '';
    public string $code = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'code' => ['required', 'string', 'size:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function change(): void
    {
        $validated = $this->validate();
        $cacheKey = $this->cacheKey($validated['email']);
        $storedCode = Cache::get($cacheKey);

        if (! $storedCode || $storedCode !== $validated['code']) {
            Toaster::error(__('quickpanel.invalid_reset_code'));
            return;
        }

        $user = User::where('email', $validated['email'])->first();
        if (! $user) {
            // For security, treat as invalid without revealing whether user exists
            Toaster::error(__('quickpanel.invalid_reset_code'));
            return;
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        // Invalidate the code
        Cache::forget($cacheKey);

        // Send alert email
        try {
            Mail::to($user->email)->send(new PasswordChangedAlertMail());
        } catch (\Throwable $e) {
            // Non-blocking: still show success
        }

        Toaster::success(__('quickpanel.password_changed_successfully'));

        // Optionally redirect to login
        redirect()->route('login')->send();
    }

    private function cacheKey(string $email): string
    {
        return 'pwd_reset:' . strtolower(trim($email));
    }

    #[Layout('layouts.auth')]
    public function render()
    {
        return view('livewire.auth.change-password');
    }
}
