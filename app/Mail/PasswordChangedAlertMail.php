<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordChangedAlertMail extends Mailable
{
    use Queueable, SerializesModels;

    public function build(): self
    {
        return $this
            ->subject(trans('quickpanel.email_subject_password_changed'))
            ->markdown('emails.password-changed');
    }
}
