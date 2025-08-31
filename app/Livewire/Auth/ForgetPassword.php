<?php

namespace App\Livewire\Auth;

use App\Mail\ForgotPasswordCodeMail;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ForgetPassword extends Component
{
    public string $email = '';

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function sendCode(): void
    {
        $validated = $this->validate();

        $user = User::where('email', $validated['email'])->first();

        // For security, do not reveal whether the email exists. Proceed similarly either way.
        $code = (string) random_int(100000, 999999);
        $ttlMinutes = 15;
        $cacheKey = $this->cacheKey($validated['email']);
        Cache::put($cacheKey, $code, now()->addMinutes($ttlMinutes));

        try {
            if ($user) {
                Mail::to($user->email)->send(new ForgotPasswordCodeMail($code, $ttlMinutes));
            }
            Toaster::success(__('quickpanel.forgot_password_email_sent'));
        } catch (\Throwable $e) {
            Toaster::error(__('quickpanel.email_send_failed'));
        }

        // Keep email in the input to allow resending if needed.
    }

    private function cacheKey(string $email): string
    {
        return 'pwd_reset:' . strtolower(trim($email));
    }

    #[Layout('layouts.auth')]
    public function render()
    {
        return view('livewire.auth.forget-password');
    }
}
