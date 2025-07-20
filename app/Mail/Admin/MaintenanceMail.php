<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MaintenanceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $mail_subject;
    public $mail_body;
    public $secret_key;

    /**
     * Create a new message instance.
     */
    public function __construct($mail_subject,$mail_body,$secret_key)
    {
        $this->mail_subject = $mail_subject;
        $this->mail_body = $mail_body;
        $this->secret_key = $secret_key;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mail_subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'backend.mail.maintenance_mail',
        );
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
