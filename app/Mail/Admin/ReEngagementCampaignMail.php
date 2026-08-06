<?php

namespace App\Mail\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReEngagementCampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $emailSubject;
    public string $emailBody;
    public string $recipientName;
    public ?string $storeName;
    public ?string $loginUrl;

    /**
     * Create a new message instance.
     */
    public function __construct(string $subject, string $body, string $recipientName = '', ?string $storeName = null, ?string $loginUrl = null)
    {
        $this->emailSubject = $subject;
        $this->recipientName = $recipientName;
        $this->storeName = $storeName;
        $this->loginUrl = $loginUrl;

        // Parse placeholders in body
        $parsedBody = str_replace(
            ['{name}', '{store_name}', '{login_url}'],
            [$recipientName ?: 'عزيزنا المستخدم', $storeName ?: 'متجرك', $loginUrl?:url('/')],
            $body
        );

        $this->emailBody = $parsedBody;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reengagement',
            with: [
                'emailSubject' => $this->emailSubject,
                'emailBody' => $this->emailBody,
                'recipientName' => $this->recipientName,
                'storeName' => $this->storeName,
                'loginUrl' => $this->loginUrl,
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
