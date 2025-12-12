<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

class CustomVerifyEmail extends VerifyEmail
{
    /**
     * Generate the verification URL.
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'verification.verify', // route name
            Carbon::now()->addMinutes(60), // link expires in 60 mins
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ]
        );
    }

    /**
     * Build the email message.
     */
    public function toMail($notifiable){
    $url = $this->verificationUrl($notifiable);

    return (new MailMessage)
        ->subject('Verify Your Email Address - Beach & Ocean Clean-up')
        ->markdown('emails.verify-email', [
            'verificationUrl' => $url,
            'userName' => $notifiable->usr_name,
            'logo' => asset('images/logo_full.png'),
        ]);
    }


}
