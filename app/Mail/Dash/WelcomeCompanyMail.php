<?php

namespace App\Mail\Dash;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeCompanyMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $url;

    /**
     * Create a new message instance.
     */
    public function __construct(public string $companyName, public User $user, public string $password)
    {
        $this->url = route('login');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                address: config('mail.from.address'),
                name: config('app.name'),
            ),
            replyTo: $this->user->company->email,
            subject: 'Bem vindo a '.$this->companyName,
            metadata: [
                'company_id' => $this->user->company->id,
                'user_id' => $this->user->id,
            ],

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.dash.welcome-company-mail',
            with: [
                'url' => $this->url,
                'password' => $this->password,
                'user' => $this->user,
                'companyName' => $this->companyName,
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
