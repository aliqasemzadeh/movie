<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $code;
    public int $ttlMinutes;

    public function __construct(string $code, int $ttlMinutes)
    {
        $this->code = $code;
        $this->ttlMinutes = $ttlMinutes;
    }

    public function build(): self
    {
        return $this
            ->subject(trans('quickpanel.email_subject_forgot_password'))
            ->markdown('emails.forgot-password', [
                'code' => $this->code,
                'ttlMinutes' => $this->ttlMinutes,
            ]);
    }
}
