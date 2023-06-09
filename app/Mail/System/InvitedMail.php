<?php

namespace App\Mail\System;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InvitedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $url,
        public string $email,
        public string $role,
        public string $company_id,
        public string $tenant_id,
        public string $expiration
    ) {
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                address: 'no-reply@'.config('app.domain'),
                name: config('app.name'),
            ),
            subject: 'Convite para o sistema',
            metadata: [
                'tenant_id' => $this->tenant_id,
                'company_id' => $this->company_id,
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'mail.system.invited-mail',
            with: [
                'url' => $this->url,
                'role' => $this->role,
                'expiration' => $this->expiration,
                //                'company' => Company::find($this->company_id)
            ],
        );
    }
}
