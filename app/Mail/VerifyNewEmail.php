<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyNewEmail extends Mailable
{
    use Queueable, SerializesModels;

    public string $username;
    public string $code;
    public string $link;

    public function __construct(string $username, string $code, string $link)
    {
        $this->username = $username;
        $this->code = $code;
        $this->link = $link;
    }

    public function build(): self
    {
        return $this->subject('Verify your new email address')
            ->markdown('emails.verify-new-email', [
                'username' => $this->username,
                'code' => $this->code,
                'link' => $this->link,
            ]);
    }
}
