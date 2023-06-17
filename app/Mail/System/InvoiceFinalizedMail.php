<?php

namespace App\Mail\System;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Laravel\Cashier\Invoice;

class InvoiceFinalizedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(public Invoice $invoice, public Company $company)
    {
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
            subject: 'Sua fatura está pronta',
            metadata: [
                'invoice_number' => $this->invoice->toArray()['number'],
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.system.invoices.finalized',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(
                data: fn () => $this->invoice->pdf([
                    'vendor' => config('cashier.vendor.name'),
                    'product' => config('app.name'),
                    'street' => config('cashier.vendor.street'),
                    //                    'location' => '2000 Antwerp, Belgium',
                    'phone' => config('cashier.vendor.phone'),
                    'email' => config('mail.to.address'),
                    'url' => config('cashier.vendor.url'),
                    'vendorVat' => config('cashier.vendor.document'),
                ]),
                name: 'invoice-'.$this->invoice->toArray()['number'].'.pdf'
            ),
        ];
    }
}
