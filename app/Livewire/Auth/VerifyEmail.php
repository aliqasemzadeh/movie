<?php

namespace App\Livewire\Auth;

use App\Livewire\User\Setting\Profile\Index as ProfileIndex;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class VerifyEmail extends Component
{
    public string $d1 = '';
    public string $d2 = '';
    public string $d3 = '';
    public string $d4 = '';
    public string $d5 = '';
    public string $d6 = '';

    public bool $checkedLink = false;

    public function mount(): void
    {
        // If a signed link was clicked, attempt inline verification
        $token = request()->query('token');
        $uid = (int) request()->query('uid');
        if ($token && $uid) {
            $this->checkedLink = true;
            if (! request()->hasValidSignature()) {
                Toaster::error(__('quickpanel.verification_link_invalid'));
                return;
            }
            $this->verifyUsingToken($uid, (string) $token);
        }
    }

    public function submit(): void
    {
        $code = $this->d1 . $this->d2 . $this->d3 . $this->d4 . $this->d5 . $this->d6;
        if (strlen($code) !== 6 || !ctype_digit($code)) {
            Toaster::error(__('quickpanel.verification_code_required'));
            return;
        }

        $user = Auth::user();
        if (! $user) {
            Toaster::error(__('quickpanel.not_authenticated'));
            return;
        }

        $cacheKey = ProfileIndex::verificationCacheKey($user->id);
        $payload = Cache::get($cacheKey);
        if (! $payload) {
            Toaster::error(__('quickpanel.verification_not_found'));
            return;
        }

        if (time() > (int) ($payload['expires_at'] ?? 0)) {
            Cache::forget($cacheKey);
            Toaster::error(__('quickpanel.verification_code_expired'));
            return;
        }

        if (($payload['code'] ?? null) !== $code) {
            Toaster::error(__('quickpanel.verification_code_invalid'));
            return;
        }

        $this->commitEmailChange($user->id, $payload['new_email'] ?? null, $cacheKey);
    }

    public function resend(): void
    {
        $user = Auth::user();
        if (! $user) {
            Toaster::error(__('quickpanel.not_authenticated'));
            return;
        }
        $cacheKey = ProfileIndex::verificationCacheKey($user->id);
        $payload = Cache::get($cacheKey);
        if (! $payload) {
            Toaster::error(__('quickpanel.verification_nothing_to_resend'));
            return;
        }

        // Simpler approach: just re-put with same code/token but extended expiry
        $ttlMinutes = 30;
        $payload['expires_at'] = now()->addMinutes($ttlMinutes)->timestamp;
        Cache::put($cacheKey, $payload, now()->addMinutes($ttlMinutes));

        // Re-send email using the Mailable used in profile (avoid duplication) by calling the same mail directly
        try {
            $signedUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute('verify-email', now()->addMinutes($ttlMinutes), [
                'token' => $payload['token'],
                'uid' => $user->id,
            ]);
            \Illuminate\Support\Facades\Mail::to($payload['new_email'])->send(new \App\Mail\VerifyNewEmail($user->name, $payload['code'], $signedUrl));
        } catch (\Throwable $e) {
            Toaster::error(__('quickpanel.verification_email_resend_failed'));
            return;
        }
        Toaster::success(__('quickpanel.verification_email_resent'));
    }

    protected function verifyUsingToken(int $uid, string $token): void
    {
        $user = Auth::user();
        if (! $user || $user->id !== $uid) {
            Toaster::error(__('quickpanel.verification_link_session_mismatch'));
            return;
        }
        $cacheKey = ProfileIndex::verificationCacheKey($uid);
        $payload = Cache::get($cacheKey);
        if (! $payload) {
            Toaster::error(__('quickpanel.verification_not_found'));
            return;
        }
        if (($payload['token'] ?? null) !== $token) {
            Toaster::error(__('quickpanel.verification_token_invalid'));
            return;
        }
        if (time() > (int) ($payload['expires_at'] ?? 0)) {
            Cache::forget($cacheKey);
            Toaster::error(__('quickpanel.verification_link_expired'));
            return;
        }
        $this->commitEmailChange($uid, $payload['new_email'] ?? null, $cacheKey);
    }

    protected function commitEmailChange(int $userId, ?string $newEmail, string $cacheKey): void
    {
        if (! $newEmail) {
            Toaster::error(__('quickpanel.pending_email_missing'));
            return;
        }
        $user = Auth::user();
        if (! $user || $user->id !== $userId) {
            Toaster::error(__('quickpanel.not_authenticated'));
            return;
        }
        $user->email = $newEmail;
        $user->email_verified_at = now();
        $user->save();
        Cache::forget($cacheKey);

        Toaster::success(__('quickpanel.email_verified_and_updated'));
        redirect()->route('user.dashboard.index')->send();
    }

    #[Layout('layouts.auth')]
    public function render()
    {
        return view('livewire.auth.verify-email');
    }
}
