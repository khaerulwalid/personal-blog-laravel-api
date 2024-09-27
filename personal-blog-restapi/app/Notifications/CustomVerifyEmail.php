<?php

// app/Notifications/CustomVerifyEmail.php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailNotification;
use Illuminate\Notifications\Messages\MailMessage;

class CustomVerifyEmail extends VerifyEmailNotification
{
    public function toMail($notifiable)
    {
        $url = $this->verificationUrl($notifiable);

        return (new MailMessage)
            ->subject('Verify Your Email Address')
            ->view('emails.verify', ['user' => $notifiable, 'verificationUrl' => $url]);
    }
}
