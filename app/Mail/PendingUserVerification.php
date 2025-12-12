<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\PendingUser;

class PendingUserVerification extends Mailable
{
    use Queueable, SerializesModels;

    public PendingUser $pending;
    public string $verificationUrl;

    public function __construct(PendingUser $pending, string $verificationUrl)
    {
        $this->pending = $pending;
        $this->verificationUrl = $verificationUrl;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Email - Beach & Ocean Clean-up',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.verify-email',
            with: [
                'usr_name' => $this->pending->usr_name,
                'logo' => asset('images/logo_full.png'),
                'verificationUrl' => $this->verificationUrl,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
