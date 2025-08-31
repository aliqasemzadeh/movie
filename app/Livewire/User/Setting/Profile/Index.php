<?php

namespace App\Livewire\User\Setting\Profile;

use App\Mail\VerifyNewEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Index extends Component
{
    public string $name = '';
    public string $email = '';

    // Delete confirmation modal state and password input
    public bool $confirmingDeletion = false;
    public string $delete_password = '';

    public function mount(): void
    {
        $user = Auth::user();
        if ($user) {
            $this->name = (string) $user->name;
            $this->email = (string) $user->email;
        } else {
            // No authenticated user; redirect to login
            redirect()->route('login')->send();
        }
    }

    protected function rules(): array
    {
        $userId = Auth::id();
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'delete_password' => ['nullable', 'string'],
        ];
    }

    public function update(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore(Auth::id()),
            ],
        ]);

        $user = Auth::user();
        if (! $user) {
            Toaster::error(__('quickpanel.not_authenticated') ?? 'Not authenticated.');
            redirect()->route('login')->send();
            return;
        }

        $emailChanged = $validated['email'] !== $user->email;

        // Always allow name change
        $user->name = $validated['name'];

        if (! $emailChanged) {
            // No email change, just save
            $user->save();
            Toaster::success(__('quickpanel.updated_at') ?? __('quickpanel.update') ?? 'Updated');
            return;
        }

        // Email changed: do NOT change it yet. Initiate verification flow.
        // Persist a pending verification package in cache to avoid schema changes (minimal change approach).
        $code = (string) str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $token = (string) Str::uuid();
        $ttlMinutes = 30;
        $cacheKey = self::verificationCacheKey($user->id);

        $payload = [
            'new_email' => $validated['email'],
            'code' => $code,
            'token' => $token,
            'expires_at' => now()->addMinutes($ttlMinutes)->timestamp,
        ];
        Cache::put($cacheKey, $payload, now()->addMinutes($ttlMinutes));

        // Generate a temporary signed route for link verification
        $signedUrl = URL::temporarySignedRoute('verify-email', now()->addMinutes($ttlMinutes), [
            'token' => $token,
            'uid' => $user->id,
        ]);

        try {
            Mail::to($validated['email'])->send(new VerifyNewEmail($user->name, $code, $signedUrl));
        } catch (\Throwable $e) {
            Toaster::error(__('quickpanel.verification_email_send_failed'));
            return;
        }

        // Save only the name change for now
        $user->save();

        Toaster::success(__('quickpanel.verification_email_sent'));
        redirect()->route('verify-email')->send();
    }

    public static function verificationCacheKey(int $userId): string
    {
        return 'email_verification:user:' . $userId;
    }

    public function openDeleteModal(): void
    {
        $this->resetValidation(['delete_password']);
        $this->delete_password = '';
        $this->confirmingDeletion = true;
    }

    public function closeDeleteModal(): void
    {
        $this->confirmingDeletion = false;
    }

    public function deleteAccount(): void
    {
        // Validate that password is provided
        $this->validate([ 'delete_password' => ['required', 'string'] ]);

        $user = Auth::user();
        if (! $user) {
            Toaster::error(__('quickpanel.invalid_current_password'));
            redirect()->route('login')->send();
            return;
        }

        if (! Hash::check($this->delete_password, $user->password)) {
            Toaster::error(__('quickpanel.invalid_current_password'));
            return;
        }

        // Log out the user before deletion to avoid stale session issues
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        // Delete the account
        try {
            $user->delete();
        } catch (\Throwable $e) {
            // If soft deletes or constraints fail, show an error
            Toaster::error(__('quickpanel.not_translated') ?? 'Unable to delete account.');
            return;
        }

        // Close modal and redirect
        $this->confirmingDeletion = false;
        Toaster::success(__('quickpanel.user_deleted') ?? 'Account deleted.');

        redirect()->route('home')->send();
    }

    #[Layout('layouts.user')]
    public function render()
    {
        return view('livewire.user.setting.profile.index');
    }
}
