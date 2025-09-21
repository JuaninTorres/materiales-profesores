<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

class ContactFormSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            replyTo: [
                new Address($this->data['email'], $this->data['name']),
            ],
            subject: 'Nuevo contacto: ' . ($this->data['subject'] ?? 'Mensaje'),
        );
    }

    public function content(): Content
    {
        // Usa la vista markdown creada por --markdown
        return new Content(
            markdown: 'mail.contact-submitted',
        );
    }
}
