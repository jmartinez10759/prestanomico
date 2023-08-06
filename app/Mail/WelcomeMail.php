<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;

class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    private Model $_user;

    private string $_password;

    /**
     * Create a new message instance.
     */
    public function __construct(Model $user, string $password)
    {
        $this->_user     = $user;
        $this->_password = $password;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contraseña de confirmación',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.confirmation',
            with: [
                'company'   => env("APP_NAME"),
                'name'      => $this->_user->name." ".$this->_user->last_name,
                'password'  => $this->_password,
            ],
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
