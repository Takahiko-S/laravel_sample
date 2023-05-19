<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;



class InquiryMail extends Mailable
{
    use Queueable, SerializesModels;
    protected $request;
    /**
     * Create a new message instance.
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('webmaster@localhost.localdomain','みんなのアルバム管理者'),
            subject: 'お問い合わせありがとうございます',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            text: 'mail.inquiry',
            with:[
                'request'=> $this->request,
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
