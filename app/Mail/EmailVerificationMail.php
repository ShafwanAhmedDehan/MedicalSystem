<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $newemailvalidator;

    /**
     * Create a new message instance.
     */
    public function __construct($newemailvalidator)
    {
        $this->newemailvalidator = $newemailvalidator;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Verify your email address')
            ->markdown('auth.email_verification_mail')
            ->with([
                'newemailvalidator' => $this->newemailvalidator,
            ]);
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
